import {Component} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';

@Component({
  selector: 'app-admin-menu',
  templateUrl: './admin-menu.component.html',
  styleUrls: ['./admin-menu.component.scss']
})
export class AdminMenuComponent extends AbstractBaseComponent {
  constructor() {
    super();
  }
}
