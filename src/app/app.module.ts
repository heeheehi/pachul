import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import {LoginComponent} from './login/login.component';
import {FormsModule} from '@angular/forms';
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
    FormsModule,
    HttpClientModule,
    MatTabsModule,
    MatInputModule,
    MatDatepickerModule,
    MatFormFieldModule,
    MatNativeDateModule,
    MatMenuModule,
    BrowserAnimationsModule,
    AppRoutingModule
  ],
  providers: [MatDatepickerModule, IAPIConfig],
  bootstrap: [AppComponent]
})
export class AppModule { }
