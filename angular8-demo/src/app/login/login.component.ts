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
    const loginPayload = {
      email: this.loginForm.controls.username.value,
      password: this.loginForm.controls.password.value
    }
    this.apiService.login(loginPayload).subscribe(data => {
      //console.log("data"+data.result);
      if(data.status === 200) {
        
        localStorage.setItem('token', data.result.token);
        this.router.navigate(['list-user']);
      }else {
        //this.router.navigate(['list-user']);
        this.invalidLogin = true;
        alert(data.message);
      }
      
    },
    error=>{
      console.log("here");
      
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
