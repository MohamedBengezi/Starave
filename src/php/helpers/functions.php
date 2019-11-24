<?php

	//This function prints the errorMessage on browser's console
	function printError($errorMessage){
		echo '<script>console.log("',$errorMessage,'");</script>';
	}
	
	//This function alerts the messages in client browser
	function alert($Message){
		echo '<script>alert("',$Message,'");</script>';
	}
	
	function goHome(){
		echo '<script>window.location.replace("https://starave.club/src/home.php");</script>';
		// header("Location: ../home.php");
	}
?>

