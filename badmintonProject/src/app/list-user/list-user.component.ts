import { Component, OnInit , Inject} from '@angular/core';
import {Router} from "@angular/router";
import {User} from "../model/user.model";
import {ApiService} from "../core/api.service";
import { AppComponent } from '../app.component';
import { FormGroup ,FormBuilder} from '@angular/forms';

@Component({
  selector: 'app-list-user',
  templateUrl: './list-user.component.html',
  styleUrls: ['./list-user.component.css']
})
export class ListUserComponent implements OnInit {

  id:any;
  user: user;
  showLoadingIndicator=false;
  edit:boolean=true;
  listForm:FormGroup;
  firstName:any;
  lastName:any;
  age:any;
  gender:any;
  fatherName:any;
  motherName:any;
  phoneNumber:any;
  
  email:any;
  address1:any;
  address2:any;
  district:any;
  state:any;
  pinCode:any;
  country:any;



  constructor(private router: Router, private apiService: ApiService, private appComponent: AppComponent, private formBuilder: FormBuilder) { 
    this.listForm = this.formBuilder.group({
    });
  }

  ngOnInit() {
    if(!window.localStorage.getItem('token')) {
      
      this.router.navigate(['login']);
      return;
    }
    console.log(this.edit);
    this.id=window.localStorage.getItem('id');
    this.showLoadingIndicator=true;
    this.apiService.getUserById(this.id).subscribe( 
        data => {this.user = data.data;
          this.appComponent.loggedIn=true;
          this.showLoadingIndicator=false;
          this.firstName=this.user.firstName[0];
          this.lastName=this.user.lastName[0];
          this.age=this.user.age[0];
          this.email=this.user.email[0];
          this.gender=this.user.gender[0];
          this.phoneNumber=this.user.phoneNumber[0];
          this.fatherName=this.user.fatherName[0];
          this.address1=this.user.address1[0];
          this.motherName=this.user.motherName[0];
          this.address2=this.user.address2[0];
          this.district=this.user.district[0];
          this.state=this.user.state[0];
          this.country=this.user.country[0];
          this.pinCode=this.user.pinCode[0];
        },
        error=>this.errordata(error)
        
      );
      // this.listForm = this.formBuilder.group({
      //   id: [],
      //   firstName: [],
      //   lastName: [],
      //   age: [],
      //   gender: [],
      //   fatherName: [],
      //   motherName: [],
      //   email: [],
      //   password: [],
      //   cPassword: [],
      //   phoneNumber: [],
      //   address1: [],
      //   address2: [],
      //   district: [],
      //   state: [],
      //   pinCode: [],
      //   country: [],
      // });
  
      
  }
  errordata(error){
    console.log("HERE"+error.message);
  }

  deleteUser(): void {
    this.apiService.deleteUser(this.user.id)
      .subscribe( data => {
        this.router.navigate(['login']);
      })
  };

  updateEdit(){
    this.edit=false;
    console.log(this.edit);
  };
  update(){
    let addData = 
      {
        "id":localStorage.getItem('id'),
        "firstName": this.firstName,
        "lastName": this.lastName,
        "age": this.age,
        "gender": this.gender,
        "fatherName": this.fatherName,
        "motherName": this.motherName,
        "phoneNumber":this.phoneNumber,
        "email": this.email,
        "address1": this.address1,
        "address2": this.address2,
        "district": this.district,
        "state": this.state,
        "pinCode": this.pinCode,
        "country": this.country
      };
    this.apiService.updateUser(addData)
    .subscribe( data=>{});
    console.log(addData);
    this.edit=true;
  }
  
  signOut(){
    window.localStorage.removeItem('id');
    if(this.appComponent.loggedIn){
      this.appComponent.loggedIn=false;
      this.router.navigate(['login']);
    }
    else if(this.appComponent.bidderLoggedIn){
      this.appComponent.bidderLoggedIn=false;
      this.router.navigate(['bidder']);
    }
  }
}
interface user{
  id: any;
  firstName: any;
  lastName:any;
  age:any;
  gender:any;
  fatherName:any;
  motherName:any;
  email:any;
  altEmail:any;
  phoneNumber:any;
  altPhoneNumber:any;
  address1:any;
  address2:any;
  district:any;
  state:any;
  pinCode:any;
  country:any;ny;

}
