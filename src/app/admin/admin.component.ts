import {Component} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {IAPIConfig} from '../../assets/constant/apiConfig';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.scss']
})
export class AdminComponent extends AbstractBaseComponent {
  callList: any[];
  constructor(private apiConfig: IAPIConfig) {
    super();
  }
}
