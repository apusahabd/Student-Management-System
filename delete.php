<?php
	include_once('config.php');
	$id = $_GET['id'];
	
	$qry = "SELECT `Image` FROM `info` WHERE ID = '$id'";
	$run = mysqli_query($con,$qry);
	$info = mysqli_fetch_assoc($run);
	unlink("upload/".$info['Image']); 
	
	$qry="DELETE FROM `info` WHERE `ID` = '$id'";
	$drun = mysqli_query($con,$qry);
	
	header("location:allstudent.php");
?>