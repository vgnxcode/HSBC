import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ProjectDataService } from '../project-data.service';


@Component({
  selector: 'app-completed-project',
  templateUrl: './completed-project.component.html',
  styleUrls: ['./completed-project.component.css']
})
export class CompletedProjectComponent implements OnInit {

  completedURL: any = [];


  constructor(
              private http: HttpClient,
              private projectService:ProjectDataService
              ) { }

  ngOnInit(): void {
    this.projectService.selectedProject$.subscribe((value) => {
      // console.log(value);
      this.completedURL = value;
    });
  }
  
}
