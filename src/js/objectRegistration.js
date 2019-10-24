
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(updatePosition);
  } else {
    alert("Not able to get your location!");
  }

}

function updatePosition(position) {
	document.getElementsByName("latitude")[0].value=position.coords.latitude;
	document.getElementsByName("longitude")[0].value=position.coords.longitude;
}