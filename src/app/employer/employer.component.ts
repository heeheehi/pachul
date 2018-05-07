import {Component, ViewChild} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {MatDatepicker} from '@angular/material';
import {HttpClient} from '@angular/common/http';
import {prod_api_url} from '../../assets/constant/apiConfig';

@Component({
  selector: 'app-employer',
  templateUrl: './employer.component.html',
  styleUrls: ['./employer.component.scss']
})
export class EmployerComponent extends AbstractBaseComponent {
  callList: any[];
  selectedTab: string;
  time: string;
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
    startHour: string,
    startMin: string,
    endHour: string,
    endMin: string,
    category: string,
    etc: string
  } = {
    companyID: 0,
    date: '',
    startHour: '',
    startMin: '',
    endHour: '',
    endMin: '',
    category: '',
    etc: ''
  };
  @ViewChild(MatDatepicker) endDatePicker: MatDatepicker<Date>;
  public endDate: Date = new Date();
  constructor(private http: HttpClient) {
    super();
  }
  ngOnInit() {
    super.ngOnInit();
    this.getEmployerInfo();
  }
  getEmployerInfo() {
    this.http.get<any>(``)
      .subscribe(list => {
        this.ownerInfo = list;
      });
  }

  call() {
    this.http.get<string>(`${prod_api_url}?route=call&time=${this.callItem}`)
      .subscribe(res => {
        res === 'OK' ? alert('성공적으로 콜요청되었습니다.') : alert('실패.');
      });
  }
}
