import {Component} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {IAPIConfig, ParamsBuilder} from '../../assets/constant/apiConfig';
import {map} from 'rxjs/operators';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent extends AbstractBaseComponent {
  name: string;
  password: string;

  constructor(private apiConfig: IAPIConfig,
              private router: Router) {
    super();
  }

  login() {
    // this.name.length == 0 ?
    this.apiConfig.get<any>(`/login/login_process.php`, {
      params: ParamsBuilder.from({
        userName: this.name,
        userPW: this.password
      })
    }).subscribe(res => {
      if (res.msg === 'OK') {
        alert('로그인되었습니다.');
        const result = res.request;
        localStorage.setItem('token', result.token);
        switch (result.userCategory) {
          case 'admin':
            this.router.navigate(['/admin'], );
            break;
          case 'employer':
            this.router.navigate(['/employer'], {
              queryParams: {
                employerID: result.employerID
              }
            });
            break;
          case 'employee':
            this.router.navigate(['/employee'], {
              queryParams: {
                employeeID: result.employeeID
              }
            });
            break;
          default:
            alert('잘못된 접근입니다. 관리자에게 문의하세요. 010-9141-7220');
            break;
        }
      }
    }, err => {
      alert(err.error.message);
    });
  }
}
