<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	// Load Composer's autoloader
	require 'vendor/autoload.php';
	
	$con = mysqli_connect("localhost:3308","root","") 
	or die("Unable to connect");
	mysqli_select_db($con, 'mfs');
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Sign up</title>
    <style>
		* {
			padding: 0;
			margin: 0; 
		}
		 
		body {
			background: #F9F9F9; 
			font: 14px "Lucida Grande";
			color: #464646;
		}
		 
		p {
			margin: 10px 0px 10px 0px; 
		}
		 
		#header {
			height: 45px;
			background: #464646; 
		}
		 
		#header h3 {
			color: #FFFFF3; 
			padding: 10px;
			font-weight: normal; 
		}
		 
		#wrap {
			background: #FFFFFF; 
			width: 615px; 
			margin: 0 auto; 
			margin-top: 50px; 
			padding: 10px; 
			border: 1px solid #DFDFDF; 
			text-align: center; 
		}
		 
		#wrap h3 {
			font: italic 22px Georgia; 
		}
		 
		form {
			margin-top: 10px; 
		}
		 
		form .submit_button {
			background: #F9F9F9; 
			border: 1px solid #DFDFDF; 
			padding: 8px; 
		}
		 
		input {
			font: normal 16px Georgia; 
			border: 1px solid #DFDFDF; 
			padding: 8px;
		}

		#wrap .statusmsg {
			font-size: 12px; 
			padding: 3px; 
			background: #EDEDED; 
			border: 1px solid #DFDFDF; 
		}
	
	</style>
	</head>
	<body>

		<div id="header">
			<h3>Multi Factor Authentication</h3>
		</div>
		<div id="wrap">
			<h3>Signup Form</h3>
			<p>Please enter your name and email address 
			to create your account</p>

			<form action="" method="post">
				<label for="name">Name:</label>
				<input type="text" name="name" value="" />
				<label for="email">Email:</label>
				<input type="text" name="email" value="" />
				 
				<input type="submit" name = "signup" 
				class="submit_button" value="Sign up" />
				
			</form>
<?php
 
if(isset($_POST['signup'])) {
	if(isset($_POST['name']) && !empty($_POST['name']) AND
	isset($_POST['email']) && !empty($_POST['email'])) {
		$name = mysql_escape_string($_POST['name']);
		$email = mysql_escape_string($_POST['email']); 
		
		
			// Return Success - Valid Email
			$msg = 'Your account has been made, <br /> please 
			verify it by clicking the activation link that has
			been send to your email.';
			
			$hash = md5( rand(0,1000) );
			$password = rand(1000,5000); 
			
			$query = "INSERT INTO users (username, password, email, hash) VALUES(
			'". mysql_escape_string($name) ."', 
			'". mysql_escape_string(md5($password)) ."', 
			'". mysql_escape_string($email) ."', 
			'". mysql_escape_string($hash) ."') ";
			
			$result = mysqli_query($con,$query);	
					
			$mail = new PHPMailer(); // create a new object
			$mail->IsSMTP(); // enable SMTP
			$mail->SMTPDebug = 1; 
			$mail->SMTPAuth = true; // authentication enabled
			$mail->SMTPSecure = 'tls'; 
			$mail->Host = "smtp.gmail.com";
			$mail->Port = 587; 
			$mail->IsHTML(true);
			$mail->Username = "officialaishu@gmail.com";
			$mail->Password = "Mazes12345";
			$mail->SetFrom("officialaishu@gmail.com");
			$mail->Subject = "Verification";
			$mail->Body = '

				Thanks for signing up!<br/>
				Your account has been created, you can 
				login with the following credentials 
				after you have activated your account 
				by pressing the url below.
				<br/><br/>
				 
				------------------------ <br/>
				Username: '.$name.' <br/>
				Password: '.$password.' <br/>
				------------------------ <br/><br/>
				 
				Please click this link to activate 
				your account:
				<br/>
				http://localhost/MFS/verify.php?email='
				.$email.'&hash='.$hash.' <br/>';
			$mail->AddAddress($email);

			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo "Message has been sent";
			}

			echo '<script type = "text/javascript"> 
			alert("Verify using mail") </script>';
		
	} else	{
		$msg = 'Please enter all fields';
	}
		
	if(isset($msg)) {  
		echo '<br>';
		echo '<div class="statusmsg">'.$msg.'</div>';
	} 			
}		 
?>
			
		</div>	
	</body>
</html>