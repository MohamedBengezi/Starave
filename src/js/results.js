// Initialize and add the map
function initMap() {
    //check if user inputted location, if not use hamilton as default
    if (!Number.isNaN(parseFloat(userLocation[0])) && !Number.isNaN(parseFloat(parseFloat(userLocation[1])))){
        var center = { lat: parseFloat(userLocation[0]), lng: parseFloat(userLocation[1]) };
    } else { 
        var center = {lat: 43.255016, lng: -79.868050} 
    }
    // The location of each club
    var numClubs = clubLocations.length;
    var clubCoords;
    var map = new google.maps.Map(
        document.getElementById('map'), { zoom: 9, center: center });


    for (var i=0; i < numClubs; i++){
        clubCoords = { lat: clubLocations[i][0], lng: clubLocations[i][1] };

    var contentString = '<div id="content">' +
        '<div id="siteNotice">' +
        '</div>' +
        '<h1 id="firstHeading" class="firstHeading">'+ clubNames[i]+'</h1>' +
        '</div>';

    createMarkers(clubCoords, map, clubNames[i], contentString);
    }

}

function createMarkers(clubCoords, map, name, contentString) {
    var marker = new google.maps.Marker({ position: clubCoords, map: map, title: name});
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
    marker.addListener('click', function () {
            infowindow.open(map, marker);
        });
    

}

$(document).ready(function() {
    $('#userRegistration').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: 'addReviews.php',
            data: $(this).serialize(),
            success: function(response)
            {   
                console.log(response);
                var jsonData = JSON.parse(response);
 
                // user is logged in successfully in the back-end
                // let's redirect
                if (jsonData.success == "1")
                {
                    console.log("POSTED REVIEW");
                    showReview();
                }
                else
                {
                    console.log(jsonData.success);
                }
           }
       });
     });
   
    function showReview(){
    alert("Added the review!");
    var elements = '<div class="container"><img src="../../assets/chris.png" alt="Avatar" style="width:90px"> <p> <span>'+ $("#userName").val() + '</span></p><p>' + $("#description").val()  + '</p> <div class="rating mr-3">';
    //This is to generate the stars
    for (i = 0; i < $("#rating").val(); i++) {
     elements += '<span class="fa fa-star checked"></span>';
    }
    for (i = 0; i < (5-$("#rating").val()); i++){
     elements += '<span class="fa fa-star"></span>';
    }
    elements += '</div></div>';  
    $("#googleMaps").before(elements);
    }
});
