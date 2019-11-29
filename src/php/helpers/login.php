<?php include "../../../../inc/dbinfo.inc"; ?>
<?php include "./functions.php";?>
<?php 
    session_start();
    // using php data objects we set the login parameters for the database. 
    // More information here: https://www.php.net/manual/en/intro.pdo.php
    $pdo = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['email']) && isset($_POST['password'])){
        $email = test_input($_POST['email']);
        $pass = test_input($_POST['password']);

        // Query we are using to check if the user is legit
        $newPass = hashPass($pass); 
        $sql = "Select * from user where EMAIL=? and PASS=?";
        // Prepared statements: For when we don't have all the parameters so we store a template to be executed
        // More information here: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
        $stmnt = $pdo->prepare($sql);
        try {
            $stmnt->execute([$email, $newPass]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        // For getting data from the query to submitted above.
        $rows = $stmnt->fetchAll();
        // If there is only one user
        if (count($rows) == 1){
            // Setting the session to the returned user ID.
            $_SESSION['ID'] = $rows[0]['ID'];
            $_SESSION['USERNAME'] = $rows[0]['USERNAME'];
            // Redirect to table of users.
            header("Location: ../../php/home.php");
        } else {
            header("Location: ../userLogin.php");
        }

    } else {
        // This path is dependent on where the root of your documents is located.
        // For this it is made to point back to the index file if login has failed.
        header("Location: ../userLogin.php");
    }


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
