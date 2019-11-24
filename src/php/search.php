<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    session_start();
    // Check if session is a logged in one, if it isn't then redirect to login.
    if (!isset($_SESSION['ID'])){
        header("Location: userLogin.php");
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
    <link rel="stylesheet" type="text/css" href="../css/search.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/index.js"></script>
    <script type="text/javascript" src="../js/objectRegistration.js"></script>

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark"> <!-- Navbar is created using bootstrap's template and contains 5 links -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../home.php"> <!-- This link will redirect the user to home page-->
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="userRegistration.php">Register</a> <!-- This link will redirect the user to user registration page-->
                    </li>
                   <li class="nav-item">
                        <a class="nav-link" href="objectRegistration.php">Add Club</a> <!-- This link will redirect the user to club registration page-->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Contact Us</a> <!-- This link will redirect the user to contact page. This page is not implemented yet. -->
                    </li>
                    <?php if (isset($_SESSION['ID'])) { ?>
                           <a class="nav-link" href="helpers/logout.php">Logout</a>
                    <?php } ?>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="search.php">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> <!-- This link will redirect the user to searhc page-->
                </form>
            </div>
        </nav>
    </header>

    <form id="searchForm" class="col-xs-4 col1 center-block w-100" action="results.php" method="post">
        <!-- This section contains all the inputs required to do a specific search for clubs -->
        <div class="search-form">
            <div class="">
                <h2 class="text-uppercase mt-3">Name</h2>
                <input class=" w-25 name " type="search" placeholder="Optional" aria-label="Search" name="clubName">
            </div>
            <div id="location-select">
                <h2 class="text-uppercase mt-3">Location</h2>
                    <input type="number" step="0.000000001" name="latitude" placeholder="Latitude" required="" class=" w-25 name ">
                    <input type="number" step="0.000000001" name="longitude" placeholder="Longitude" required="" class=" w-25 name ">

                    <input type="button" class="btn btn-outline-success mt-2 mb-2" onclick="getLocation()" value="Find Location">

            </div>
            <div id="rating-select">
                <h2 class="text-uppercase mt-3">Rating</h2>
                <select class="custom-select w-25" name="rating">
                    <option selected value="1">1+ stars</option>
                    <option value="2">2+ stars</option>
                    <option value="3">3+ stars</option>
                    <option value="3">4+ stars</option>
                    <option value="3">5 stars</option>
                </select>
            </div>
            <br>
            <button class="btn btn-outline-success mt-2" type="submit">Find Clubs!</button>
    </form>
     <!-- The footer section -->
    <footer>
        <a href="../../sitemap.xml">Sitemap</a>
    </footer> 

</body>
</html>

