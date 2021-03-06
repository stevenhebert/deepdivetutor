/*
 this component is for signing up to use the site.
 */

//import needed modules for the sign-up component
import {Component, ViewChild,} from "@angular/core";
import {Observable} from "rxjs/Observable"
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignUpService} from "../services/sign-up.service";
import {SignUp} from "../classes/sign-up";
import {setTimeout} from "timers";

//declare $ for good old jquery
declare let $: any;

@Component({
	templateUrl: "./templates/sign-up.html",
	selector: "signup"
})
export class SignUpComponent {

	//
	@ViewChild("signUpForm") signUpForm: any;
	signUp: SignUp = new SignUp(null, null, null, null, null, null);
	status: Status = null;

	constructor(private signUpService: SignUpService, private router: Router) {
	}

	createSignUp(): void {
		this.signUpService.createSignUp(this.signUp)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					alert("Please check your email and follow the link to confirm your account.");
					this.signUpForm.reset();
					setTimeout(function() {
						$("#myModal").modal('hide');
					}, 500);
					this.router.navigate([""]);
				} else {
					alert("Error, there was a problem with one of your entries. Please try again.");
				}
			});
	}
}
