<?php include "./helpers/functions.php"; ?>
<?php
	session_start();
   	
	$rows = $_SESSION['rows'];
	$number = count($rows);

			
       
	
	printError("In results.php");
	printError($number);
?>
<?php include "./header.php" ?>
<link rel="stylesheet" type="text/css" href="../css/results.css" />
</head>

<body>
	<?php include "./navigationMenu.php"; ?>
	<!-- This div contains each object in the search results page-->
    	<div class="search-results h-100">
        	<div class="list-group h-100">

            	<!-- Club object -->
		<?php 
			for($i=0; $i<$number; $i++){
				$name = $rows[$i]['NAME'];
    				printError($name);


			}
		?>
                 	
<a class="list-group-item list-group-item-action flex-column align-items-start h-100">
                <div id="map"></div>
                <script type="text/javascript" src="../js/results.js"> </script>
                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDp09JfPFgRPWolTTBxqgBbJHbeqOc5Mak&callback=initMap">
                </script>
            </a>
	</div>
	</div>
<?php include "./footer.php"; ?>

