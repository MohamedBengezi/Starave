
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(savePosition);
    document.getElementById("searchForm").submit();
  } else {
    alert("Not able to get your location!");
  }

}

function savePosition(position) {
	userLatitutde=position.coords.latitude;
	userLongitude=position.coords.longitude;
}