import { Component, Inject, OnInit } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { ISiNoDialogData } from './ISiNoDialogData';

@Component({
  selector: 'app-sino-dialog',
  templateUrl: './sino-dialog.component.html',
  styleUrls: ['./sino-dialog.component.scss']
})
export class SinoDialogComponent implements OnInit {

  constructor(
    public dialogRef: MatDialogRef<SinoDialogComponent>,
    @Inject(MAT_DIALOG_DATA) public data: ISiNoDialogData
  ) { }

  ngOnInit(): void {
  }

  si():void {
    this.dialogRef.close(true);
  }

  no():void {
    this.dialogRef.close(false);
  }
}
