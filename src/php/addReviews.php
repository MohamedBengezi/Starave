<?php include "./helpers/functions.php"; ?>
<?php include "../../../inc/dbinfo.inc"; ?>

<?php  
//  This php reads the values from the form, that is sent by the ajax calls, and adds the review to the database.
    
    //Username of the user that is trying to add a review
    $userName = $_POST['userName'];

    //ID of the user that is trying to add a review
    $ID = intval($_POST['id']);

    //Rating of the club entered by the user for the review
    $clubRating = intval($_POST['rating']);

    // Description of the club entered by the user for the review
    $clubDesc = $_POST['Description'];

    //DataBase Call
    $pdo1 = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo1->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (isset($ID) && isset($clubRating) && isset($clubDesc) && isset($userName)) {
    $sql = "insert into reviews (CLUB_ID,ID,NAME,RATING,DESCRIPTION) values(?, null,?, ?, ?)";
   
    $stmnt = $pdo1->prepare($sql);
    try{
        $stmnt->execute([$ID,$userName,$clubRating,$clubDesc]);
        echo json_encode(array('success' => 1));
    }catch (PDOException $e) {
        echo json_encode(array('success' => 0));
    }
    } else {
     echo json_encode(array('success' => 55555));
    }
    $pdo1 = null;
 ?>
