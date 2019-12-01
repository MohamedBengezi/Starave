<?php include "../../../inc/dbinfo.inc"; ?>
<?php include "./helpers/functions.php"; ?>
<?php
    session_start();
    //Setting the page the user is currently in into the session. 
    $_SESSION['PAGE']="Location: ../search.php";
//  Check if session is a logged in one, if it isn't then redirect to login.
    if (!isset($_SESSION['ID'])){
        header("Location: userLogin.php");
    }
   

?>
<?php include "./header.php"; ?>
    <link rel="stylesheet" type="text/css" href="../css/search.css" />
    <script type="text/javascript" src="../js/index.js"></script>
    <script type="text/javascript" src="../js/search.js"></script>

</head>

<body>
	<?php include "./navigationMenu.php"; ?>

	<form id="searchForm" class="col-xs-4 col1 center-block w-100" action="search.php" method="post">
        <!-- This section contains all the inputs required to do a specific search for clubs -->
        <div class="search-form">
            <div class="">
                <h2 class="text-uppercase mt-3">Name</h2>
                <input class=" w-25 name " type="search" placeholder="Optional" aria-label="Search" name="clubName">
            </div>
            <div id="location-select">
                <h2 class="text-uppercase mt-3">Location</h2>
                    <input type="number" step="0.0000000000000001" name="latitude" placeholder="Latitude" class=" w-25 name " >
                    <input type="number" step="0.0000000000000001" name="longitude" placeholder="Longitude" class=" w-25 name " >

                    <input type="button" class="btn btn-outline-success mt-2 mb-2" onclick="getLocation()" value="Find Location">

            </div>
            <div id="rating-select">
                <h2 class="text-uppercase mt-3">Rating</h2>
                <select class="custom-select w-25" name="rating">
                    <option selected value="1">1+ stars</option>
                    <option value="2">2+ stars</option>
                    <option value="3">3+ stars</option>
                    <option value="4">4+ stars</option>
                    <option value="5">5 stars</option>
                </select>
            </div>
            <br>
            <button class="btn btn-outline-success mt-2" type="submit">Find Clubs!</button>
    </form>
<?php
 /* Connect to MySQL and selecting the database. */
    $pdo = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Getting all the values from the form.
    $clubName = htmlentities($_POST['clubName']);
    $Lat = htmlentities($_POST['latitude']);
    $Long = htmlentities($_POST['longitude']);
    $clubRating = htmlentities($_POST['rating']);

    //By default the search is just bassed on the rating 
    $sql = "select * from clubs WHERE RATING>=$clubRating;";
  
    //If all the search criteria is filled the query uses club's name, distance of the club and club's rating to find the results.
    if (!empty($clubName) && !empty($Lat) && !empty($Long) && !empty($clubRating)){
         $sql = "SELECT ID,NAME,RATING,LATITUDE,LONGITUDE,DESCRIPTION,IMAGE, ( 6371 * acos( cos( radians($Lat) ) * cos( radians( LATITUDE ) ) * cos( radians( LONGITUDE ) - radians($Long) ) + sin( radians($Lat) ) * sin(radians(LATITUDE)) ) ) AS distance FROM clubs WHERE NAME='$clubName' AND RATING>=$clubRating HAVING distance < 15 ORDER BY distance LIMIT 0, 3 ;";
    } else if(empty($clubName) && !empty($Lat) && !empty($Long) && !empty($clubRating)) { //If the club's name is not entered, then only the distance and rating is used in the query to find the results.
       $sql = "SELECT ID,NAME,RATING,LATITUDE,LONGITUDE,DESCRIPTION,IMAGE, ( 6371 * acos( cos( radians($Lat) ) * cos( radians( LATITUDE ) ) * cos( radians( LONGITUDE ) - radians($Long) ) + sin( radians($Lat) ) * sin(radians(LATITUDE)) ) ) AS distance FROM clubs WHERE RATING>=$clubRating HAVING distance < 15 ORDER BY distance LIMIT 0, 3 ;";
      }else if(!empty($clubName) && empty($Lat) && empty($Long) && !empty($clubRating)) {//If the latitude and longitude is not entered, then the club's name and rating is used to find the results.
       $sql = "SELECT ID,NAME,RATING,LATITUDE,LONGITUDE,DESCRIPTION,IMAGE FROM clubs WHERE NAME='$clubName' AND RATING>=$clubRating;";
      }

    $stmnt = $pdo->prepare($sql);
        try{
                $stmnt->execute([]);
                $rows= $stmnt->fetchAll();
                $_SESSION['userLocation'] = [$Lat, $Long];
                $_SESSION['rows'] = $rows; //setting this variable in session, so results.php could use it.
		        $number = count($rows);
		if($number==0){
			alert("NO RESULTS FOUND!");
		}
		else{
			showResults();
		}
        }catch (PDOException $e) {
            printError("got error");
            printError($e->getMessage());
        }
?>
<?php include "./footer.php"; ?>
