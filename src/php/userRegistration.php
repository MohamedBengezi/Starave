<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    session_start();
    // Check if session is a logged in one, if it isn't then redirect to login.
    if (isset($_SESSION['ID'])){
        header("Location: ../home.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nightclub Review</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../lib/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/userRegistration.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/userRegistration.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../home.php">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./userRegistration.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./objectRegistration.php">Add Club</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Contact Us</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="search.html">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </header>

    <!-- Div for the user registration form -->
    <div class="main-w3layouts wrapper">
        <h1>User Registration</h1>
        <div class="main-agileinfo col-75">
            <div class="agileits-top ">
                <form id="userRegistration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <!-- All inputs for the form -->
                    <input class="text" type="text" name="Username" placeholder="Username">
                    <input class="text email" type="email" name="email" placeholder="Email">
                    <input class="text" type="password" name="password" placeholder="Password">
                    <input class="text" type="password" name="password" placeholder="Confirm Password">
                    <input class="text" type="number" name="age" placeholder="Age">
                    <!-- Adding a label within the radio buttons to make the words clickable -->
                    <input type="radio" name="gender" value="male" id="male"><label class="gender" for="male">
                        Male</label> <br>
                    <input type="radio" name="gender" value="female" id="female"> <label class="gender" for="female">
                        Female</label><br>
                    <input type="radio" name="gender" value="other" id="other"> <label class="gender" for="other">
                        Other</label>
                    <input type="button" onclick="validateFormValues()" value="SIGN UP">
                </form>
            </div>
        </div>

    </div>

    <!-- The footer section -->
    <footer>
        <a href="../sitemap.xml">Sitemap</a>
    </footer> >

<?php

 /* Connect to MySQL and select the database. */
    $pdo = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  /* If input fields are populated, add a row to the EMPLOYEES table. */
  $userName = htmlentities($_POST['Username']);
  $userEmail = htmlentities($_POST['email']);
  $userPassword = htmlentities($_POST['password']);
  $userAge = htmlentities($_POST['age']);
  $userGender = htmlentities($_POST['gender']);


  if (strlen($userName) || strlen($userEmail) || strlen($userPassword) || strlen($userAge) || strlen($userGender)) {
    AddUser($pdo, $userName, $userEmail, $userPassword, $userAge, $userGender);
  }



/* Add an employee to the table. */
function AddUser($pdo, $userName, $email,$password,$age,$gender) {

   $query = "insert into user (ID, USERNAME, EMAIL, PASS, AGE, GENDER) values (null,?, ?, ?, ?, ?);";
   $stmnt = $pdo->prepare($query);
   try {
            $stmnt->execute([$userName, $email,$password,$age,$gender]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo '<script>alert("hacked")</script>';
	 }

}
$pdo=null; //Closing connection
//header("Location: ../userRegistration.php");

?>

</body>
</html>
