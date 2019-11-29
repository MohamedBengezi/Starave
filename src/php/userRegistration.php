<?php include "../../../inc/dbinfo.inc"; ?>
<?php include "./helpers/functions.php"; ?>
<?php include "./header.php"; ?>
<?php 
    session_start();
    // Check if session is a logged in one, if it is then redirect to login.
    if (isset($_SESSION['ID'])){
        header("Location: ../php/home.php");
    }
?>


    <link rel="stylesheet" type="text/css" href="../css/userRegistration.css" />
   <!-- <script type="text/javascript" src="../js/userRegistration.js"></script> -->
</head>

<body>
    <?php include "./navigationMenu.php"; ?>
<?php
$nameErr = $emailErr = $passErr  = $ageErr = $genderErr = "";
$userName = $userEmail = $userPassword = $userAge = $userGender = "";
$error = 0;
if (empty($_POST['Username'])) {
  $error = 1;
  $nameErr = "Username is required";
} else {
  $userName = test_input($_POST['Username']);
}

if (empty($_POST["email"])) {
  $error = 1;
  $emailErr = "Email is required";
} else {
  $userEmail = test_input($_POST['email']);
}

if (empty($_POST["password"])) {
  $error = 1;
   $passErr = "Password is required";
} else {
  $userPassword = test_input($_POST['password']);
}

if (empty($_POST["repassword"])) {
  $error = 1;
   $passErr = "Password is required";
} else {
  if (!empty($_POST["password"]) && ($_POST["repassword"] != $_POST["password"])) { 
      $error = 1;
      $passErr = "Passwords do not match";
  } else {
      $userRepassword = test_input($_POST['repassword']);
  }
}

if (empty($_POST["age"])) {
  $error = 1;
  $ageErr = "Age is required";
} else {
  $userAge = test_input($_POST['age']);
}

if (empty($_POST["gender"])) {
  $error = 1;
  $genderErr = "Gender is required";
} else {
  $userGender = test_input($_POST["gender"]);
}

    $pdo1 = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo1->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //When the sign up is successful, login the user automatically


    if (!$error) {
        $sql = "select * from user where (EMAIL=? or USERNAME=?);";
        $stmnt = $pdo1 -> prepare($sql);
        $stmnt -> execute([$userEmail, $userName]);
        $rows = $stmnt -> fetchAll();


        if (count($rows) > 0) {
            foreach ($rows as $row ){
                if ($userName==$row['USERNAME'])
                {
                    $nameErr = "Username is in use";
                }
                if ($userEmail==$row['EMAIL'])
                {
                    $emailErr = "Email is in use";
                }
            }
	    $error = 1;
        }
    }
$pdo1 = null;

$notEmpty = strlen($userName) || strlen($userEmail) || strlen($userPassword) || strlen($userAge) || strlen($userGender);

?>
    <!-- Div for the user registration form -->
    <div class="main-w3layouts wrapper">
        <h1>User Registration</h1>
        <div class="main-agileinfo col-75">
            <div class="agileits-top ">
                <form id="userRegistration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <!-- All inputs for the form -->
                    <span class="error" style="color:#FFFFFF;"><?php echo $nameErr;?></span>
                    <input class="text" type="text" name="Username" placeholder="Username">
                    
                    <span class="error" style="color:#FFFFFF;"> <?php echo $emailErr;?></span>
                    <input class="text email" type="email" name="email" placeholder="Email">

                    <span class="error" style="color:#FFFFFF;"><?php echo $passErr;?></span>
                    <input class="text" type="password" name="password" placeholder="Password">
                    <input class="text" type="password" name="repassword" placeholder="Confirm Password">

                    <span class="error" style="color:#FFFFFF;"> <?php echo $ageErr;?></span><br/>
                    <input class="text" type="number" name="age" placeholder="Age">

                    <!-- Adding a label within the radio buttons to make the words clickable -->
                    <span class="error" style="color:#FFFFFF;"> <?php echo $genderErr;?></span><br/>
                    <input type="radio" name="gender" value="male" id="male"><label class="gender" for="male">
                        Male</label> <br>
                    <input type="radio" name="gender" value="female" id="female"> <label class="gender" for="female">
                        Female</label><br>
                    <input type="radio" name="gender" value="other" id="other"> <label class="gender" for="other">
                        Other</label><br/>
                    <input type="submit"  value="SIGN UP">
                </form>
            </div>
        </div>

    </div>

<?php
    session_start();
    // Check if session is a logged in one, if it is then redirect to login.
    if (isset($_SESSION['ID'])){
        header("Location: ../php/home.php");
    }

/* Connect to MySQL and select the database. */
    $pdo = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //When the sign up is successful, login the user automatically

  if ($notEmpty && !$error) {
    AddUser($pdo, $userName, $userEmail, $userPassword, $userAge, $userGender);
  }

/* Add a user to the table. */
function AddUser($pdo, $userName, $email,$password,$age,$gender) {
   $newPass = hashPass($password);

   $query = "insert into user (ID, USERNAME, EMAIL, PASS, AGE, GENDER) values (null,?, ?, ?, ?, ?);";
   $stmnt = $pdo->prepare($query);
   try {
            $stmnt->execute([$userName, $email, $newPass, $age, $gender]);

    //When the sign up is successful, login the user automatically
    $query= "Select * from user where EMAIL=? and PASS=?";
    $stmnt = $pdo->prepare($query);
    $stmnt->execute([$email,$newPass]);
    $rows = $stmnt->fetchAll();

        // If there is only one user
        if (count($rows) == 1){

            // Setting the session to the returned user ID.
            $_SESSION['ID'] = $rows[0]['ID'];
            // Redirect to table of users.
            printError("successfully logged in");
            goHome();

        }
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo '<script>document.getElementsByName("Username")[0].value="',$userName ,'"</script>';
            echo '<script>document.getElementsByName("email")[0].value="',$email ,'"</script>';
            echo '<script>document.getElementsByName("age")[0].value="',$age ,'"</script>';
            echo '<script>document.getElementById("',$gender,'").checked=true; </script>';
         }
 }


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
        $_POST = array();
        $pdo=null; //Closing connection
?>

<? php include "./footer.php"; ?>
