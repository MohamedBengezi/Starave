/* This function checks the formatting of all the required fields for user registration*/
function validateFormValues(){
  var name = document.getElementsByName("Username")[0].value;
  // if the name is not enetered, a popup message is shown
  if (name == "") {
    alert("Name must be filled out");
    return false;
  }
  var email = document.getElementsByName("email")[0].value;
   // if the email is not enetered, a popup message is shown
  if (email == "") {
    alert("Email must be filled out");
    return false;
  }
  // if the name is not valid, a popup message is shown
  if(!email.includes("@") || !email.includes(".com")){
  	alert("Please enter a valid email");
    return false;
  }
  var password = document.getElementsByName("password")[0].value;
  // if the password is not enetered, a popup message is shown
  if (password == "") {
    alert("Password must be filled out");
    return false;
  }
  var confirmPassword = document.getElementsByName("password")[1].value;
  // if the password is not same as the previously entered one, a popup message is shown
  if (confirmPassword == "" || confirmPassword != password) {
    alert("Password is not same!");
    return false;
  }
  var age = document.getElementsByName("age")[0].value;
  // if the age is not enetered, a popup message is shown
  if (age == "" ) {
    alert("Please enter your age");
    return false;
  }
  // if the user is less than 18 years old, a popup message is shown
  if (age < 18) {
    alert("Sorry! You should be atleast 18 to sign up");
    return false;
  }
  // if no option is selected for the gender, a popup message is shown
  if(!document.getElementById('male').checked && !document.getElementById('female').checked && !document.getElementById('other').checked) {
  	 alert("Please select an option for your gender");
    return false;
  } 
  //if all the validations pass, the form is submitted to the server.
  document.getElementById("userRegistration").submit();
}