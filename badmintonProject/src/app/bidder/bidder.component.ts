import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import { RouterModule, Routes } from '@angular/router';
import {ApiService} from "../core/api.service";
import { ListUserComponent } from '../list-user/list-user.component';

@Component({
  selector: 'app-bidder',
  templateUrl: './bidder.component.html',
  styleUrls: ['./bidder.component.css']
})
export class BidderComponent implements OnInit {
  bidderForm: FormGroup;
  invalidLogin: boolean = false;
  credential_error_msg="";
  constructor(private formBuilder: FormBuilder, private router: Router, private apiService: ApiService) { }

  onSubmit() {
    if (this.bidderForm.invalid) {
      return;
    }
    
    const loginPayload = {
      username: +this.bidderForm.controls.username.value,
      password: +this.bidderForm.controls.password.value
    }
    this.apiService.bidderlogin(this.bidderForm.value).subscribe(data => {
      localStorage.setItem('token', data.token);
      localStorage.setItem('id', data.data);
      
      this.router.navigate(['bidding']);
      console.log("data"+data.token);
    },
    error=>{
      console.log("here");
      
       this.credential_error_msg="Invalid Login";
    },
    () => {
      
      
      this.router.navigate(['bidding']);
    }
    );
  }
  ngOnInit(): void {
    window.localStorage.removeItem('token');
    this.bidderForm = this.formBuilder.group({
      username: ['', Validators.compose([Validators.required])],
      password: ['', Validators.required]
    });
  }

}
