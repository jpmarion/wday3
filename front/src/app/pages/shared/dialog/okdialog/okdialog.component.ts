import { Component, Inject, OnInit } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { IOkDialogData } from './IOkDialogData';

@Component({
  selector: 'app-okdialog',
  templateUrl: './okdialog.component.html',
  styleUrls: ['./okdialog.component.scss']
})
export class OkdialogComponent implements OnInit {

  constructor(
    public dialogRef: MatDialogRef<OkdialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: IOkDialogData
  ) { }

  ngOnInit(): void {
  }

  ok() {
    this.dialogRef.close();
  }

}
