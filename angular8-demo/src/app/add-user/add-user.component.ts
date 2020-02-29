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

  firstName:any;
  constructor(private formBuilder: FormBuilder,private router: Router, private apiService: ApiService) { }

  
  addForm: FormGroup;

  ngOnInit() {
    this.addForm = this.formBuilder.group({
      id: [],
      firstName: ['', Validators.required],
      lastName: ['', Validators.required],
      class: ['',Validators.required],
      dob: ['', Validators.required],
      fatherName: ['', Validators.required],
      motherName: ['',Validators.required],
      email: ['', Validators.required],
      altEmail: [''],
      password: ['', Validators.required],
      cPassword: ['', Validators.required],
      phoneNumber: ['',Validators.required],
      altPhoneNumber: [''],
      address1: ['', Validators.required],
      address2: ['',Validators.required],
      district: ['', Validators.required],
      state: ['', Validators.required],
      pinCode: ['', Validators.required],
      country: ['',Validators.required],
      pAddress1: ['', Validators.required],
      pAddress2: ['',Validators.required],
      pDistrict: ['', Validators.required],
      pState: ['', Validators.required],
      pPinCode: ['', Validators.required],
      pCountry: ['',Validators.required],
    });

  }

  onSubmit() {
    var addData = 
      {
      firstName: this.addForm.controls.firstName.value,
      lastName: this.addForm.controls.lastName.value,
      class: this.addForm.controls.class.value,
      dob: this.addForm.controls.dob.value,
      fatherName: this.addForm.controls.fatherName.value,
      motherName: this.addForm.controls.motherName.value,
      email: this.addForm.controls.email.value,
      password: this.addForm.controls.password.value,
      phoneNumber: this.addForm.controls.phoneNumber.value,
      altEmail: this.addForm.controls.altEmail.value,
      altPhoneNumber: this.addForm.controls.altPhoneNumber.value,
      address1: this.addForm.controls.address1.value,
      address2: this.addForm.controls.address2.value,
      district: this.addForm.controls.district.value,
      state: this.addForm.controls.state.value,
      pinCode: this.addForm.controls.pinCode.value,
      country: this.addForm.controls.country.value,
      pAddress1: this.addForm.controls.pAddress1.value,
      pAddress2: this.addForm.controls.pAddress2.value,
      pDistrict: this.addForm.controls.pDistrict.value,
      pState: this.addForm.controls.pState.value,
      pPinCode: this.addForm.controls.pPinCode.value,
      pCountry: this.addForm.controls.pCountry.value
      };
    
  
    this.apiService.createUser(addData)
      .subscribe( data => {
        this.router.navigate(['list-user']);
      });
      
  }

}
