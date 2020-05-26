import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ApiService} from "./core/api.service";
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HomeComponent } from './home/home.component';
import { AboutComponent } from './about/about.component';
import { LeaderboardComponent } from './leaderboard/leaderboard.component';
import { AdministrationComponent } from './administration/administration.component';
import { GalleryComponent } from './gallery/gallery.component';
import { ContactusComponent } from './contactus/contactus.component';
import { LoginComponent } from './login/login.component';
import { HTTP_INTERCEPTORS, HttpClientModule} from "@angular/common/http";
import { TokenInterceptor} from "./core/interceptor";
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AddUserComponent } from './add-user/add-user.component';
import { ListUserComponent } from './list-user/list-user.component';
import { BidderComponent } from './bidder/bidder.component';
import { BiddingComponent } from './bidding/bidding.component';
import { ResultComponent } from './result/result.component';
import { BiddinghistoryComponent } from './biddinghistory/biddinghistory.component';
import {DatePipe} from '@angular/common';


const appRoutes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'about', component: AboutComponent },
  { path: 'leaderboard', component: LeaderboardComponent },
  { path: 'administration', component: AdministrationComponent },
  { path: 'gallery', component: GalleryComponent },
  { path: 'contactus', component: ContactusComponent },
  { path: 'login' , component: LoginComponent },
  { path: 'add-user' , component: AddUserComponent },
  { path: 'list-user' , component: ListUserComponent },
  { path: 'bidder' , component: BidderComponent },
  { path: 'bidding' , component: BiddingComponent },
  { path: 'biddinghistory' , component: BiddinghistoryComponent },
  { path: 'result' , component: ResultComponent },
  
  
];
@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    AboutComponent,
    LeaderboardComponent,
    AdministrationComponent,
    GalleryComponent,
    ContactusComponent,
    LoginComponent,
    AddUserComponent,
    ListUserComponent,
    BidderComponent,
    BiddingComponent,
    ResultComponent,
    BiddinghistoryComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    FormsModule,
    HttpClientModule,
    ReactiveFormsModule,
    RouterModule.forRoot(
      appRoutes,
      { enableTracing: true } // <-- debugging purposes only
    )
  ],
  providers:  [ApiService,DatePipe, {provide: HTTP_INTERCEPTORS,
    useClass: TokenInterceptor,
    multi : true}],
  bootstrap: [AppComponent]
})
export class AppModule { }
