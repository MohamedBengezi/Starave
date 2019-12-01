<?php include "./helpers/functions.php";?>
<?php include "../../../inc/dbinfo.inc";?>
<?php include "../../../inc/aws-s3.inc";?>
<?php
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

$rows = $_SESSION['rows'];
$number = count($rows);
//Getting username and location from session
$userName = $_SESSION['USERNAME'];
$userLocation = $_SESSION['userLocation'];
//Getting index and club ID from url
$index = intval($_GET['index']);
$ID = $_GET['id'];

$bucketName = BUCKET;
$keyName = $rows[$index]['IMAGE'];

/* Connect to MySQL and select the database. */
$pdo = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Get user reviews for this club
$sql = "select * from reviews WHERE CLUB_ID=$ID;";
$stmnt = $pdo->prepare($sql);
try {
    $stmnt->execute([]);
    //gonna use $newRows later
    $newRows = $stmnt->fetchAll();
    $number = count($newRows);
} catch (PDOException $e) {
    printError("got error");
    printError($e->getMessage());
}

//Get the image for this club
try {

    // Get image from S3
    $result = $s3->getCommand('GetObject',
        array(
            'Bucket' => $bucketName,
            'Key' => $keyName,
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

$pdo = null; //Closing connection
//Submit a review input validation. See objectRegistration for detailed comments
$ratingErr = $descErr = "";
$clubRating = $clubDesc = "";
$error = 0;

if (empty($_POST["rating"])) {
    $error = 1;
    $ratingErr = "Rating is required";
} else {
    $clubRating = test_input($_POST['rating']);
}

if (empty($_POST["Description"])) {
    $error = 1;
    $descErr = "Description is required";
} else {
    $clubDesc = test_input($_POST["Description"]);
}

?>
<?php include "./header.php"?>

<link rel="stylesheet" type="text/css" href="../css/userRegistration.css" />
<link rel="stylesheet" type="text/css" href="../css/clubs/modrn.css" />
</head>

<body>
	<?php include "./navigationMenu.php";?>
    <!-- Club Name with bootstrap styling -->
    <div class="d-flex w-100 justify-content-between ">
        <?php echo '<h1 class="mb-1">', $rows[$index]['NAME'], '</h1>' ?>
    </div>
        <?php
//Displaying club location on google maps. See results.php for detailed comments
echo "<script> var clubLocations = [];var clubNames = []; var userLocation = [", $userLocation[0], ",", $userLocation[1], "]</script>";
echo "<script> var latLng = []; latLng.push(", $rows[$index]['LATITUDE'], "); latLng.push(", $rows[$index]['LONGITUDE'], ");</script>";
echo "<script> clubLocations.push(latLng); clubNames.push('",$rows[$index]['NAME'],"');</script>";
?>
    <!-- Section for the club picture and desccription -->
    <div class="desc">
        <!-- picture -->
        <?php echo '<img class="club-image column" src="data:image/jpeg;base64,', $imageData, '" alt="Modrn Thumbnail" />'; ?>
        <!-- Making some bullet points with descriptions. Using bootstrap to style -->
        <ul class="column mt-5">
            <li>
                <p class="mb-1">
                    <!-- Using the description for this club from the query -->
		     <?php echo $rows[$index]['DESCRIPTION']; ?>
                </p>
            </li>
        </ul>
    </div>

    <!-- Div for the submit review form -->
    <div class="main-w3layouts wrapper">
        <div class="main-agileinfo col-75">
            <div class="agileits-top ">
                <h3>Submit a review</h3>
                <form id="userRegistration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <!-- All inputs for the form -->
                    <!-- span for displaying an input errors -->
                    <span class="error" ><?php echo $ratingErr; ?></span>
                    <input id="rating" type="number" name="rating" placeholder="Rating" min="1" max="5">
                    <!-- span for displaying an input errors -->
                    <span class="error" ><?php echo $descErr; ?></span>
                    <input id="description" class="text" type="text" name="Description" placeholder="Description" ><br/>
                    <!-- Already know username and club ID -->
		            <input type="number" name="id" hidden  value="<?php echo $ID ?>" >
                    <input id="userName" type="text" name="userName" hidden  value="<?php echo $userName ?>" >
                    <input type="submit"  value="SUBMIT REVIEW">
                </form>
            </div>
        </div>

    </div>

    <!-- user reviews in a loop -->
<?php
for ($i = 0; $i < $number; $i++) {
    ?>
    <div class="container">
        <!-- user profile pic -->
        <img src="../../assets/chris.png" alt="Avatar" style="width:90px">
        <!-- Name, title, and review -->
        <p>
    <?php
//Getting user name, club description, and rating query above
    echo '<span>', $newRows[$i]['NAME'], '</span></p>';
    echo '<p>', $newRows[$i]['DESCRIPTION'], '</p>';

    echo '    <div class="rating mr-3">';
    $numberOfStars = $newRows[$i]['RATING'];
    for ($k = 0; $k < $numberOfStars; $k++) {
        echo '        <span class="fa fa-star checked"></span>';
    }
    $noStars = 5 - $numberOfStars;
    for ($m = 0; $m < $noStars; $m++) {
        echo '        <span class="fa fa-star"></span>';
    }
    echo "     </div>";
    echo "</a>";

    echo '</div>';
    echo '</div>';
}
?>
<!-- Using script from results.js to dynamically display map markers -->
<a class="list-group-item list-group-item-action flex-column align-items-start h-100" id="googleMaps">
                <div id="map"></div>
                <script type="text/javascript" src="../js/results.js"> </script>
                <?php
echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDp09JfPFgRPWolTTBxqgBbJHbeqOc5Mak&callback=initMap">';
?>
                </script>
            </a>
<?php include "./footer.php";?>

