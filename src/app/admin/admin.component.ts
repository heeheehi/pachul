import {Component, Input, TemplateRef} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {IAPIConfig, ParamsBuilder} from '../../assets/constant/apiConfig';
import {BsModalRef, BsModalService} from 'ngx-bootstrap';
import {AssignItem, CompanyItem, EmployerItem, JoinItem} from '../model/employer';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.scss']
})
export class AdminComponent extends AbstractBaseComponent {
  callList: (EmployerItem & JoinItem & CompanyItem)[] = [];
  modalRef: BsModalRef;
  deletedEmployerID: string;
  deletedReason: string = '';
  reJoinEmployerID: string;
  joinHistory: Array<JoinItem> = [];
  assignHistory: AssignItem[] = [];
  employerItem: EmployerItem;
  companyItem: CompanyItem;
  joinItem: JoinItem;
  reJoinItem: JoinItem = {
    startDate: '',
    endDate: '',
    price: 0,
    Gujwa: 1,
    detail: ''
  };

  constructor(private apiConfig: IAPIConfig,
              private modalService: BsModalService) {
    super();
  }

  ngOnInit() {
    super.ngOnInit();
    this.getCompayList();
    console.log(typeof this.callList, this.joinHistory);
  }

  openModal(template: TemplateRef<any>) {
    this.modalRef = this.modalService.show(
      template,
      Object.assign({}, {class: 'modal-l'})
    );
  }

  getCompayList() {
    this.apiConfig.get<any>(`/admin/manage_employer.php`, {
      params: ParamsBuilder.from({
        route: 'manageEmployer'
      })
    }).subscribe(res => {
      this.callList = res.request;
      console.log(typeof this.callList);
    });
  }

  remove() {
    this.apiConfig.get<any>(`/admin/manage_employer.php`, {
      params: ParamsBuilder.from({
        route: 'delete',
        employerID: this.deletedEmployerID,
        deleteDetail: this.deletedReason
      })
    }).subscribe(res => {
      if (res.msg === 'OK') {
        this.modalRef.hide();
        alert('삭제가 완료 되었습니다.');
        this.getCompayList();
      }
    });
  }

  modify(modal, callItem) {
    this.employerItem = {
      employerID: callItem.employerID,
      ceoName: callItem.ceoName,
      ceoPhoneNumber: callItem.ceoPhoneNumber,
      leftCalls: callItem.leftCalls,
      firstJoinDate: callItem.firstJoinDate,
      detail: callItem.employerDetail
    };
    this.joinItem = {
      joinID: callItem.joinID,
      startDate: callItem.startDate,
      endDate: callItem.endDate,
      price: callItem.price,
      detail: callItem.joinDetail,
      Gujwa: callItem.Gujwa
    };
    this.companyItem = {
      companyID: callItem.companyID,
      companyName: callItem.companyName,
      companyPhoneNumber: callItem.companyPhoneNumber,
      address: callItem.address,
      detailAddress: callItem.detailAddress
    };
    this.openModal(modal);
  }

  getJoinHistory(employerID, modal) {
    this.apiConfig.get<any>(`/admin/manage_employer.php`, {
      params: ParamsBuilder.from({
        route: 'joinHistory',
        employerID
      })
    }).subscribe(res => {
      console.log(res);
      this.joinHistory = res.request;
      console.log(this.joinHistory, '왜ㅐㅐ');
      this.openModal(modal);
    });
  }

  getAssignHistory(employerID) {
    this.apiConfig.get<any>(`/admin/manage_employer.php`, {
      params: ParamsBuilder.from({
        route: 'assignHistory',
        employerID
      })
    }).subscribe(res => {
      this.assignHistory = res.request;
      console.log(res);
    });
  }

  submit() {
    this.apiConfig.get<any>(`/admin/manage_employer.php`, {
      params: ParamsBuilder.from({
        route: 'reJoin',
        employerID: this.reJoinEmployerID,
        joinItem: JSON.stringify(this.reJoinItem)
      })
    }).subscribe(res => {
      if (res.msg === 'OK') {
        alert('재가입 완료');
        this.modalRef.hide();
      } else {
        alert(res.msg);
      }
    });
  }
}
