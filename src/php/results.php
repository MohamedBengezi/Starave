<?php include "./helpers/functions.php";?>
<?php include "../../../inc/aws-s3.inc";?>
<?php
//requiring necessary scripts and libraries for S3
session_start();
require 'vendor/autoload.php';
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

// Set Amazon S3 Credentials
$s3 = S3Client::factory(
    array(
        'credentials' => array(
            'key' => KEY,
            'secret' => SECRET,
        ),
        'version' => 'latest',
        'region' => 'us-east-1',
    )
);

//getting the results from the query made in search.php
$rows = $_SESSION['rows'];
$number = count($rows);

//setting userLocation
$userLocation = $_SESSION['userLocation'];
//defin
$bucketName = BUCKET;
?>
<?php include "./header.php"?>
<link rel="stylesheet" type="text/css" href="../css/results.css" />
</head>

<body>
	<?php include "./navigationMenu.php";?>
	<!-- This div contains each object in the search results page-->
    	<div class="search-results h-100">
        	<div class="list-group h-100">

            	<!-- Club object -->
<?php
//define JS variables for the club locations and user location. Gonna pass these to google maps
echo "<script> var clubLocations = [];var clubNames = []; var userLocation = [", $userLocation[0], ",", $userLocation[1], "]</script>";
//Loop through each club that we got from the qeury and dynamically display info
for ($i = 0; $i < $number; $i++) {
    //Retrieving image from S3 bucket
    $keyName = $rows[$i]['IMAGE'];

    try {
        // Get image from S3
        $result = $s3->getCommand('GetObject',
            array(
                'Bucket' => $bucketName,
                'Key' => $keyName,
            )
        );
        //Create a URL for the image and use it in the src tag
        $request = $s3->createPresignedRequest($result, '+10 minutes');

        //Get the pre-signed URL
        $signedUrl = (string) $request->getUri();
        $imageData = base64_encode(file_get_contents($signedUrl));
    } catch (S3Exception $e) {
        printError($e->getMessage());
    } catch (Exception $e) {
        printError($e->getMessage());
    }
    //Add current club's coordinates to the clubLocations array
    echo "<script> var latLng = []; latLng.push(", $rows[$i]['LATITUDE'], "); latLng.push(", $rows[$i]['LONGITUDE'], ");</script>";
    echo "<script> clubLocations.push(latLng); clubNames.push('",$rows[$i]['NAME'],"');</script>";
    //When user clicks on a club item, go to showObjects.php and pass in the club id and index in query through the URL
    echo '<a href="showObjects.php?id=', $rows[$i]['ID'], '&index=', $i, '" class="list-group-item list-group-item-action flex-column align-items-start h-100">';
    //display the html content and fill in the content with the current club item
    echo '   <div class="d-flex w-100 justify-content-between">';
    echo '       <h5 class="mb-1 ml-3">', $rows[$i]['NAME'], '</h5>';
    echo '    </div>';
    echo '    <!-- Adding an image of the club -->';
    echo '    <div>';
    echo '        <img class="club-image" alt="Modrn Thumbnail" src="data:image/jpeg;base64,' . $imageData . '">';
    echo '    </div>';
    echo '    <div class="desc mr-5">';
    echo '        <p class="mb-1">', $rows[$i]['DESCRIPTION'], '</p>';
    echo '    </div>';
    echo "    <!-- spacing out the ratings -->";
    echo "    <br>";
    echo "    <br>";
    echo "    <br>";
    echo "    <br>";
    echo "    <br>";
    echo "    <br>";
    echo "    <br>";
    echo "    <br>";
    echo "    <!-- using font-awesome library to display the star ratings -->";
    echo '    <div class="rating mr-3">';
    //Dynamically display the number of stars for each club
    $numberOfStars = $rows[$i]['RATING'];
    for ($k = 0; $k < $numberOfStars; $k++) {
        echo '        <span class="fa fa-star checked"></span>';
    }
    $noStars = 5 - $numberOfStars;
    for ($m = 0; $m < $noStars; $m++) {
        echo '        <span class="fa fa-star"></span>';
    }
    echo "     </div>";
    echo "</a>";
}
?>
<!--Display club locations on the map -->
<a class="list-group-item list-group-item-action flex-column align-items-start h-100">
                <div id="map"></div>
                <script type="text/javascript" src="../js/results.js"> </script>
		<?php
echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDp09JfPFgRPWolTTBxqgBbJHbeqOc5Mak&callback=initMap">';
?>
		</script>
            </a>
	</div>
	</div>
<?php include "./footer.php";?>

