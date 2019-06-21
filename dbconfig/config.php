<?php
	$con = mysqli_connect("localhost:3308","root","") or die("Unable to connect");
	mysqli_select_db($con, 'feedback');
?>