import {OnDestroy, OnInit} from '@angular/core';
import {Subscription} from 'rxjs';

export abstract class AbstractBaseComponent implements OnInit, OnDestroy {
  _sub: Subscription[];
  ngOnInit() {
    this._sub = [];
  }
  ngOnDestroy() {
    if (this._sub) {
      this._sub.forEach(sub => sub.unsubscribe());
      this._sub = [];
    }
  }
}
