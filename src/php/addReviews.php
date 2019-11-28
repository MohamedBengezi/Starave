<?php include "./helpers/functions.php"; ?>
<?php include "../../../inc/dbinfo.inc"; ?>

<?php
 /* Connect to MySQL and select the database. */
    //session_start();
    //session_start();    
    $userName = $_POST['userName'];
//    echo "Got username ",$userName;
    $ID = intval($_POST['id']);
//    echo " got ID ",$ID;
    $clubRating = intval($_POST['rating']);
//    echo " got clubrating ",$clubRating;
    $clubDesc = $_POST['Description'];
//    echo " got description ",$clubDesc;
    
    $pdo1 = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo1->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (isset($ID) && isset($clubRating) && isset($clubDesc) && isset($userName)) {
    $sql = "insert into reviews (CLUB_ID,ID,NAME,RATING,DESCRIPTION) values(?, null,?, ?, ?)";
    //$sql "select * from reviews";
    $stmnt = $pdo1->prepare($sql);
    try{
        $stmnt->execute([$ID,$userName,$clubRating,$clubDesc]);
        echo json_encode(array('success' => 1));
    }catch (PDOException $e) {
        echo json_encode(array('success' => 0));
       // printError("got error");
       // echo $e->getMessage();
       // printError($e->getMessage());
    }

    } else {
     echo json_encode(array('success' => 55555));
    }

    $pdo1 = null;
 ?>
