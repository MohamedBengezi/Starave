<?php include "./helpers/functions.php"; ?>
<?php include "../../../inc/aws-s3.inc"; ?>
<?php
    session_start();
    require 'vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;

        // Set Amazon S3 Credentials
    $s3 = S3Client::factory(
            array(
                    'credentials' => array(
                            'key' => KEY,
                            'secret' => SECRET
                    ),
                    'version' => 'latest',
                    'region'  => 'us-east-1'
            )
    );

    $rows = $_SESSION['rows'];
    $number = count($rows);

    $userLocation = $_SESSION['userLocation'];
    $clubLocations = [];

    $bucketName = 'starave-club-images';
    $keyName = $rows[0]['IMAGE'];
    

    try {
        // So you need to move the file on $filePath to a temporary place.
        // The solution being used: http://stackoverflow.com/questions/21004691/downloading-a-file-and-saving-it-locally-with-php

        // Get image from S3
        $result = $s3->getCommand('GetObject',
               array(
                  'Bucket'=>$bucketName,
                  'Key' =>  $keyName,
               )
        );
        $request = $s3->createPresignedRequest($result, '+10 minutes');

        //Get the pre-signed URL
        $signedUrl = (string) $request->getUri();
        $imageData = base64_encode(file_get_contents($signedUrl));
    } catch (S3Exception $e) {
           printError($e->getMessage());
    } catch (Exception $e) {
            printError($e->getMessage());
    }
?>
<?php include "./header.php" ?>
<link rel="stylesheet" type="text/css" href="../css/results.css" />
</head>

<body>
	<?php include "./navigationMenu.php"; ?>
	<!-- This div contains each object in the search results page-->
    	<div class="search-results h-100">
        	<div class="list-group h-100">

            	<!-- Club object -->
		<?php 
            echo "<script> var clubLocations = [];var userLocation = [",$userLocation[0],",",$userLocation[1],"]</script>";
			for($i=0; $i<$number; $i++){ 
            echo "<script> var latLng = []; latLng.push(",$rows[$i]['LATITUDE'],"); latLng.push(",$rows[$i]['LONGITUDE'],");</script>";
            echo "<script> clubLocations.push(latLng);</script>";
            echo '<a href="showObjects.php?id=',$rows[$i]['ID'],'&index=',$i,'" class="list-group-item list-group-item-action flex-column align-items-start h-100">';
            echo '   <div class="d-flex w-100 justify-content-between">';
            echo '       <h5 class="mb-1 ml-3">',$rows[$i]['NAME'],'</h5>';
            echo '    </div>';
            echo '    <!-- Adding an image of the club -->';
            echo '    <div>';
            echo '        <img class="club-image" alt="Modrn Thumbnail" src="data:image/jpeg;base64,'.$imageData.'">';
            echo '    </div>';
            echo '    <div class="desc mr-5">';
            echo '        <p class="mb-1">',$rows[$i]['DESCRIPTION'],'</p>';
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
	    $numberOfStars=$rows[$i]['RATING'];
	    for($k=0; $k<$numberOfStars; $k++){
            	echo '        <span class="fa fa-star checked"></span>';
	    }
	    $noStars=5-$numberOfStars;
	    for($m=0; $m<$noStars; $m++){
           	 echo '        <span class="fa fa-star"></span>';                
            }
            echo "     </div>";
	    echo "</a>";
			}
		?>
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
<?php include "./footer.php"; ?>

