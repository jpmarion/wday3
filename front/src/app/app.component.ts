import { Component } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'Wday3';

  constructor(private translate: TranslateService) {
    translate.setDefaultLang('es');
    translate.addLangs(['en','br']);

    const browserLang =translate.getBrowserLang();
    translate.use(browserLang.match(/en|br/)? browserLang:'es');
  }
}
