import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SinoDialogComponent } from './sino-dialog.component';

describe('SinoDialogComponent', () => {
  let component: SinoDialogComponent;
  let fixture: ComponentFixture<SinoDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ SinoDialogComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(SinoDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
