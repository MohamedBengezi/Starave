<?php include "../../../inc/dbinfo.inc"; ?>
<?php
 /* Connect to MySQL and select the database. */
    $pdo = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $clubName = htmlentities($_POST['clubName']);
    $Lat = htmlentities($_POST['latitude']);
    $Long = htmlentities($_POST['longitude']);
    $clubRating = htmlentities($_POST['rating']);

    if (empty($clubName) || empty($Lat) || empty($Long) || empty($clubRating)){
        $make = '<h4>One or more fields are not filled in</h4>';
    } else {
        $make = '<h4>No match found!</h4>';
        $sele = "SELECT * FROM clubs WHERE name LIKE '%$name%'";
        $result = mysql_query($sele);

        if ($mak = mysql_num_rows($result) > 0) {
            while ($row = mysql_fetch_assoc($result)) {
                echo '<h4> Id						: '.$row['id'];
                echo '<br> name						: '.$row['name'];
                echo '</h4>';
            }
        } else {
            echo'<h2> Search Result</h2>';
            print($make);
        }
        mysql_free_result($result);
        mysql_close($conn);
    }





?>
