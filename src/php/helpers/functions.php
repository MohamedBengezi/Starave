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
	
	function goHome(){
		echo '<script>window.location.replace("https://starave.club/src/php/home.php");</script>';
		// header("Location: ../php/home.php");
	}
	function showResults(){
                echo '<script>window.location.replace("https://starave.club/src/php/results.php");</script>';
                // header("Location: ../php/home.php");
        }
function hashPass($pass) {
    $salted = "djnfoiuwe9832482nwejfn".$pass."iowjdqio";
    $hashed = hash('sha512', $salted);
    return $hashed;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

