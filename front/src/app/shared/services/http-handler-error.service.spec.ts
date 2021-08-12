import { TestBed } from '@angular/core/testing';

import { HttpHandlerErrorService } from './http-handler-error.service';

describe('HttpHandlerErrorService', () => {
  let service: HttpHandlerErrorService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(HttpHandlerErrorService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
