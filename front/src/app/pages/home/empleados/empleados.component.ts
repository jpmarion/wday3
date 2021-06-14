import { Component, OnInit, ViewChild } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { MatSort } from '@angular/material/sort';
import { MatPaginator } from '@angular/material/paginator';
import { Empleado } from 'src/app/clases/empleado';
import { EmpleadosService } from 'src/app/servicios/empleados.service';
import { MatDialog, MatDialogConfig } from '@angular/material/dialog';
import { AbmEmpleadoComponent } from './dialog/abm-empleado/abm-empleado.component';
import { enumABM } from 'src/app/enum/enumABM';

@Component({
  selector: 'app-empleados',
  templateUrl: './empleados.component.html',
  styleUrls: ['./empleados.component.scss']
})
export class EmpleadosComponent implements OnInit {
  displayedColumns: string[] = ['apellido', 'nombre', 'email', 'bm'];
  empleados: Empleado[] = [];
  dataSource: any;
  abm = enumABM;

  @ViewChild(MatSort) sort: MatSort | undefined;
  @ViewChild(MatPaginator) paginator: MatPaginator | undefined;

  constructor(
    private empleadosServices: EmpleadosService,
    private abmEmpleadoDlg: MatDialog
  ) { }

  ngOnInit(): void {
    this.getEmpleados()
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  getEmpleados(): void {
    this.empleadosServices.getPersonas()
      .subscribe(
        response => {
          this.handleResponse(response);
          this.dataSource = new MatTableDataSource();
          this.dataSource.data = this.empleados;
          this.dataSource.sort = this.sort;
          this.dataSource.paginator = this.paginator;
        },
        error => this.handleError(error)
      );
  }

  protected handleResponse(response: Empleado[]) {
    this.empleados = response;
  }

  protected handleError(error: any) {
    console.error(error);
  }

  openAbmEmpleado(abm: enumABM) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.disableClose = true;
    dialogConfig.autoFocus = true;
    dialogConfig.data = {
      abm: abm.toString()
    };
    const dialogRef = this.abmEmpleadoDlg.open(AbmEmpleadoComponent, dialogConfig);
    dialogRef.afterClosed().subscribe(
      (result) => {
        console.log(result);
      }
    )
  }

}
