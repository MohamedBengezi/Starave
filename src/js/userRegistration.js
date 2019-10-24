function validateFormValues(){
  var name = document.getElementsByName("Username")[0].value;
  if (name == "") {
    alert("Name must be filled out");
    return false;
  }
  var email = document.getElementsByName("email")[0].value;
  if (email == "") {
    alert("Email must be filled out");
    return false;
  }
  if(!email.includes("@") || !email.includes(".com")){
  	alert("Please enter a valid email");
    return false;
  }
  var password = document.getElementsByName("password")[0].value;
  if (password == "") {
    alert("Password must be filled out");
    return false;
  }
  var confirmPassword = document.getElementsByName("password")[1].value;
  if (confirmPassword == "" || confirmPassword != password) {
    alert("Password is not same!");
    return false;
  }
  var age = document.getElementsByName("age")[0].value;
  if (age == "" ) {
    alert("Please enter your age");
    return false;
  }
  if (age < 18) {
    alert("Sorry! You should be atleast 18 to sign up");
    return false;
  }
  if(!document.getElementById('male').checked && !document.getElementById('female').checked && !document.getElementById('other').checked) {
  	 alert("Please select an option for your gender");
    return false;
  } 
  document.getElementById("userRegistration").submit();
}