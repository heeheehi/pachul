import {Component} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent extends AbstractBaseComponent {
  constructor() {
    super();
  }
}
