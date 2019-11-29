<!--Importing necessary variables and functions -->
<?php include "../../../inc/dbinfo.inc";?>
<?php include "../../../inc/aws-s3.inc";?>
<?php include "./helpers/functions.php";?>
<?php
session_start();
// Check if session is a logged in one, if it isn't then redirect to login.
if (!isset($_SESSION['ID'])) {
    header("Location: userLogin.php");
}
?>
<!--Including header with links to js/css scripts -->
<?php include "./header.php";?>
    <script type="text/javascript" src="../js/objectRegistration.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/objectRegistration.css" />
</head>

<body>
<!--Including nav menu -->
   <?php include "./navigationMenu.php";?>

<?php
// Defining all error, and input variables
$nameErr = $ratingErr = $latErr = $longErr = $descErr = $imgErr = "";
$clubName = $clubRating = $clubLat = $clubLong = $clubDesc = $clubImage = "";
$error = 0;

//Validating that each input field in filled in
if (empty($_POST['Club'])) {
    $error = 1;
    $nameErr = "Club name is required";
} else {
    //Passing input into test_input to validate further
    $clubName = test_input($_POST['Club']);
}

if (empty($_POST["rating"])) {
    $error = 1;
    $ratingErr = "Rating is required";
} else {
    $clubRating = test_input($_POST['rating']);
}

if (empty($_POST["latitude"])) {
    $error = 1;
    $latErr = "Latitude is required";
} else {
    $clubLat = test_input($_POST['latitude']);
}

if (empty($_POST["longitude"])) {
    $error = 1;
    $longErr = "Longitude is required";
} else {
    $clubLong = test_input($_POST['longitude']);
}

if (empty($_POST["Description"])) {
    $error = 1;
    $descErr = "Description is required";
} else {
    $clubDesc = test_input($_POST["Description"]);
}

if (empty($_FILES['image']['name'])) {
    $error = 1;
    $imgErr = "Image is required";
} else {
    $clubImage = $_FILES['image']['name'];
}

//Connecting to the database
$pdo1 = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$pdo1->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//If there's been no error from input fields then check if the club inputted is already registered
if (!$error) {
    $sql = "select * from clubs where (NAME=?);";
    $stmnt = $pdo1->prepare($sql);
    $stmnt->execute([$clubName]);
    $rows = $stmnt->fetchAll();

    //If query got back some results, then club has already been used and an error should be thrown
    if (count($rows) > 0) {
        foreach ($rows as $row) {
            if ($clubName == $row['NAME']) {
                $nameErr = "Club is already registered";
            }
        }
        $error = 1;
    }
}
//Closing the connection
$pdo1 = null;

?>
   <!-- Div for the user registration form -->
    <div class="main-w3layouts wrapper">
        <!-- This section contains all the input sections for all the inputs that are required to add a club to the database -->
        <h1>Club Registration</h1>
        <div class="main-agileinfo col-75">
            <div class="agileits-top ">
               <form action="<?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                    <!-- All inputs for the form -->
                    <span class="error" ><?php echo $nameErr; ?></span>
                    <input class="text" type="text" name="Club" placeholder="Club Name" >

                    <span class="error" ><?php echo $ratingErr; ?></span>
                    <input type="number" name="rating" placeholder="Rating" min="1" max="5">

                    <span class="error" ><?php echo $latErr; ?></span>
                    <input type="number" step="0.0000000000000001" name="latitude" placeholder="Latitude" >

                    <span class="error" ><?php echo $longErr; ?></span>
                    <input type="number" step="0.0000000000000001" name="longitude" placeholder="Longitude" >

                    <span class="error" ><?php echo $descErr; ?></span>
                    <input class="text" type="text" name="Description" placeholder="Description" >

                    <span class="error" ><?php echo $imgErr; ?></span><br/>
                    <input type="file" name="image" placeholder="Image" accept="image/jpeg,image/jpg">
                    <input type="button" class="btn btn-outline-success mt-2 mb-2" onclick="getLocation()" value="Find Location">

                    <input type="submit" value="Add">
                </form>
            </div>
        </div>

    </div>

<?php
//Adding the required scripts and libraries for AWS S3 compatability
require 'vendor/autoload.php';
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

/* Connect to MySQL and select the database. */
$pdo = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Ensuring variables used for club info are not empty
$notEmpty = strlen($clubName) || strlen($clubRating) || strlen($clubLat) || strlen($clubLong) || strlen($clubDesc);

//if all fields are filled in, image is uploaded, and no errors, then upload image to S3 bucket
if (notEmpty && !empty($_FILES['image']['name']) && !$error) {
    AddClub($pdo, $clubName, $clubRating, $clubLat, $clubLong, $clubDesc, $clubImage);

    if (isset($_FILES['image'])) {
        $bucketName = 'starave-club-images';
        $filePath = $_FILES['image']['name'];
        $keyName = basename($filePath);
        $temp_file_location = $_FILES['image']['tmp_name'];
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
        try {
            //making a temp dir for the image
            if (!file_exists('/tmp/tmpfile')) {
                mkdir('/tmp/tmpfile');
            }

            // Create temp file
            $tempFilePath = $_FILES['image']['tmp_name'];
            // Put on S3
            $s3->putObject(
                array(
                    'Bucket' => $bucketName,
                    'Key' => $keyName,
                    'SourceFile' => $temp_file_location,
                    'StorageClass' => 'REDUCED_REDUNDANCY',
                )
            );
        } catch (S3Exception $e) {
            echo $e->getMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}
//function for adding club to the database
function AddClub($pdo, $clubName, $clubRating, $clubLat, $clubLong, $clubDesc, $clubImage)
{

    $query = "insert into clubs (ID, NAME, RATING, LATITUDE, LONGITUDE, DESCRIPTION, IMAGE) values (null,?, ?, ?, ?, ?, ?);";
    $stmnt = $pdo->prepare($query);
    try {
        //try to run the query and then redirect to home
        $stmnt->execute([$clubName, $clubRating, $clubLat, $clubLong, $clubDesc, $clubImage]);
        goHome();

    } catch (PDOException $e) {
        //if there are errors, print them to console & refresh the page with input fields filled in
        printError($e->getMessage());
        echo '<script>document.getElementsByName("Club")[0].value="', $clubName, '"</script>';
        echo '<script>document.getElementsByName("rating")[0].value="', $clubRating, '"</script>';
        echo '<script>document.getElementsByName("latitude")[0].value="', $clubLat, '"</script>';
        echo '<script>document.getElementsByName("longitude")[0].value="', $clubLong, '"</script>';
        echo '<script>document.getElementsByName("Description")[0].value="', $clubDesc, '"</script>';
    }

}

//cleaning up
$_POST = array();

$pdo = null; //Closing connection
?>

<?php include "./footer.php";?>
