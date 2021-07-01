import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { Empleado } from '../clases/empleado';
import { HttpHandlerErrorService, HandleError } from '../../app/shared/services/http-handler-error.service';
import { IEmpleadoServAgregar } from './interfaces/IEmpleadoServAgregar';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  })
};

@Injectable({
  providedIn: 'root'
})
export class EmpleadosService {
  private readonly apiUrl = environment.apiUrl;
  private empleadosUrl = this.apiUrl + '/empleado';
  private handleError: HandleError;

  constructor(
    private http: HttpClient,
    private router: Router,
    private httpHandlerErrorService: HttpHandlerErrorService
  ) {
    this.handleError = httpHandlerErrorService.createHandleError('EmpleadosService');
  }

  onAgregar(agregar: IEmpleadoServAgregar): Observable<any> {
    const request = JSON.stringify(
      {
        user_id: agregar.idUser,
        apellido: agregar.apellido,
        nombre: agregar.nombre,
        email: agregar.email
      }
    );

    return this.http.post(this.empleadosUrl, request, httpOptions);
  }

  getEmpleados(): Observable<Empleado[]> {
    return this.http.get<Empleado[]>(this.empleadosUrl)
      .pipe(
        catchError(this.handleError('getPersonas', []))
      );
  }

  getEmpleado(id: number): Observable<Empleado | null> {
    return this.http.get(this.empleadosUrl + `/${id}`)
      .pipe(
        catchError(this.handleError('getPersona', null))
      );
  }
}
