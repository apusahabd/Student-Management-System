<?php 
	
	$host = 'localhost';
	$dbuser = 'root';
	$dbpwr = 'apu55555';
	$dbname = 'student_db';

	$con = mysqli_connect($host,$dbuser,$dbpwr,$dbname);
	if(!$con){
		echo mysqli_connect_error();
	}
?>