// Initialize and add the map
function initMap() {
    // The location of each club
    var center = { lat: parseFloat(userLocation[0]), lng: parseFloat(userLocation[1]) };
    var numClubs = clubLocations.length;
  
    var clubCoords;
    var map = new google.maps.Map(
        document.getElementById('map'), { zoom: 9, center: center });

    //A sample description to display in the label
    var contentString = '<div id="content">' +
        '<div id="siteNotice">' +
        '</div>' +
        '<h1 id="firstHeading" class="firstHeading">Modrn</h1>' +
        '<div id="bodyContent">' +
        '<p><b>Modrn</b>, one of the most popular clubs on ' +
        'Hess st. and in all of Hamilton. Known for it\'s ' +
        'great selection of Hip/Hop and Pop music.</p>' +
        '<p>More info: Uluru, <a href="./clubs/modrn.html">' +
        'Detailed Info</a> ' +
        '</p>' +
        '</div>' +
        '</div>';

    //Creating an infowindow (AKA label popup) with the content being the description above
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    //
    for (var i=0; i < numClubs; i++){
        clubCoords = { lat: clubLocations[i][0], lng: clubLocations[i][1] };
//        markerList.push(new google.maps.Marker({ position: clubCoords, map: map });)
        clubMarker = new google.maps.Marker({ position: clubCoords, map: map });
        clubMarker.addListener('click', function () {
            infowindow.open(map, clubMarker);
        });
        
    }

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
