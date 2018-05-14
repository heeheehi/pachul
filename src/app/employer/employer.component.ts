import {Component, ViewChild} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {MatDatepicker} from '@angular/material';
import {IAPIConfig, ParamsBuilder} from '../../assets/constant/apiConfig';

@Component({
  selector: 'app-employer',
  templateUrl: './employer.component.html',
  styleUrls: ['./employer.component.scss']
})
export class EmployerComponent extends AbstractBaseComponent {
  callList: any[];
  selectedTab: string;
  startHour: number = 8;
  endHour: number;
  minute: number = 0;
  holidayList: any[] = ['2018'];
  ownerInfo: {
    ownerName: string,
    storeName: string,
    registerTerm: string,
    accountCnt: number,
    callCnt: number
  } = {
    ownerName: '비야 부대찌개',
    storeName: '최인규',
    registerTerm: '2018.02.01-2018.12.31',
    accountCnt: 0,
    callCnt: 0
  };
  callItem: {
    companyID: number,
    date: string,
    startTime: string,
    endTime: string,
    category: string,
    etc: string
    price: number
  } = {
    companyID: 0,
    date: '',
    startTime: '',
    endTime: '',
    category: '',
    etc: '',
    price: 0
  };
  @ViewChild(MatDatepicker) endDatePicker: MatDatepicker<Date>;
  public endDate: Date = new Date();

  constructor(private apiConfig: IAPIConfig) {
    super();
  }

  ngOnInit() {
    super.ngOnInit();
    this.getEmployerInfo();
  }

  getEmployerInfo() {
    this.apiConfig.get<any>(``, {params: ParamsBuilder.from({route: 'myInfo'})}
    ).subscribe(list => {
      this.ownerInfo = list;
    });
  }

  call() {
    this.callItem.endTime = this.endHour.toString() + this.minute;
    this.callItem.endTime = this.startHour.toString() + this.minute;
    this.apiConfig.get<string>(``, {params: ParamsBuilder.from({})}
    ).subscribe(res => {
      res === 'OK' ? alert('성공적으로 콜요청되었습니다.') : alert('실패.');
    });
  }

  setEndTime() {
    this.callItem.date = this.endDate.getFullYear().toString() + this.endDate.getMonth().toString() + this.endDate.getDate().toString();
    if (this.endHour && this.startHour) {
      const timeTerm = (+this.endHour - +this.startHour < 0) ? +this.endHour + 24 - this.startHour : +this.endHour - +this.startHour;
      console.log(timeTerm, '몇시간이냐', this.startHour, this.endHour);
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
