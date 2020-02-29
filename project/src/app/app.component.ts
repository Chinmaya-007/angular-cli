import { Component } from '@angular/core';
import { User } from './user';
import { EnrollmentService} from './enrollment.service';
import { OktaAuthService } from '@okta/okta-angular';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'project';
  submitted = false;
  errorMsg = '';
  userModel = new User('chinusahoo.cs.cs@gmail.com','12345678');
  constructor(private _enrollmentService: EnrollmentService){}
  onSubmit(){
    this.submitted=true;
    this._enrollmentService.enroll(this.userModel)
    .subscribe(
      data => console.log('Success',data),
      error => this.errorMsg= error.statusText
    )
  
  }
  
}

