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

           
            echo '<a href="./clubs/modrn.html" class="list-group-item list-group-item-action flex-column align-items-start h-100">';
            echo '   <div class="d-flex w-100 justify-content-between">';
            echo '       <h5 class="mb-1 ml-3">',$rows[$i]['NAME'],'</h5>';
            echo '    </div>';
            echo '    <!-- Adding an image of the club -->';
            echo '    <div>';
            echo '        <img class="club-image" src="',$rows[$i]['IMAGE'],'" alt="Modrn Thumbnail" />';
            echo '    </div>';
            echo '    <div class="desc mr-5">';
            echo '        <p class="mb-1">',$rows[$i]['DESCRIPTION'],'</p>';
            echo '    </div>';
            echo "    <!-- spacing out the ratings -->"; 
            echo "    <br>";
            echo "    <br>";
            echo "    <br>";
            echo "    <br>";
            echo "    <br>";
            echo "    <br>";
            echo "    <br>";
            echo "    <br>";
            echo "    <!-- using font-awesome library to display the star ratings -->";
            echo '    <div class="rating mr-3">';
	    $numberOfStars=$rows[$i]['RATING'];
	    for($i=0; $i<$numberOfStars; $i++){
            	echo '        <span class="fa fa-star checked"></span>';
	    }
	    $noStars=5-$numberOfStars;
	    for($i=0; $i<$noStars; $i++){
           	 echo '        <span class="fa fa-star"></span>';                
            }
            echo "     </div>";
	    echo "</a>";
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

