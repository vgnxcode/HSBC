import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {MatSnackBar} from '@angular/material/snack-bar';
import { NgForm } from '@angular/forms';
import{Router} from '@angular/router';

import{SearchComponent} from '../search/search.component';

import { Slick } from 'ngx-slickjs';

import { ProjectDataService } from '../project-data.service';

declare var $:any;


@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css'],
  providers: [SearchComponent],
})
export class HomeComponent implements OnInit {
  allURL: any = [];
  baseURL = 'https://api.vgn.in/webindex';

  featuredProjectURL: any = [];
  logoURL = '';

  type ="Project Type";
  location = "Location";
  startingrange = "Budget";

share (filesArray:any){
  try {
     navigator.share(filesArray);
    // resultPara.textContent = 'MDN shared successfully';
  } catch (err) {
    // resultPara.textContent = `Error: ${err}`;
  }
}

  constructor(
              private http: HttpClient,
              private snackBar: MatSnackBar,
              private router:Router,
              private search:SearchComponent,
              private projectservice:ProjectDataService
              ){}

  ngOnInit(): void {
    this.peojectList();
  }

  onSubmit(searchData: NgForm) {
    this.router.navigate(['/search']);
    // this.search.ngOnInit();
    this.search.search(searchData);
  }

  peojectList() {
    this.http.get<any>(this.baseURL)
    .subscribe(
      res => {
        console.log(res);
        if(res.status == 200){
          this.allURL = res.responce;
          this.projectservice.setProject(res.responce);
        } else {
          console.log(res.error);
        }
        
    });
  }
}
