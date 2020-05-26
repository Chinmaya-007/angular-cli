import { Component, OnInit } from '@angular/core';
import {Router} from "@angular/router";
import {ApiService} from "../core/api.service";
import { AppComponent } from '../app.component';

@Component({
  selector: 'app-biddinghistory',
  templateUrl: './biddinghistory.component.html',
  styleUrls: ['./biddinghistory.component.css']
})
export class BiddinghistoryComponent implements OnInit {
  showLoadingIndicator=false;

  constructor(private router: Router, private apiService: ApiService, private appComponent: AppComponent) { }
  id:any;
  users:any=[{}];
  name:any=[{}];
  ngOnInit(): void {
    if(!window.localStorage.getItem('token')) {
      this.router.navigate(['login']);
      return;
    }
    this.showLoadingIndicator=true;
    this.id=window.localStorage.getItem('id');
    this.appComponent.bidderLoggedIn=true;
    this.apiService.bidddinghistory(this.id).subscribe(
        data => {
          this.users = data;
          this.showLoadingIndicator=false;
        }
      );
      
  }

  getName(id:number){
      return this.apiService.getNameById(id)
  }
  

}
