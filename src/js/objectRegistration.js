
//This function gets the location of the user, if the browser doesn't support the geoLocation an error message is shown
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(updatePosition);
  } else {
    alert("Not able to get your location!");
  }

}

//This function updates the latitude and longitude fields in the forms with the values got from using the above method.
function updatePosition(position) {
	document.getElementsByName("latitude")[0].value=position.coords.latitude;
	document.getElementsByName("longitude")[0].value=position.coords.longitude;
}