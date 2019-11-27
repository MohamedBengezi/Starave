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
    $index = intval($_GET['index']);
    $userLocation = $_SESSION['userLocation'];
    $clubLocations = [];

    $bucketName = 'starave-club-images';
    $keyName = $rows[0]['IMAGE'];
    $ID = $_GET['id'];
    

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

<link rel="stylesheet" type="text/css" href="../css/clubs/modrn.css" />
</head>

<body>
	<?php include "./navigationMenu.php"; ?>
    <!-- Club Name with bootstrap styling -->
    <div class="d-flex w-100 justify-content-between ">
	<?php echo '<h1 class="mb-1">',$rows[$index]['NAME'],'</h1>'  ?>
    </div>

    <!-- Section for the club picture and desccription -->
    <div class="desc">
        <!-- picture -->
        <img class="club-image column" src="../../assets/modrn.jpeg" alt="Modrn Thumbnail" />
        <!-- Making some bullet points with descriptions. Using bootstrap to style -->
        <ul class="column mt-5">
            <li>
                <!-- Creating an in-text link to the club website -->
                <p class="mb-1">
                   
		     <?php echo $rows[$index]['DESCRIPTION']; ?>
                </p>
            </li>
        </ul>
    </div>

    <!-- Section for the overall rating using font-awesome -->
    <div class="fullrating">
        <p>Total Rating: </p>
	<?php
   $numberOfStars=$rows[$index]['RATING'];
	    for($k=0; $k<$numberOfStars; $k++){
            	echo '        <span class="fa fa-star checked"></span>';
	    }
	    $noStars=5-$numberOfStars;
	    for($m=0; $m<$noStars; $m++){
           	 echo '        <span class="fa fa-star"></span>';                
            }?>
    </div>
   
    <!-- first user review -->
    <div class="container">
        <!-- user profile pic -->
        <img src="../../assets/chris.png" alt="Avatar" style="width:90px">
        <!-- Name, title, and review -->
        <p>
            <span>Zak Bilal.</span> Local Guide</p>
        <p>The service was amazing, and the vibes were great. Would highly recommend</p>

        <div class="rating">
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
        </div>
    </div>
    <!-- Second user review -->
    <div class="container">
        <img src="../../assets/Sara.png" alt="Avatar" style="width:90px">
        <p>
            <span>Sara O'Connor.</span> Resident</p>
        <p>The club was fun was the wait time was way too long! Also the staff had an attitude.</p>

        <div class="rating">
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star checked"></span>
            <span class="fa fa-star "></span>
            <span class="fa fa-star "></span>
        </div>
    </div>
    <div>
            <div id="map"></div>
            <script type="text/javascript" src="../js/modrn.js"> </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDp09JfPFgRPWolTTBxqgBbJHbeqOc5Mak&callback=initMap">
            </script>
    </div>
<?php include "./footer.php"; ?>

