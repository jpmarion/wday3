import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { OkdialogComponent } from './okdialog/okdialog.component';
import { TranslateModule } from '@ngx-translate/core';

@NgModule({
  declarations: [OkdialogComponent],
  imports: [
    CommonModule,
    TranslateModule
  ],
  exports: [
    TranslateModule,
    OkdialogComponent
  ]
})
export class DialogModule { }
