<?php include "../../../../inc/dbinfo.inc"; ?>
<?php 
    session_start();
    // using php data objects we set the login parameters for the database. 
    // More information here: https://www.php.net/manual/en/intro.pdo.php
    $pdo = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['email']) && isset($_POST['password'])){

        // Query we are using to check if the user is legit
        $sql = "Select * from user where EMAIL=? and PASS=?";

        // Prepared statements: For when we don't have all the parameters so we store a template to be executed
        // More information here: https://www.w3schools.com/php/php_mysql_prepared_statements.asp
        $stmnt = $pdo->prepare($sql);
        try {
            $stmnt->execute([$_POST['email'], $_POST['password']]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        // For getting data from the query to submitted above.
        $rows = $stmnt->fetchAll();

        // If there is only one user
        if (count($rows) == 1){
            // Setting the session to the returned user ID.
            $_SESSION['ID'] = $rows[0]['ID'];
            // Redirect to table of users.
            header("Location: ../objectRegistration.php");
        } else {
            header("Location: ../../userLogin.php");
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
