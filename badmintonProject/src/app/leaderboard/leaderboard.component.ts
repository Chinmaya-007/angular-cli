import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import { RouterModule, Routes } from '@angular/router';
import {ApiService} from "../core/api.service";
import { AppComponent } from '../app.component';

@Component({
  selector: 'app-leaderboard',
  templateUrl: './leaderboard.component.html',
  styleUrls: ['./leaderboard.component.css']
})
export class LeaderboardComponent implements OnInit {
  leaderboardForm: FormGroup;
  invalid: boolean = false;

  constructor(private formBuilder: FormBuilder, private router: Router, private apiService: ApiService, private appComponent: AppComponent) { }
  
  users:any=[{}];

  ngOnInit(): void {
    this.leaderboardForm = this.formBuilder.group({
      age: ['', Validators.compose([Validators.required])],
      gender: ['', Validators.required]
    });
  }

  onSubmit() {
    delete this.users;
    if (this.leaderboardForm.invalid) {
      return;
    }
    
    const loginPayload = {
      age: +this.leaderboardForm.controls.age.value,
      gender: +this.leaderboardForm.controls.gender.value
    }
    this.appComponent.display(true);
    this.apiService.leaderboard(this.leaderboardForm.value).subscribe(data => {
      this.users=data;
      this.appComponent.display(false);
    }
    );
  }

}
