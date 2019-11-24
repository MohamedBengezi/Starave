<?php 
    session_start();
    echo $_SESSION['ID'];
    session_unset();
    session_destroy();
    unset($_SESSION['ID']);
    echo $_SESSION['ID'];
    header("Location: ../objectRegistration.php");
?>
