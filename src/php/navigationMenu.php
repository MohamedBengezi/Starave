<!-- php file for navigation menu that is displayed on most of the pages -->
<?php include "../../../inc/dbinfo.inc"; ?>
<?php
    session_start();
?>
 <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../php/home.php"> <!-- Link for the home page -->
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./userRegistration.php">Register</a> <!-- Link for user registration page -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./objectRegistration.php">Add Club</a> <!-- Link for adding club page -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Contact Us</a>
                    </li>
              <?php if (isset($_SESSION['ID'])) { ?>
                    <a class="nav-link" href="helpers/logout.php">Logout</a> <!-- Link to logout the user -->
              <?php }else{ ?>
                    <a class="nav-link" href="helpers/login.php">Login</a> <!-- Link for the user to log into the application -->
              <?php } ?>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="search.php">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> <!-- Link for the search page -->
                </form>
            </div>
        </nav>
    </header>

