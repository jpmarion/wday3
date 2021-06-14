import { Component, Inject, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ThemePalette } from '@angular/material/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
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
    public dialogRef: MatDialogRef<AbmEmpleadoComponent>,
    @Inject(MAT_DIALOG_DATA) public data: any
  ) { }

  ngOnInit(): void {
  }

  onSubmit() { }

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

}
