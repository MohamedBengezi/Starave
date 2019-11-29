<?php //Logout the user by destroying session and redirecting to home
session_start();
session_unset();
session_destroy();
unset($_SESSION['ID']);
header("Location: ../home.php");
