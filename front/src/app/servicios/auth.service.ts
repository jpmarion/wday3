import { HttpClient, HttpHeaders, HttpParams, HttpErrorResponse, HttpResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Observable, throwError } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

import { environment } from 'src/environments/environment';
import { User } from '../clases/user';
import { IAuthServLogin } from './interfaces/IAuthServLogin';
import { IAuthServRegistrarse } from './interfaces/iAuthServRegistrarse';

const httpOptions = {
  headers: new HttpHeaders({
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  })
};

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  public currentUser: User | undefined;
  private readonly apiUrl = environment.apiUrl;
  private registerUrl = this.apiUrl + '/auth/registrarse';
  private loginUrl = this.apiUrl + '/auth/login';
  private loguotUrl = this.apiUrl + '/auth/logout';
  private meUrl = this.apiUrl + '/me';

  constructor(
    private http: HttpClient,
    private router: Router
  ) { }

  onRegistrarse(registrarse: IAuthServRegistrarse): Observable<any> {
    const request = JSON.stringify(
      { name: registrarse.name, email: registrarse.email, password: registrarse.password }
    );

    return this.http.post(this.registerUrl, request, httpOptions);
  }

  onLogin(login: IAuthServLogin): Observable<User> {
    const request = JSON.stringify({ email: login.email, password: login.password });

    return this.http.post(this.loginUrl, request, httpOptions)
      .pipe(
        map((response: any) => {
          const token: string = response['access_token'];
          if (token) {
            this.setToken(token);
            // this.getUser().subscribe();
          }
          return response;
        }),
        catchError(error => this.handleError(error))
      );
  }

  onLogout(): Observable<any> {
    return this.http.get(this.loguotUrl, httpOptions)
      .pipe(
        tap(() => {
          localStorage.removeItem('token');
          this.router.navigate(['']);
        })
      );
  }

  setToken(token: string): void {
    return localStorage.setItem('token', token);
  }

  getToken(): any {
    return localStorage.getItem('token');
  }

  getUser(): Observable<User> {
    return this.http.get(this.meUrl)
      .pipe(
        tap((user: User) => {
          this.currentUser = user;
        })
      );
  }

  isAuthenticated(): boolean {
    const token = this.getToken();
    if (token) {
      return true;
    }
    return false;
  }

  private handleError(error: HttpErrorResponse) {
    if (error.error instanceof ErrorEvent) {
      console.error('Un error a ocurrido:', error.error.message);
    } else {
      return throwError(error);
    }
    return throwError('Ooohh algo erroneo a sucedido aqui; por favor trate nuevamente dentro de un momento');
  }
}
