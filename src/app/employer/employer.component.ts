import {Component, ViewChild} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {MatDatepicker} from '@angular/material';
import {IAPIConfig, ParamsBuilder} from '../../assets/constant/apiConfig';
import {ActivatedRoute} from '@angular/router';
import {CallItem} from '../model/employer';

@Component({
  selector: 'app-employer',
  templateUrl: './employer.component.html',
  styleUrls: ['./employer.component.scss']
})
export class EmployerComponent extends AbstractBaseComponent {
  startHour: number = 8;
  endHour: number;
  minute: number = 0;
  holidayList: any[] = ['20180606', '20180613', '20180815', '20180924', '20180925', '20180926', '20181003', '20181009', '20181225'];
  ownerInfo: {
    employerID: number,
    companyName: string,
    ceoName: string,
    registerTerm: string,
    Gujwa: number,
    leftCalls: number
  } = {
    employerID: 0,
    companyName: '서버가 불안정합니다.',
    ceoName: '한번 더 새로고침해주세요',
    registerTerm: '이건 사장님의 정보가 아닙니다.',
    Gujwa: 0,
    leftCalls: 0
  };
  callItem: CallItem = {
    employerID: 0,
    startTime: '',
    endTime: '',
    workingDate: '',
    category: '',
    detail: '',
    price: 0,
  };
  callList: CallItem[];
  @ViewChild(MatDatepicker) endDatePicker: MatDatepicker<Date>;
  public endDate: Date = new Date();

  @ViewChild(MatDatepicker) listEndPicker: MatDatepicker<Date>;
  listEndDate: Date;

  @ViewChild(MatDatepicker) listStartPicker: MatDatepicker<Date>;
  listStartDate: Date;

  constructor(private apiConfig: IAPIConfig,
              private route: ActivatedRoute) {
    super();
  }

  ngOnInit() {
    super.ngOnInit();
    this.listStartDate = new Date(this.endDate.getFullYear(), this.endDate.getMonth(), 1, 0, 0, 0);
    this.listEndDate = new Date(this.endDate.getFullYear(), this.endDate.getMonth(),
      (new Date(this.endDate.getFullYear(), this.endDate.getMonth(), 0)).getDate(), 0, 0, 0);
    this._sub.push(
      this.route.queryParams.subscribe(params => {
        if (params['employerID']) {
          this.callItem.employerID = params['employerID'];

          this.getEmployerInfo(params['employerID']);
          this.getCallList(params['employerID']);
        }
      })
    );
  }

  getEmployerInfo(employerID) {
    this.apiConfig.get<any>(`/employer/employer.php`, {params: ParamsBuilder.from({route: 'myInfo', employerID})}
    ).subscribe(list => {
      if (list.msg === 'OK') {
        this.ownerInfo = list.request;
        console.log(this.ownerInfo);
        this.ownerInfo.registerTerm = (list.request.startDate + '-' + list.request.endDate).toString();
      }
    });
  }
  getCallList(employerID) {
    const startDate = this.dateToStr(this.listStartDate);
    const endDate = this.dateToStr(this.listEndDate);
    this.apiConfig.get<any>(`/employer/employer.php`, {params: ParamsBuilder.from({
        route: 'callList',
        employerID: employerID,
        startDate: startDate,
        endDate: endDate
      })}
    ).subscribe(list => {
      if (list.msg === 'OK') {
        this.callList = list.request;
      }
    });
  }

  call(isFree = false) {
    if (isFree) {
      alert('유료콜은 회당 7000원의 요금이 부과됩니다.');
    }
    if (this.callItem.workingDate === '' || this.callItem.category === '' || this.endHour === 0 || !this.startHour) {
      alert('모든 입력값을 채워주세요');
    }
    if (this.ownerInfo.leftCalls === 0) {
      alert('금주 콜 가능 횟수를 모두 사용하였습니다. 유료콜을 사용하시겠습니까?');
    }
    this.callItem.endTime = (this.endHour < 10 ? '0' + this.endHour.toString() : this.endHour.toString())
      + ':' +  (this.minute < 10 ? '0' + this.minute.toString() : this.minute.toString());
    this.callItem.startTime = (this.startHour < 10 ? '0' + this.startHour.toString() : this.startHour.toString())
    + ':' +  (this.minute < 10 ? '0' + this.minute.toString() : this.minute.toString());
    this.callItem.employerID = this.ownerInfo.employerID;
    console.log(this.callItem);
    this.apiConfig.get<any>(`/employer/employer.php`, {params: ParamsBuilder.from({
        route: 'call', callItem: JSON.stringify(this.callItem)})}
    ).subscribe(res => {
      res.msg === 'OK' ? alert('성공적으로 콜요청되었습니다.') : alert('실패.');
      this.getCallList(this.ownerInfo.employerID);
    });
  }
  callCancel(callID) {
    console.log(callID, this.ownerInfo.employerID);
    this.apiConfig.get<any>(`/employer/employer.php`, {params: ParamsBuilder.from({
        route: 'callCancel',
        employerID: this.ownerInfo.employerID,
        callID})}
    ).subscribe(res => {
      res.msg === 'OK' ? alert('성공적으로 콜취소되었습니다.') : alert('실패.');
      this.getCallList(this.ownerInfo.employerID);
    });
  }
  dateToStr(date: Date) {
    const month = (((date.getMonth() + 1) < 10) ? '0' + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString());
    const day = (((date.getDate() + 1) < 10) ? '0' + date.getDate().toString() : date.getDate().toString());
    return date.getFullYear().toString() + month + day;
  }

  setEndTime() {
    this.callItem.workingDate = this.dateToStr(this.endDate);
    if (this.endHour && this.startHour) {
      const timeTerm = (+this.endHour - +this.startHour < 0) ? +this.endHour + 24 - this.startHour : +this.endHour - +this.startHour;
      if (timeTerm < 5 && timeTerm > 0) {
        this.startHour = +this.endHour - 5;
        alert('최소 다섯시간 이상만 콜 요청이 가능합니다.');
      }
      if (!this.endHour || timeTerm < 0) {
        if (+this.startHour + 5 > 23) {
          this.endHour = +this.startHour + 5 - 24;
        } else {
          this.endHour = +this.startHour + 5;
        }
      }
      if (timeTerm > 12) {
        this.endHour = null;
        this.startHour = null;
        alert('최대 12시간까지만 콜 요청이 가능합니다.');
      }
      this.getPrice(timeTerm, this.checkIsHoliday(), this.endHour > 0 || this.endHour < 6);

    }
  }

  checkIsHoliday() {
    const isHolidayList = this.holidayList.findIndex(holiday => holiday === this.endDate) !== -1;
    return isHolidayList || this.endDate.getDay() === (0 || 6);
  }

  getPrice(timeTerm, isHoliday, isNight) {
    switch (timeTerm) {
      case 5:
        this.callItem.price = 42000;
        break;
      case 6:
        this.callItem.price = 49000;
        break;
      case 7:
        this.callItem.price = 56000;
        break;
      case 8:
        this.callItem.price = 63000;
        break;
      case 9:
        this.callItem.price = 70000;
        break;
      case 10:
        this.callItem.price = 77000;
        break;
      case 11:
        this.callItem.price = 81000;
        break;
      case 12:
        this.callItem.price = 85000;
        break;
      default:
        this.callItem.price = 0;
        break;
    }
    if (timeTerm !== 0 && isHoliday) {
      this.callItem.price = this.callItem.price + 5000;
    }
    if (timeTerm !== 0 && isNight) {
      this.callItem.price = this.callItem.price + 10000;
    }
  }
}
