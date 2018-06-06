import {LoginComponent} from './login/login.component';
import {RouterModule, Routes} from '@angular/router';
import {ModuleWithProviders} from '@angular/core';
import {EmployerComponent} from './employer/employer.component';
import {AdminComponent} from './admin/admin.component';
import {EmployeeComponent} from './employee/employee.component';

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
    path: 'admin',
    component: AdminComponent
  },
  {
    path: 'admin/employee',
    component: EmployeeComponent
  },
  {
    path: '**',
    redirectTo: 'main',
  }
];

export const AppRoutingModule: ModuleWithProviders = RouterModule.forRoot(routes);
