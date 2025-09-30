import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ProjectDataService } from '../project-data.service';

@Component({
  selector: 'app-ongoing-project',
  templateUrl: './ongoing-project.component.html',
  styleUrls: ['./ongoing-project.component.css']
})
export class OngoingProjectComponent implements OnInit {
  allURL: any = [];

  constructor(
              private http: HttpClient,
              private projectService:ProjectDataService
              ) { }

  ngOnInit(): void {
    this.projectService.selectedProject$.subscribe((value) => {
      // console.log(value);
      this.allURL = value;
    });
  }
  

  share (filesArray:any){
    try {
       navigator.share(filesArray);
      // resultPara.textContent = 'MDN shared successfully';
    } catch (err) {
      // resultPara.textContent = `Error: ${err}`;
    }
  }

  
}
