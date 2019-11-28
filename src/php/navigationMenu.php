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
                        <a class="nav-link" href="../php/home.php">
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
              <?php if (isset($_SESSION['ID'])) { ?>
                    <a class="nav-link" href="helpers/logout.php">Logout</a>
              <?php }else{ ?>
                    <a class="nav-link" href="helpers/login.php">Login</a>
              <?php } ?>
                </ul>
                <form class="form-inline my-2 my-lg-0" action="search.php">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </header>

