<!--include statements to import commonly used sections like header, nav menu and footer -->
<html lang="en">
<?php include "./header.php"; ?>
<?php
    //starting the session in order to retrieve session info 
    session_start();
?>
<!--import the stylesheet -->
<link rel="stylesheet" type="text/css" href="../css/main.css" />
</head>

<body>
    <!-- including the nav menu and footer--> 
    <?php include "./navigationMenu.php"; ?>
    <?php include "./footer.php"; ?>
</body>
</html>

