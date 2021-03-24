import { Component, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { AuthService } from 'src/app/servicios/auth.service';
import { SinoDialogComponent } from '../../shared/dialog/sino-dialog/sino-dialog.component';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.scss']
})
export class NavComponent implements OnInit {

  constructor(
    private sinoDialog: MatDialog,
    private authService: AuthService
  ) { }

  ngOnInit(): void {
  }

  Salir(): void {
    const dialogRef = this.sinoDialog.open(SinoDialogComponent, {
      data: { titulo: "NAV.dataTituloSinoSalir", mensaje: "NAV.dataMensajeSinoSalir" }
    });

    dialogRef.afterClosed().subscribe(result => {
      if (result) {
        this.authService.onLogout().subscribe();
      }

    });
  }
}
