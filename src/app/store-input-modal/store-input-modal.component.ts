import {Component, Input} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {IAPIConfig, ParamsBuilder} from '../../assets/constant/apiConfig';
import {BsModalRef} from 'ngx-bootstrap';
import {CompanyItem, EmployerItem, JoinItem} from '../model/employer';

@Component({
  selector: 'app-store-input',
  templateUrl: './store-input-modal.component.html',
  styleUrls: ['./store-input-modal.component.scss']
})
export class StoreInputModalComponent extends AbstractBaseComponent {
  @Input() modalRef: BsModalRef;
  @Input() employerItem: EmployerItem;
  @Input() companyItem: CompanyItem;
  @Input() joinItem: JoinItem;
  route: string;

  constructor(private apiConfig: IAPIConfig) {
    super();
  }

  ngOnInit() {
    super.ngOnInit();
    console.log(this.employerItem);
    if (!this.employerItem) {
      this.route = 'insert';
      this.employerItem = {
        employerID: '0',
        ceoName: '',
        ceoPhoneNumber: '',
        firstJoinDate: '',
        leftCalls: 3,
        detail: ''
      };
      this.companyItem = {
        companyName: '',
        companyPhoneNumber: '',
        address: '',
        detailAddress: '',
      };
      this.joinItem = {
        startDate: '',
        endDate: '',
        price: 0,
        Gujwa: 1,
        detail: '',
      };
    } else {
      this.route = 'update';
    }
  }

  submit() {
    this.joinItem.startDate = this.employerItem.firstJoinDate;
    const params = {
      route: this.route,
      employerID: this.employerItem.employerID,
      employerItem: JSON.stringify(this.employerItem),
      joinItem: JSON.stringify(this.joinItem),
      companyItem: JSON.stringify(this.companyItem)
    };
    delete this.employerItem.employerID;
    if (this.route === 'update') {
      params['joinID'] = this.joinItem.joinID;
      params['companyID'] = this.companyItem.companyID;
      delete this.joinItem.joinID;
      delete this.companyItem.companyID;
    }
    this.apiConfig.get<any>(`/admin/manage_employer.php`, {
      params: ParamsBuilder.from(params)
    }).subscribe(res => {
      if (res.msg) {
        alert('성공적으로 일력되었습니다.');
        this.modalRef.hide();
      }
    });
  }
}
