import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RegistrarseDialogComponent } from './registrarse-dialog.component';

describe('RegistrarseDialogComponent', () => {
  let component: RegistrarseDialogComponent;
  let fixture: ComponentFixture<RegistrarseDialogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ RegistrarseDialogComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(RegistrarseDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
