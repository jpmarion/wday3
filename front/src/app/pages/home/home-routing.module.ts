import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './home.component';
import { AuthGuard } from '../auth/guards/auth.guard';
import { EmpleadosComponent } from './empleados/empleados.component';

const routes: Routes = [
  {
    path: 'home',
    component: HomeComponent,
    canActivate: [AuthGuard],
    children: [
      { path: '', component: EmpleadosComponent, outlet: 'principalbar' },
      { path: 'empleados', component: EmpleadosComponent, outlet: 'principalbar' }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class HomeRoutingModule { }
