<?php include "../../../inc/dbinfo.inc";?>
<?php include "./header.php";?>
<link rel="stylesheet" type="text/css" href="../css/userRegistration.css" />
</head>

<body>
    <?php include "./navigationMenu.php";?>

    <!-- Div for the user login form -->
    <div class="main-w3layouts wrapper">
        <h1>Login</h1>
        <div class="main-agileinfo col-75">
            <div class="agileits-top ">
                <!-- Redirect to login.php -->
                <form id="userRegistration" action="helpers/login.php" method="POST">
                    <input class="text email" type="email" name="email" placeholder="Email" id="email">
                    <input class="text" type="password" name="password" placeholder="Password" id="password">
                    <input type="submit" id="submit" value="Login">
                </form>
            </div>
        </div>

    </div>

    <?php include "./footer.php";?>

