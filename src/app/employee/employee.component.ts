import {Component, TemplateRef} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {IAPIConfig, ParamsBuilder} from '../../assets/constant/apiConfig';
import {AssignItem, CompanyItem, EmployeeItem, EmployeeJoinItem, JoinItem} from '../model/employer';
import {BsModalRef, BsModalService} from 'ngx-bootstrap';

@Component({
  selector: 'app-employee',
  templateUrl: './employee.component.html',
  styleUrls: ['./employee.component.scss']
})
export class EmployeeComponent extends AbstractBaseComponent {
  employeeList: (EmployeeItem & EmployeeJoinItem)[] = [];
  modalRef: BsModalRef;
  reJoinEmployeeID: string;
  deletedEmployeeID: string;
  deletedReason: string = '';
  joinHistory: Array<EmployeeJoinItem> = [];
  assignHistory: AssignItem[] = [];
  employeeItem: EmployeeItem;
  joinItem: EmployeeJoinItem;
  reJoinItem: EmployeeJoinItem = {
    startDate: '',
    endDate: '',
    price: 0,
    detail: ''
  };
  constructor(private apiConfig: IAPIConfig,
              private modalService: BsModalService) {
    super();
  }
  ngOnInit() {
    super.ngOnInit();
    this.getEmployeeList();
  }
  openModal(template: TemplateRef<any>) {
    this.modalRef = this.modalService.show(
      template,
      Object.assign({}, {class: 'modal-l'})
    );
  }

  getEmployeeList() {
    this.apiConfig.get<any>(`/admin/manage_employee.php`, {
      params: ParamsBuilder.from({
        route: 'manageEmployee'
      })
    }).subscribe(res => {
      this.employeeList = res.request;
      console.log(typeof this.employeeList);
    });
  }
  remove() {
    this.apiConfig.get<any>(`/admin/manage_employee.php`, {
      params: ParamsBuilder.from({
        route: 'delete',
        employerID: this.deletedEmployeeID,
        deleteDetail: this.deletedReason
      })
    }).subscribe(res => {
      if (res.msg === 'OK') {
        alert('삭제가 완료 되었습니다.');
        this.modalRef.hide();
        this.getEmployeeList();
      }
    });
  }

  modify(modal, employeeRow: (EmployeeItem & JoinItem)) {
    this.employeeItem = {
      employeeID: employeeRow.employeeID,
      employeeName: employeeRow.employeeName,
      phoneNumber: employeeRow.phoneNumber,
      address: employeeRow.address,
      detailAddress: employeeRow.detailAddress,
      birthDate: employeeRow.birthDate,
      attribute: employeeRow.attribute,
      weeklyCount: employeeRow.weeklyCount,
      availableDay: employeeRow.availableDay,
      detail: employeeRow['employeeDetail'],
      firstJoinDate: employeeRow.firstJoinDate,
    };
    this.joinItem = {
      joinID: employeeRow.joinID,
      startDate: employeeRow.startDate,
      endDate: employeeRow.endDate,
      price: employeeRow.price,
      detail: employeeRow['joinDetail'],
    };
    this.openModal(modal);
  }

  getJoinHistory(employeeID, modal) {
    this.apiConfig.get<any>(`/admin/manage_employee.php`, {
      params: ParamsBuilder.from({
        route: 'joinHistory',
        employeeID: employeeID
      })
    }).subscribe(res => {
      if (res.msg === 'OK') {
        this.joinHistory = res.request;
        console.log(this.joinHistory, '왜ㅐㅐ');
        this.openModal(modal);
      }
    });
  }

  getAssignHistory(employeeID) {
    this.apiConfig.get<any>(`/admin/manage_employee.php`, {
      params: ParamsBuilder.from({
        route: 'assignHistory',
        employeeID: employeeID
      })
    }).subscribe(res => {
      this.assignHistory = res.request;
      console.log(res);
    });
  }

  submit() {
    this.apiConfig.get<any>(`/admin/manage_employee.php`, {
      params: ParamsBuilder.from({
        route: 'reJoin',
        employeeID: this.reJoinEmployeeID,
        joinItem: JSON.stringify(this.reJoinItem)
      })
    }).subscribe(res => {
      if (res.msg === 'OK') {
        alert('재가입 완료');
      } else {
        alert(res.msg);
      }
    });
  }
}
