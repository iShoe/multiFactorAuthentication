<?php
		
	$con = mysqli_connect("localhost:3308","root","")
	or die("Unable to connect");
	mysqli_select_db($con, 'mfs');
	session_start();
	
?>

<html>
	<head>
		<style>
			form {
				margin-top: 200px;
			}
		</style>
	</head>


	<body>
	<center>
		<form action="verifyOTP.php" method="post">

			<label><h1><font size=5 color="black">
			Enter OTP: </h1></font></label>
			<input type="Text" name="otpverify" required />
			<br><br>

			<input type = "submit" name = "verify" value = "Submit">
		</form>

<?php 

if(isset($_POST['verify'])) {
	@$entered_otp = $_POST['otpverify'];
	@$otp = $_SESSION['otp'];
	if($entered_otp == $otp) {
		echo '<h2>OTP Verification Successful!</h2>';
			
		echo '<br/> <br/> <a href = "home.php"> 
		<button> Proceed </button></a>';
	} else {
		echo '<h2>Wrong OTP!</h2>';
	}
	
}
?>
		</center>
	</body>
</html>