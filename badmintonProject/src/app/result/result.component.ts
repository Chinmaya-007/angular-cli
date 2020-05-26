import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl,FormBuilder } from '@angular/forms';
import {Router} from "@angular/router";
import {ApiService} from "../core/api.service";
import { AppComponent } from '../app.component';

@Component({
  selector: 'app-result',
  templateUrl: './result.component.html',
  styleUrls: ['./result.component.css']
})
export class ResultComponent implements OnInit {
  
  showLoadingIndicator = false;
  resultForm: FormGroup;
  matches:any=[{}];
  results:any=[{}];
  
  constructor(private formBuilder: FormBuilder,private router: Router, private apiService: ApiService, private appComponent: AppComponent) { }

  ngOnInit(): void {
    this.resultForm = new FormGroup({
      
      match: new FormControl(''),
     
      
    });
    this.apiService.finishedMatches().subscribe(
      data => {
        this.matches = data
      }
    )
  }
  onChangeMatchGroup(tournament: number) {
    
    this.appComponent.display(true);
    if (tournament) {
      this.apiService.getResult(tournament).subscribe(
        data => {
          this.results = data;
          this.appComponent.display(false);
        
        }
        
      );
      

    } else {
      this.results = null;
    }
    
    
  }

}
