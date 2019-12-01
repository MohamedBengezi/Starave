<?php //Logout the user by destroying session and redirecting to home
session_start();
session_unset();
session_destroy();
unset($_SESSION['ID']);
unset($_SESSION['PAGE']);
unset($_SESSION['LOGINFAILED']);
header("Location: ../home.php");
