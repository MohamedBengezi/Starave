<?php include "../../../../inc/dbinfo.inc";?>
<?php include "./functions.php";?>
<?php

session_start();
//setting the database connection
$pdo = new PDO('mysql:host=' . DB_SERVER . ';dbname=' . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*checking if credentials are inputted and passing them through to test_input
to validate the input*/
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = test_input($_POST['email']);
    $pass = test_input($_POST['password']);

    // Transforming password to hash and preparing query
    $newPass = hashPass($pass);
    $sql = "Select * from user where EMAIL=? and PASS=?";
    $stmnt = $pdo->prepare($sql);
    //Execute the query and get the results
    try {
        $stmnt->execute([$email, $newPass]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // For getting data from the query to submitted above.
    $rows = $stmnt->fetchAll();
    // If there is only one user
    if (count($rows) == 1) {
        // Setting the session to the returned user ID.
        $_SESSION['ID'] = $rows[0]['ID'];
        $_SESSION['USERNAME'] = $rows[0]['USERNAME'];
        $_SESSION['LOGINFAILED']=false;
        // Redirect to home.
        if (isset($_SESSION['PAGE'])){
        	header($_SESSION['PAGE']);
        }else{
		header("Location: ../home.php");
        }
        
    } else {
        //if something went wrong, redirect back to login page
	$_SESSION['LOGINFAILED']=true;
        header("Location: ../userLogin.php");
    }

} else {
    //if credentials aren, redirect back to login page
    header("Location: ../userLogin.php");
}
