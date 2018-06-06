import {st} from '@angular/core/src/render3';

export class CallItem {
  callID?: number;
  employerID: number;
  startTime: string;
  endTime: string;
  category: string;
  detail: string;
  price: number;
  employeeName?: string;
  workingDate?: string;
  isCancel?: number;
}

export class JoinItem {
  joinID?: number;
  startDate: string;
  endDate: string;
  price: number;
  Gujwa: number;
  detail: string;
}
export class CompanyItem {
  companyID?: number;
  companyName: string;
  companyPhoneNumber: string;
  address: string;
  detailAddress: string;
}
export class EmployerItem {
  employerID?: string;
  ceoName: string;
  ceoPhoneNumber: string;
  firstJoinDate: string;
  leftCalls: number;
  detail: string;
}
export class AssignItem {
  assignID?: string;
}
export class EmployeeItem {
  employeeID: number;
  employeeName: string;
  birthDate: string;
  age?: number;
  detail: string;
  deleted?: number;
  phoneNumber: string;
  address: string;
  detailAddress: string;
  attribute: string;
  weeklyCount: number;
  availableDay: string;
  firstJoinDate: string;
  startDate?: string;
  endDate?: string;
}
export class EmployeeJoinItem {
  joinID?: number;
  startDate: string;
  endDate: string;
  price: number;
  detail: string;
}
