import {LoginComponent} from './login/login.component';
import {RouterModule, Routes} from '@angular/router';
import {ModuleWithProviders} from '@angular/core';
import {EmployerComponent} from './employer/employer.component';

export const routes: Routes = [
  {
    path: 'login',
    component: LoginComponent
  },
  {
    path: 'main',
    component: LoginComponent
  },
  {
    path: 'employer',
    component: EmployerComponent
  },
  {
    path: '**',
    redirectTo: 'main',
  }
];

export const AppRoutingModule: ModuleWithProviders = RouterModule.forRoot(routes);
