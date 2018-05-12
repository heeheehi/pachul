import {Component} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.scss']
})
export class AdminComponent extends AbstractBaseComponent {
  callLits: any[];
  constructor() {
    super();
  }
}
