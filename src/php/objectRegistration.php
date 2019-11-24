<?php include "../../../inc/dbinfo.inc"; ?>
<?php include "../../../inc/aws-s3.inc"; ?>
<?php include "./helpers/functions.php"; ?>
<?php
    session_start();
    // Check if session is a logged in one, if it isn't then redirect to login.
    if (!isset($_SESSION['ID'])){
        header("Location: userLogin.php");
    }


?>
<?php include "./header.php"; ?>
    <script type="text/javascript" src="../js/objectRegistration.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/objectRegistration.css" />
</head>
<body>
   <?php include "./navigationMenu.php"; ?>
   <!-- Div for the user registration form -->
    <div class="main-w3layouts wrapper"> 
        <!-- This section contains all the input sections for all the inputs that are required to add a club to the database -->
        <h1>Club Registration</h1>
        <div class="main-agileinfo col-75">
            <div class="agileits-top ">
               <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <!-- All inputs for the form -->
                    <input class="text" type="text" name="Club" placeholder="Club Name" required="">
                    <input type="number" name="rating" placeholder="Rating" required="" min="1" max="5">
                    <input type="number" step="0.0000000000000001" name="latitude" placeholder="Latitude" required="">
                    <input type="number" step="0.0000000000000001" name="longitude" placeholder="Longitude" required="">
                    <input class="text" type="text" name="Description" placeholder="Description" required="">
                    <input type="file" name="image" placeholder="Image" required="">
                    <input type="button" class="btn btn-outline-success mt-2 mb-2" onclick="getLocation()" value="Find Location">

                    <input type="submit" value="Add">
                </form>
            </div>
        </div>

    </div>

<?php
 /* Connect to MySQL and select the database. */
    $pdo = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     /* If input fields are populated, add a row to the EMPLOYEES table. */
    $clubName = htmlentities($_POST['Club']);
    $clubRating = htmlentities($_POST['rating']);
    $clubLat = htmlentities($_POST['latitude']);
    $clubLong = htmlentities($_POST['longitude']);
    $clubDesc = htmlentities($_POST['Description']);
    $clubImage = htmlentities($_FILES['image']['name']);

    if (strlen($clubName) || strlen($clubRating) || strlen($clubLat) || strlen($clubLong) || strlen($clubDesc) || strlen($clubImage)) {
      AddClub($pdo, $clubName, $clubRating, $clubLat, $clubLong, $clubDesc, $clubImage);
    } 

        require 'vendor/autoload.php';
        use Aws\S3\S3Client;
        use Aws\S3\Exception\S3Exception;
    if (isset($_FILES['image'])){
        $bucketName = 'starave-club-images';
        $filePath = $_FILES['image']['name'];
        $temp_file_location = $_FILES['image']['tmp_name']; 
        // Set Amazon S3 Credentials
        $s3 = S3Client::factory(
                array(
                        'credentials' => array(
                                'key' => $IAM_KEY,
                                'secret' => $IAM_SECRET
                        ),
                        'version' => 'latest',
                        'region'  => 'us-east-1'
                )
        );
        try {
                // So you need to move the file on $filePath to a temporary place.
                // The solution being used: http://stackoverflow.com/questions/21004691/downloading-a-file-and-saving-it-locally-with-php
                if (!file_exists('/tmp/tmpfile')) {
                        mkdir('/tmp/tmpfile');
                }

                // Create temp file
                $tempFilePath = $_FILES['image']['tmp_name'];
        echo $tempFilePath;
                // Put on S3
                $s3->putObject(
                        array(
                                'Bucket'=>$bucketName,
                                'Key' =>  $keyName,
                                'SourceFile' => $temp_file_location,
                                'StorageClass' => 'REDUCED_REDUNDANCY'
                        )
                );
        } catch (S3Exception $e) {
                echo $e->getMessage();
        } catch (Exception $e) {
                echo $e->getMessage();
        }


    }

 

function AddClub($pdo, $clubName, $clubRating, $clubLat, $clubLong, $clubDesc, $clubImage) {

   $query = "insert into clubs (ID, NAME, RATING, LATITUDE, LONGITUDE, DESCRIPTION, IMAGE) values (null,?, ?, ?, ?, ?, ?);";
   $stmnt = $pdo->prepare($query);
   try {
            $stmnt->execute([$clubName, $clubRating, $clubLat, $clubLong, $clubDesc, $clubImage]);
	    goHome();
        } catch (PDOException $e) {
            echo $e->getMessage(); 
            echo "TESTING".$clubName;
            header("Location: objectRegistration.php");
            echo '<script>alert("This club already exists")</script>';
            echo '<script>document.getElementsByName("Club")[0].value="',$clubName ,'"</script>';
            echo '<script>document.getElementsByName("rating")[0].value="',$clubRating ,'"</script>';
            echo '<script>document.getElementsByName("latitude")[0].value="',$clubLat ,'"</script>';
            echo '<script>document.getElementsByName("longitude")[0].value="',$clubLong ,'"</script>';
            echo '<script>document.getElementsByName("Description")[0].value="',$clubDesc ,'"</script>';
         }

}

$pdo=null; //Closing connection
?>

<?php include "./footer.php"; ?>    
