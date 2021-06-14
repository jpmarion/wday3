import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AbmEmpleadoComponent } from './abm-empleado.component';

describe('AbmEmpleadoComponent', () => {
  let component: AbmEmpleadoComponent;
  let fixture: ComponentFixture<AbmEmpleadoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AbmEmpleadoComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AbmEmpleadoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
