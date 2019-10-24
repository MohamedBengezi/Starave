// Initialize and add the map
function initMap() {
    // The location of the club in lat/long coordinates
    var modrn = { lat: 43.2584358, lng: -79.877296 };
    
    // The map, centered at Modrn
    var map = new google.maps.Map(
        //finding the div with id 'map' in which to place the live map
        document.getElementById('map'), { zoom: 13, center: modrn });
    // The marker, positioned at Modrn
    var mdrnMarker = new google.maps.Marker({ position: modrn, map: map });
   
}
