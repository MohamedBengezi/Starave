//This function gets the location of the user, if the browser doesn't support the geoLocation an error message is shown
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(savePosition);
    document.getElementById("searchForm").submit();
  } else {
    alert("Not able to get your location!");
  }

}

//Saves the values in a global variable
function savePosition(position) {
	userLatitutde=position.coords.latitude;
	userLongitude=position.coords.longitude;
}