import { Component, OnInit, ElementRef, ViewChild  } from '@angular/core';
import { FormGroup, FormControl,FormBuilder,Validators } from '@angular/forms';
import { RouterModule, Routes } from '@angular/router';
import {Router} from "@angular/router";
import {ApiService} from "../core/api.service";
import { DatePipe } from '@angular/common';
import { AppComponent } from '../app.component';

@Component({
  selector: 'app-bidding',
  templateUrl: './bidding.component.html',
  styleUrls: ['./bidding.component.css']
})
export class BiddingComponent implements OnInit {
  z1=0;
  z2=0;
  z3=3;
  z4=0;
  z5=0;
  biddingForm: FormGroup;
  invalid: boolean = false;
  ageGroups:any=[{}];
  players:any=[{}];
  matches:any=[{}]
  valid:any=[];
  x:any;
  todayDate:Date;
  date:any;
  id=window.localStorage.getItem('id');
  credential_error_msg1="";
  credential_error_msg2="";
  credential_error_msg3="";
  credential_error_msg4="";
  credential_error_msg="";
  credential_error_msg5="";
  points_message:number=200;
  player1:number=-1;
  player2:number=-2;
  player3:number=-3;
  player4:number=-4;
  player5:number=-5;
  points=this.points_message;
  
  constructor(private formBuilder: FormBuilder,private router: Router, private apiService: ApiService,private datePipe: DatePipe, private appComponent: AppComponent) {
   }

  ngOnInit(): void {
    if(!window.localStorage.getItem('token')) {
      this.router.navigate(['bidder']);
      return;
    }

    this.todayDate = new Date();
    this.appComponent.bidderLoggedIn=true;
    this.biddingForm=this.formBuilder.group({
      age:['', Validators.compose([Validators.required])],
      match:['', Validators.compose([Validators.required])],
      player1:['', Validators.compose([Validators.required])],
      player2:['', Validators.compose([Validators.required])],
      player4:['', Validators.compose([Validators.required])],
      player3:['', Validators.compose([Validators.required])],
      player5:['', Validators.compose([Validators.required])],
    });
    this.date= this.datePipe.transform(this.todayDate,"yyyy-MM-dd")
    console.log(this.date);
    this.apiService.matches().subscribe(
      data => {
        this.matches = data
      }
    )
    
    
    let id=window.localStorage.getItem('id');
    this.biddingForm = new FormGroup({
      player1: new FormControl(''),
      player2: new FormControl(''),
      player3: new FormControl(''),
      player4: new FormControl(''),
      player5: new FormControl(''),
      match: new FormControl(''),
     
      
    });
  };
  onChangeAgeGroup(ageId: number) {
    
    this.appComponent.display(true);
    if (ageId) {
      this.apiService.dropdown(ageId).subscribe(
        data => {
          this.players = data;
          
          this.appComponent.display(false);
        }
      );
    } else {
      this.players = null;
    }
    
    
  }
  onChangePlayer1(id :number){
    
    if(id[0]==this.player2||id[0]==this.player3||id[0]==this.player4||id[0]==this.player4){
      this.credential_error_msg1="players must be different"
    }
    else{
      this.player1=id;
      this.credential_error_msg1=""
      var z= this.players.find(x=> x.id==id);
      this.z1=z.points;
      this.points_message=this.points-this.z1-this.z2-this.z3-this.z4-this.z5;
      this.credential_error_msg="";
      
      
    }
   
  }
  onChangePlayer2(id :number){
    
    if(id==this.player1||id==this.player3||id==this.player4||id==this.player4){
      this.credential_error_msg2="players must be different"
    }
    else{
      this.player2=id;
      this.credential_error_msg2="";
      var z= this.players.find(x=> x.id==id);
      this.z2=z.points;
      this.points_message=this.points-this.z1-this.z2-this.z3-this.z4-this.z5;
      this.credential_error_msg="";

      
    }
   
  }
  onChangePlayer3(id :number){
   
    if(id==this.player1||id==this.player2||id==this.player4||id==this.player4){
      this.credential_error_msg3="players must be different"
    }
    else{
      this.player3=id;
      this.credential_error_msg3="";
      var z= this.players.find(x=> x.id==id);
      this.z3=z.points;
      this.points_message=this.points-this.z1-this.z2-this.z3-this.z4-this.z5;
      this.credential_error_msg="";
    }
   
  }
  onChangePlayer4(id :number){
    
    if(id==this.player1||id==this.player3||id==this.player2||id==this.player4){
      this.credential_error_msg4="players must be different"
    }
    else{
      this.player4=id;
      this.credential_error_msg4="";
      var z= this.players.find(x=> x.id==id);
      this.z4=z.points;
      this.points_message=this.points-this.z1-this.z2-this.z3-this.z4-this.z5;
      this.credential_error_msg="";
    }
   
  }
  onChangePlayer5(id :number){
    
    if(id==this.player1||id==this.player3||id==this.player4||id==this.player2){
      this.credential_error_msg5="players must be different"
    }
    else{
      this.player5=id;
      this.credential_error_msg5="";
      var z= this.players.find(x=> x.id==id);
      this.z5=z.points;
      this.points_message=this.points-this.z1-this.z2-this.z3-this.z4-this.z5;
      this.credential_error_msg="";
    }
   
  }


  onSubmit() {
    if(this.credential_error_msg1||this.credential_error_msg2||this.credential_error_msg3||this.credential_error_msg4||this.credential_error_msg5){
      this.credential_error_msg="check the players selection";
      return;
    }
    if (this.biddingForm.invalid) {
      return;
    }
    var biddingData = 
      {
      id: window.localStorage.getItem('id'),
      player1: this.biddingForm.controls.player1.value,
      player2: this.biddingForm.controls.player2.value,
      player3: this.biddingForm.controls.player3.value,
      player4: this.biddingForm.controls.player4.value,
      player5: this.biddingForm.controls.player5.value,
      tournament: this.biddingForm.controls.match.value
      
      };
    
    
    this.appComponent.display(true);
    this.apiService.bidding(biddingData)
      .subscribe( data => {
        this.router.navigate(['biddinghistory']);
        this.appComponent.display(false);
      });
      
  }

}
