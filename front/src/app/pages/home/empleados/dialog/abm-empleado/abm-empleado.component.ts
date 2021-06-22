import { Component, Inject, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ThemePalette } from '@angular/material/core';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { OkDialogComponent } from 'src/app/pages/shared/dialog/ok-dialog/ok-dialog.component';
import { EmpleadosService } from 'src/app/servicios/empleados.service';
import { IEmpleadoServAgregar } from 'src/app/servicios/interfaces/IEmpleadoServAgregar';
import { enumABM } from '../../../../../enum/enumABM';

@Component({
  selector: 'app-abm-empleado',
  templateUrl: './abm-empleado.component.html',
  styleUrls: ['./abm-empleado.component.scss']
})
export class AbmEmpleadoComponent implements OnInit {
  color: ThemePalette = 'warn';
  abm = enumABM;
  private matCardTitle: string = '';

  empleadoABM = new FormGroup({
    apellido: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    nombre: new FormControl('', [Validators.required, Validators.maxLength(255)]),
    email: new FormControl('', [Validators.required, Validators.email])
  });

  constructor(
    private empleadoService: EmpleadosService,
    public dialogRef: MatDialogRef<AbmEmpleadoComponent>,
    private dialogOk: MatDialog,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) { }

  ngOnInit(): void {
  }

  onSubmit() {
    let agregarEmpleadoRequest: IEmpleadoServAgregar;
    agregarEmpleadoRequest = {
      idUser: Number(localStorage.getItem('idUser')?.toString()),
      apellido: this.empleadoABM.get('apellido')?.value,
      nombre: this.empleadoABM.get('nombre')?.value,
      email: this.empleadoABM.get('email')?.value
    };

    this.empleadoService.onAgregar(agregarEmpleadoRequest)
      .subscribe(
        (response) => {
          this.dialogRef.close();
          this.openOkDialog("FORMEMPLEADOABM.tituloDialogOk", "FORMEMPLEADOABM.mensajeDialogOk");
        }
      )
  }

  cerrar() {
    this.dialogRef.close();
  }

  getMensajeErrorApellido(): string {
    var msj = '';

    if (this.empleadoABM.get('apellido')?.hasError('required')) {
      msj = 'FORMEMPLEADOABM.errorApellidoRequired';
    } else if (this.empleadoABM.get('apellido')?.hasError('maxLength')) {
      msj = 'FORMEMPLEADOABM.errorApellidoMaxLength';
    }

    return msj;
  }

  getMensajeErrorNombre(): string {
    var msj = "";

    if (this.empleadoABM.get('nombre')?.hasError('required')) {
      msj = 'FORMEMPLEADOABM.errorNombreRequired';
    } else if (this.empleadoABM.get('nombre')?.hasError('maxLength')) {
      msj = 'FORMEMPLEADOABM.errorNombreMaxLength';
    }

    return msj;
  }

  getMensajeErrorEmail(): string {
    var msj = "";

    if (this.empleadoABM.get('email')?.hasError('required')) {
      msj = 'FORMEMPLEADOABM.errorEmailRequired';
    } else if (this.empleadoABM.get('email')?.hasError('email')) {
      msj = 'FORMEMPLEADOABM.errorEmailEmail';
    }

    return msj;
  }

  openOkDialog(titulo: string, mensaje: string) {
    const dialogRef = this.dialogOk.open(OkDialogComponent, {
      data: { titulo: titulo, mensaje: mensaje }
    })
  }

}
