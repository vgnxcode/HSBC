import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class ProjectDataService {

  private project$ = new BehaviorSubject<any>({});
  selectedProject$ = this.project$.asObservable();
  
  constructor() {}

  setProject(project: any) {
    this.project$.next(project);
  }
}
