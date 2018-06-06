import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {Component, Input} from '@angular/core';
import {JoinItem} from '../model/employer';
import {BsModalRef} from 'ngx-bootstrap';

@Component({
  selector: 'app-join-list',
  templateUrl: './join-list-modal.component.html',
  // styleUrls: ['./admin.component.scss']
})
export class JoinListModalComponent extends AbstractBaseComponent {
  @Input() joinHistory: JoinItem[];
  @Input() modalRef: BsModalRef;
  constructor() {
    super();
  }
  ngOnInit() {
    console.log(this.joinHistory, this.modalRef);
  }
}
