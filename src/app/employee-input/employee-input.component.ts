import {Component, Input, ViewChild} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {IAPIConfig, ParamsBuilder} from '../../assets/constant/apiConfig';
import {BsModalRef} from 'ngx-bootstrap';
import {EmployeeItem, EmployeeJoinItem} from '../model/employer';
import {MatDatepicker} from '@angular/material';

@Component({
  selector: 'app-employee-input',
  templateUrl: './employee-input.component.html',
  styleUrls: ['./employee-input.component.scss']
})
export class EmployeeInputModalComponent extends AbstractBaseComponent {
  @Input() modalRef: BsModalRef;
  @Input() employeeItem: EmployeeItem;
  @Input() joinItem: EmployeeJoinItem;

  okDays = {
    mon: true,
    tue: true,
    web: true,
    thu: true,
    fri: true,
    sat: true,
    sun: true,
    all: true
  };

  @ViewChild(MatDatepicker) firstDatePicker: MatDatepicker<Date>;
  public firstJoinDate: Date = new Date();
  @ViewChild(MatDatepicker) startDatePicker: MatDatepicker<Date>;
  public startDate: Date = new Date();
  @ViewChild(MatDatepicker) endDatePicker: MatDatepicker<Date>;
  public endDate: Date = new Date();
  @ViewChild(MatDatepicker) okDatePicker: MatDatepicker<Date>;
  public okDate: Date = new Date();
  @ViewChild(MatDatepicker) blockDatePicker: MatDatepicker<Date>;
  public blockDate: Date = new Date();
  route: string;

  constructor(private apiConfig: IAPIConfig) {
    super();
  }

  ngOnInit() {
    super.ngOnInit();
    if (!this.employeeItem) {
      this.route = 'insert';
      this.employeeItem = {
        employeeID: 0,
        employeeName: '',
        phoneNumber: '',
        address: '',
        detailAddress: '',
        birthDate: '',
        attribute: '',
        weeklyCount: 0,
        availableDay: '',
        detail: '',
        firstJoinDate: '',
      };
      this.joinItem = {
        startDate: '',
        endDate: '',
        price: 0,
        detail: '',
      };
    } else {
      this.route = 'update';
    }
  }

  makeAllOk() {
    console.log('Rb');
    this.okDays = {
      mon: true,
      tue: true,
      web: true,
      thu: true,
      fri: true,
      sat: true,
      sun: true,
      all: true
    };
    console.log(this.okDays);
  }

  checkAllDays(key) {
    console.log(key);
    this.okDays.all = key === false;
  }

  dateToStr(date: Date) {
    const month = (((date.getMonth() + 1) < 10) ? '0' + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString());
    const day = (((date.getDate() + 1) < 10) ? '0' + date.getDate().toString() : date.getDate().toString());
    return date.getFullYear().toString() + '-' + month + '-' + day;
  }

  submit() {
    this.joinItem.startDate = this.dateToStr(this.startDate);
    this.joinItem.endDate = this.dateToStr(this.endDate);
    this.employeeItem.firstJoinDate = this.dateToStr(this.firstJoinDate);
    this.joinItem.startDate = this.employeeItem.firstJoinDate;
    const params = {
      route: this.route,
      employeeID: this.employeeItem.employeeID
    };
    if (this.route === 'update') {
      params['joinID'] = this.joinItem.joinID;
    }
    delete this.employeeItem.employeeID;
    delete this.joinItem.joinID;
    params['employeeItem'] = JSON.stringify(this.employeeItem);
    params['joinItem'] = JSON.stringify(this.joinItem)
    this.apiConfig.get<any>(`/admin/manage_employee.php`, {
      params: ParamsBuilder.from(params)
    }).subscribe(res => {
      if (res.msg) {
        alert('성공적으로 일력되었습니다.');
        this.modalRef.hide();
      }
    });
  }
}
