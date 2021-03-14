import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ThemePalette } from '@angular/material/core';
import { MatDialog, MatDialogRef } from '@angular/material/dialog';
import { OkdialogComponent } from 'src/app/pages/shared/dialog/okdialog/okdialog.component';
import { AuthService } from 'src/app/servicios/auth.service';
import { IAuthServRegistrarse } from 'src/app/servicios/interfaces/iAuthServRegistrarse';

@Component({
  selector: 'app-registrarse-dialog',
  templateUrl: './registrarse-dialog.component.html',
  styleUrls: ['./registrarse-dialog.component.scss']
})
export class RegistrarseDialogComponent implements OnInit {

  color: ThemePalette = 'warn';
  errorRegistrar: boolean = false;
  register = new FormGroup({
    usuario: new FormControl('', [Validators.required, Validators.email]),
    password: new FormControl('', [Validators.required, Validators.minLength(8)])
  });


  constructor(
    private authService: AuthService,
    public dialogRef: MatDialogRef<RegistrarseDialogComponent>,
    private dialogOk: MatDialog
  ) { }

  ngOnInit(): void {
  }

  onSubmit() {

    let registerRequest: IAuthServRegistrarse;
    registerRequest = {
      name: '',
      email: this.register.get('usuario')?.value,
      password: this.register.get('password')?.value
    };

    this.authService.onRegistrarse(registerRequest)
      .subscribe(
        (response) => {
          this.dialogRef.close();
          this.openOkDialog("FORMREGISTER.tituloDialogOk", "FORMREGISTER.mensajeDialogOk");
        },
        (response) => {
          switch (response.status) {
            case 422:
              console.log(response.error);
              this.errorRegistrar = true;
              break;
            default:
              console.log(response.error);
              this.errorRegistrar = true;
              break;
          }
        }
      )
  }

  get ErrorRegistrar() {
    return this.errorRegistrar;
  }

  get usuarioInvalid() {
    return this.register.get('usuario')?.invalid;
  }

  get passwordInvalid() {
    return this.register.get('password')?.invalid;
  }

  getMensajeErrorUsuario() {
    var msj = '';
    if (this.register.get('usuario')?.hasError) {
      if (this.register.get('usuario')?.hasError('required')) {
        msj = 'FORMREGISTER.errorUsuarioRequired';
      }
      if (this.register.get('usuario')?.hasError('email')) {
        msj = 'FORMREGISTER.errorUsuarioEmail';
      }
    }
    return msj;
  }

  getMensajeErrorPassword() {
    var msj = '';
    if (this.register.get('password')?.hasError) {
      if (this.register.get('password')?.hasError('required')) {
        msj = 'FORMREGISTER.errorPasswordRequired';
      }
      if (this.register.get('usuario')?.errors?.minlength) {
        msj = 'FORMREGISTER.errorPasswordMinLength';
      }
    }
    return msj;
  }

  openOkDialog(titulo: string, mensaje: string) {
    const dialogRef = this.dialogOk.open(OkdialogComponent, {
      data: { titulo: titulo, mensaje: mensaje }
    })
  }
}
