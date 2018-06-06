import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import {LoginComponent} from './login/login.component';
import {COMPOSITION_BUFFER_MODE, FormsModule} from '@angular/forms';
import {HeaderComponent} from './header/header.component';
import {AppRoutingModule} from './app.route';
import {EmployerComponent} from './employer/employer.component';
import {HttpClientModule} from '@angular/common/http';
import {
  MatCheckboxModule,
  MatDatepickerModule,
  MatFormFieldModule,
  MatInputModule,
  MatMenuModule,
  MatNativeDateModule,
  MatTabsModule
} from '@angular/material';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {CommonModule} from '@angular/common';
import {AdminComponent} from './admin/admin.component';
import {IAPIConfig} from '../assets/constant/apiConfig';
import {AdminMenuComponent} from './admin-menu/admin-menu.component';
import {OverlayContainer} from '@angular/cdk/overlay';
import {ModalModule, setTheme} from 'ngx-bootstrap';
import {RouterModule} from '@angular/router';
import {StoreInputModalComponent} from './store-input-modal/store-input-modal.component';
import {JoinListModalComponent} from './join-list-modal/join-list-modal.component';
import {EmployeeComponent} from './employee/employee.component';
import {EmployeeInputModalComponent} from './employee-input/employee-input.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    LoginComponent,
    EmployerComponent,
    AdminComponent,
    AdminMenuComponent,
    StoreInputModalComponent,
    JoinListModalComponent,
    EmployeeComponent,
    EmployeeInputModalComponent
  ],
  imports: [
    CommonModule,
    BrowserModule,
    RouterModule,
    FormsModule,
    HttpClientModule,
    MatTabsModule,
    MatInputModule,
    MatDatepickerModule,
    MatFormFieldModule,
    MatNativeDateModule,
    MatCheckboxModule,
    MatMenuModule,
    BrowserAnimationsModule,
    ModalModule.forRoot()
  ],
  providers: [MatDatepickerModule, IAPIConfig,
    {
      provide: COMPOSITION_BUFFER_MODE,
      useValue: true
    },
    ...AppRoutingModule.providers
  ],
  bootstrap: [AppComponent]
})
export class AppModule {
  constructor(overlayContainer: OverlayContainer) {
    overlayContainer.getContainerElement().classList.add('unicorn-dark-theme');
    setTheme('bs4');
  }
}
