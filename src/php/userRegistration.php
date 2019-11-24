<?php include "../../../inc/dbinfo.inc"; ?>
<?php include "./helpers/functions.php"; ?>

<?php include "./header.php"; ?>

    <link rel="stylesheet" type="text/css" href="../css/userRegistration.css" />
    <script type="text/javascript" src="../js/userRegistration.js"></script>
</head>

<body>
    <?php include "./navigationMenu.php"; ?>

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

<?php
    session_start();
    // Check if session is a logged in one, if it isn't then redirect to login.
    if (isset($_SESSION['ID'])){
        header("Location: ../home.php");
    }

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

  $notEmpty = strlen($userName) || strlen($userEmail) || strlen($userPassword) || strlen($userAge) || strlen($userGender);

  if ($notEmpty) {
    AddUser($pdo, $userName, $userEmail, $userPassword, $userAge, $userGender);
  }

/* Add a user to the table. */
function AddUser($pdo, $userName, $email,$password,$age,$gender) {

   $query = "insert into user (ID, USERNAME, EMAIL, PASS, AGE, GENDER) values (null,?, ?, ?, ?, ?);";
   $stmnt = $pdo->prepare($query);
   try {
            $stmnt->execute([$userName, $email,$password,$age,$gender]);

    //When the sign up is successful, login the user automatically
    $query= "Select * from user where EMAIL=? and PASS=?";
    $stmnt = $pdo->prepare($query);
    $stmnt->execute([$email,$password]);
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
            alert("Please choose another username");
            echo '<script>document.getElementsByName("Username")[0].value="',$userName ,'"</script>';
            echo '<script>document.getElementsByName("email")[0].value="',$email ,'"</script>';
            echo '<script>document.getElementsByName("age")[0].value="',$age ,'"</script>';
            echo '<script>document.getElementById("',$gender,'").checked=true; </script>';
         }
        }
        $pdo=null; //Closing connection
?>

<? php include "./footer.php"; ?>
