import {Component} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {HttpClient} from '@angular/common/http';
import {prod_api_url} from '../../assets/constant/apiConfig';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent extends AbstractBaseComponent {
  userID: string;
  password: string;
  constructor(private http: HttpClient) {
    super();
  }
  login() {
    // this.userID.length == 0 ?
    this.http.get<string>(`${prod_api_url}?route=login&userID=${this.userID}&password=${this.password}`)
      .subscribe(res => {
        localStorage.setItem('token', res);
      });
  }
}
