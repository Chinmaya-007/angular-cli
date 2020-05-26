import { Component,OnInit } from '@angular/core';
import { Router, Routes, Event, NavigationCancel,NavigationError,NavigationStart,NavigationEnd, RouterEvent } from '@angular/router';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  showLoadingIndicator = false;
  loggedIn=false;
  bidderLoggedIn=false;
  title = 'badmintonProject';
  show="boolean";
  router: string;
  constructor(private _router: Router){
    this.router = _router.url;
    this._router.events.subscribe((RouterEvent: Event)=>{
      if(RouterEvent instanceof NavigationStart){
        this.showLoadingIndicator=true;
      }
      if(RouterEvent instanceof NavigationEnd ||RouterEvent instanceof NavigationCancel || RouterEvent instanceof NavigationError  ){
        this.showLoadingIndicator=false;
      }
    })
  }
  
  ngOnInit() {
    this.show="true"
  };
  display(value: boolean) {
    this.showLoadingIndicator=value;
  };
  signOut(){
    window.localStorage.removeItem('id');
    window.localStorage.removeItem('token');
    if(this.loggedIn){
      this.loggedIn=false;
      this._router.navigate(['login']);
    }
    else if(this.bidderLoggedIn){
      this.bidderLoggedIn=false;
      this._router.navigate(['bidder']);
    }
  }
}
