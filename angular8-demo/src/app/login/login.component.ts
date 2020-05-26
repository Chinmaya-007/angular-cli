import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {ApiService} from "../core/api.service";

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  loginForm: FormGroup;
  invalidLogin: boolean = false;
  credential_error_msg="";
  constructor(private formBuilder: FormBuilder, private router: Router, private apiService: ApiService) { }

  onSubmit() {
    if (this.loginForm.invalid) {
      return;
    }
    console.log(this.loginForm.controls.username.value);
    const loginPayload = {
      phoneNumber: +this.loginForm.controls.username.value,
      password: this.loginForm.controls.password.value
    }
    this.apiService.login(this.loginForm.value).subscribe(data => {
      localStorage.setItem('token', data.token);
      localStorage.setItem('id', data.data);
      this.router.navigate(['list-user']);
      console.log("data"+data.token);
    },
    error=>{
      //console.log("here");
      
      this.credential_error_msg="Invalid Login";
    }
    );
  }
  

  ngOnInit() {
    window.localStorage.removeItem('token');
    this.loginForm = this.formBuilder.group({
      username: ['', Validators.compose([Validators.required])],
      password: ['', Validators.required]
    });
  }

  addUser(): void {
    this.router.navigate(['add-user']);
  };

}
