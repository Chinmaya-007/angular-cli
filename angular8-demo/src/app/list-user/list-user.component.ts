import { Component, OnInit , Inject} from '@angular/core';
import {Router} from "@angular/router";
import {User} from "../model/user.model";
import {ApiService} from "../core/api.service";

@Component({
  selector: 'app-list-user',
  templateUrl: './list-user.component.html',
  styleUrls: ['./list-user.component.css']
})
export class ListUserComponent implements OnInit {

  id:any;
  user: user;


  constructor(private router: Router, private apiService: ApiService) { }

  ngOnInit() {
    if(!window.localStorage.getItem('token')) {
      this.router.navigate(['login']);
      return;
    }
    this.id=window.localStorage.getItem('id');
    
    this.apiService.getUserById(this.id).subscribe( 
        data => {this.user = data.data
        ;console.log("aaaaaaa"+this.user.firstName)},
        error=>this.errordata(error)
        
      );
      
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

  editUser(user: User): void {
    window.localStorage.removeItem("editUserId");
    window.localStorage.setItem("editUserId", user.id.toString());
    this.router.navigate(['edit-user']);
  };

  addUser(): void {
    this.router.navigate(['add-user']);
  };
}
interface user{
  id: any;
  firstName: any;
  lastName:any;
  class:any;
  dob:any;
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
