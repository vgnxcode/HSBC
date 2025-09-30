import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { HttpClient,  } from '@angular/common/http';
import {FormControl} from '@angular/forms';



@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit{


  completedURL: any = [];

  baseURL = 'https://api.vgn.in/webindex';
  baseURLSearch = 'https://api.vgn.in/webindex/search';
  
  type ="Project Type";
  location = "Location";
  startingrange = "Budget";

  searchPharam : any = {
      Type: 'apartments',
      Location: '',
      Startingrange:'100000000'
    };

  public searchInput :any ;//= this.searchPharam;;

  // searchInput = 

  constructor(
              private http: HttpClient,
              ) { 
              }

  ngOnInit(): void {
    // setTimeout(() => { this.ngOnInit() }, 1000 * 10);
    // console.log(this.searchInput);
    this.peojectList();
    // setInterval(this.peojectList(this.searchInput), 1000);
  }
  

  public search(searchData: NgForm) {
    console.log(searchData.value)
    // this.searchInput = searchData.value;
    // this.peojectList(this.searchInput);
    
    this.http.get<any>(this.baseURLSearch, {
      params: searchData.value
      // {
      //   Type: 'Apartments',
      //   Location: 'Nungambakkam',
      //   Startingrange:'100000000'
      // }
    })
    .subscribe(
      res => {
        console.log(res);
        if(res.status == 200){
          // window.location.reload();
          this.completedURL = res.responce;
          // this.type = res.responce.Type;
          // this.location = res.responce.Location;
          // this.startingrange = res.responce.Startingrange;
        } else {
          console.log(res.error);
        }
    });
  }
  


  peojectList() {
    // console.log(data)
    // this.http.get<any>(this.baseURLSearch, {
    //   params: data
    // })
    // .subscribe(
    //   res => {
    //     console.log(res);
    //     if(res.status == 200){
    //       // this.completedURL = res.responce;
    //       setTimeout(() => { this.completedURL = res.responce; }, 1000 * 10);
    //     } else {
    //       console.log(res.error);
    //     }
    // });
    this.http.get<any>(this.baseURL)
    .subscribe(
      res => {
        console.log(res);
        if(res.status == 200){
          this.completedURL = res.responce;
        } else {
          console.log(res.error);
        }
    });
  }

}
