import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {ApiService} from "../core/api.service";
import { analyzeAndValidateNgModules } from '@angular/compiler';

@Component({
  selector: 'app-add-user',
  templateUrl: './add-user.component.html',
  styleUrls: ['./add-user.component.css']
})
export class AddUserComponent implements OnInit {

  addForm: FormGroup;
  constructor(private formBuilder: FormBuilder,private router: Router, private apiService: ApiService) { 
    this.addForm = this.formBuilder.group({
    });
    
  }
  
  
 

  ngOnInit() {
    this.addForm = this.formBuilder.group({
      id: [],
      firstName: ['', Validators.required],
      lastName: ['', Validators.required],
      age: ['',Validators.required],
      gender: ['', Validators.required],
      fatherName: ['', Validators.required],
      motherName: ['',Validators.required],
      email: ['', Validators.required],
      password: ['', Validators.required],
      cPassword: ['', Validators.required],
      phoneNumber: ['',Validators.required],
      address1: ['', Validators.required],
      address2: ['',Validators.required],
      district: ['', Validators.required],
      state: ['', Validators.required],
      pinCode: ['', Validators.required],
      country: ['',Validators.required],
    });

  }
  changeSuit(e) {
    this.addForm.get('gender').setValue(e.target.value, {
       onlySelf: true
    })
  }
  onSubmit() {
    var addData = 
      {
      firstName: this.addForm.controls.firstName.value,
      lastName: this.addForm.controls.lastName.value,
      age: this.addForm.controls.age.value,
      gender: this.addForm.controls.gender.value,
      fatherName: this.addForm.controls.fatherName.value,
      motherName: this.addForm.controls.motherName.value,
      email: this.addForm.controls.email.value,
      password: this.addForm.controls.password.value,
      phoneNumber: this.addForm.controls.phoneNumber.value,
      address1: this.addForm.controls.address1.value,
      address2: this.addForm.controls.address2.value,
      district: this.addForm.controls.district.value,
      state: this.addForm.controls.state.value,
      pinCode: this.addForm.controls.pinCode.value,
      country: this.addForm.controls.country.value
      };
    
  
    this.apiService.createUser(addData)
      .subscribe( data => {
        this.router.navigate(['list-user']);
      });
      
  }

}
