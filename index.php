<?php
	
	if(!isset($_SESSION['username'])){
		header ('Location: login/login.php');
	}
?>