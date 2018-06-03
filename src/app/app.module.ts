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

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    LoginComponent,
    EmployerComponent,
    AdminComponent,
    AdminMenuComponent
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
