import {Component, TemplateRef} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {IAPIConfig} from '../../assets/constant/apiConfig';
import {BsModalRef, BsModalService} from 'ngx-bootstrap';
import {st} from '@angular/core/src/render3';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.scss']
})
export class AdminComponent extends AbstractBaseComponent {
  callList: any[];
  modalRef: BsModalRef;
  storeItem: {
    storeName: string,
    employerName: string,
    storePhone: string,
    employerPhone: string,
    address: string,
    detailAddress: string,
    firstJoinDate: string,
    currentJoinDate: string,
    endDate: string,
    price: number,
    gujwa: number,
    callCnt: number,
    storeDetail: string,
    joinDetail: string
  } = {
    storeName: '',
    employerName: '',
    storePhone: '',
    employerPhone: '',
    address: '',
    firstJoinDate: '',
    currentJoinDate: '',
    endDate: '',
    detailAddress: '',
    price: 0,
    gujwa: 1,
    callCnt: 3,
    storeDetail: '',
    joinDetail: ''
  };

  constructor(private apiConfig: IAPIConfig,
              private modalService: BsModalService) {
    super();
  }

  openModal(template: TemplateRef<any>) {
    this.modalRef = this.modalService.show(
      template,
      Object.assign({}, {class: 'modal-l'})
    );
  }

  submit() {
  }
}
