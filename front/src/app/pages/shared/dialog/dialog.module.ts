import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { OkDialogComponent } from './ok-dialog/ok-dialog.component';

import { MatCardModule } from '@angular/material/card';
import { MatButtonModule } from '@angular/material/button';

import { TranslateModule } from '@ngx-translate/core';
import { SinoDialogComponent } from './sino-dialog/sino-dialog.component';


@NgModule({
  declarations: [OkDialogComponent, SinoDialogComponent],
  imports: [
    CommonModule,
    MatCardModule,
    MatButtonModule,
    TranslateModule
  ]
})
export class DialogModule { }
