import {Component} from '@angular/core';
import {AbstractBaseComponent} from '../base/AbstractBaseComponent';
import {ActivatedRoute, NavigationEnd, Router} from '@angular/router';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent extends AbstractBaseComponent {
  url: string = '';
  constructor(private router: Router) {
    super();
  }

  ngOnInit() {
    this._sub.push(
      this.router.events.subscribe(params => {
        if (params instanceof NavigationEnd) {
          this.url = params.url.toString().split('/')[1];
        }
      })
    );
  }
}
