<?php include "../../../inc/dbinfo.inc"; ?>
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
        <h1>Login</h1>
        <div class="main-agileinfo col-75">
            <div class="agileits-top ">
                <form id="userRegistration" action="helpers/login.php" method="POST">
                    <input class="text email" type="email" name="email" placeholder="Email" id="email">
                    <input class="text" type="password" name="password" placeholder="Password" id="password">
                    <input type="submit" id="submit" value="Login">
                </form>
            </div>
        </div>

    </div>

    <!-- The footer section -->
    <footer>
        <a href="../sitemap.xml">Sitemap</a>
    </footer> >

<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>


<?php

/* Add an employee to the table. */
function AddUser($connection, $userName, $email,$password,$age,$gender) {
   $n = mysqli_real_escape_string($connection, $userName);
   $e = mysqli_real_escape_string($connection, $email);
   $p = mysqli_real_escape_string($connection, $password);
   $a = mysqli_real_escape_string($connection, $age);
   $g = mysqli_real_escape_string($connection, $gender);


   $query = "insert into user (USERNAME, EMAIL, PASS, AGE, GENDER) VALUES ('$n', '$e', '$p', '$a', '$g');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding user data.</p>");
}

?>

