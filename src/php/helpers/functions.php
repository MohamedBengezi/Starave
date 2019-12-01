<?php

	//This function prints the errorMessage on browser's console
	function printError($errorMessage){
		$errorMessage=str_replace("\n","",$errorMessage);
		echo '<script>console.error("',$errorMessage,'");</script>';
	}
	
	//This function alerts the messages in client browser
	function alert($Message){
		echo '<script>alert("',$Message,'");</script>';
	}
	
	//This function redirects the user to home page
	function goHome(){
		echo '<script>window.location.replace("https://starave.club/src/php/home.php");</script>';
	}

	//This function shows the results to the user
	function showResults(){
                echo '<script>window.location.replace("https://starave.club/src/php/results.php");</script>';
        }

    //This function hashes the password and returns it    
	function hashPass($pass) {
	    $salted = "djnfoiuwe9832482nwejfn".$pass."iowjdqio";
	    $hashed = hash('sha512', $salted);
	    return $hashed;
	}

    //This function is used to prevent sql injection attacks.
	function test_input($data) {
	    $data = trim($data);
	    $data = stripslashes($data);
	    $data = htmlspecialchars($data);
	    return $data;
	}

?>

