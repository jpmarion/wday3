import { Component, OnInit } from '@angular/core';

import { FormGroup, FormControl, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { User } from 'src/app/clases/user';
import { AuthService } from '../../../servicios/auth.service';
import { MatDialog } from '@angular/material/dialog';
import { RegistrarseDialogComponent } from './dialog/registrarse-dialog/registrarse-dialog.component';
import { IAuthServLogin } from 'src/app/servicios/interfaces/IAuthServLogin';


@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {
  user: User = new User();
  error: any;
  errorLogin: boolean = false;
  hide = true;

  login = new FormGroup({
    usuario: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required, Validators.minLength(8)])
  });

  constructor(
    private authServices: AuthService,
    private router: Router,
    private registerDlg: MatDialog
  ) { }

  onSubmit() {
    let loginRequest: IAuthServLogin;
    loginRequest = {
      email: this.login.get('usuario')?.value,
      password: this.login.get('password')?.value
    };

    this.authServices.onLogin(loginRequest)
      .subscribe(
        (response) => {
          this.router.navigate(['/home']);
        },
        (response) => {
          switch (response.status) {
            case 422:
              Object.keys(response.error).map((err) => {
                this.error = `${response.error[err]}`;
              })
              break;
            case 401:
              this.errorLogin = true;
              break;
            default:
              this.error = response.erro;
              break;
          }
        }
      );
  }

  get usuarioInvalid() {
    return this.login.get('usuario')?.invalid;
  }

  get passwordInvalid() {
    return this.login.get('password')?.invalid;
  }

  getMensajeErrorUsuario() {
    if (this.login.get('usuario')?.hasError) {
      if (this.login.get('usuario')?.hasError('required')) {
        return 'FORMLOGIN.errorUsuarioRequired';
      }
      return this.login.get('usuario')?.hasError('email') ? 'FORMLOGIN.errorUsuarioEmail' : '';
    }
    return '';
  }

  getMensajeErrorPassword() {
    if (this.login.get('password')?.errors) {
      console.log(this.login.get('password')?.errors);
      if (this.login.get('password')?.hasError('required')) {
        return 'FORMLOGIN.errorPasswordRequired';
      }
      if (this.login.get('password')?.errors?.minlength) {
        return 'FORMLOGIN.errorPasswordMinLength';
      }
    }
    return '';
  }

  openRegisterDialog() {
    const dialogRef = this.registerDlg.open(RegistrarseDialogComponent);
    dialogRef.afterClosed().subscribe(
      (result) => {
        console.log(result);
      }
    );
  }
}
