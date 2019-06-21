<?php
		
	$con = mysqli_connect("localhost:3308","root","") 
	or die("Unable to connect");
	mysqli_select_db($con, 'mfs');
	session_start();
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Login</title>
    <link href="css/style.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <div id="header">
        <h3>Login</h3>
    </div>
  
    <div id="wrap">
   
        <h3>Login Form</h3>
        <p>Please enter your name and password to login</p>
         
        <?php 
            if(isset($msg)){ // Check if $msg is not empty
                echo '<div class="statusmsg">'.$msg.'</div>';
            } 
		?>
         
        
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" value="" /><br/>
            <label for="password">Password:</label>
            <input type="password" name="password" value="" /> <br/>
			<label for="phone">Phone Number:</label>
            <input type="number" name="phone" value="" />
			
             
            <input type="submit" name = "generate" class="submit_button" 
			value="Generate OTP" />
        </form>
        
    </div>

<?php
if(isset($_POST['generate'])) {

	if(isset($_POST['name']) && !empty($_POST['name'])
	AND isset($_POST['password']) && 
    !empty($_POST['password']))
	{
	$username = mysql_escape_string($_POST['name']);
	$password = mysql_escape_string(md5($_POST['password']));
	$phone = $_POST['phone'];

				 
	$query = "SELECT username, password, active FROM users
	WHERE username='".$username."' AND password='".$password."' AND active=1"; 
	$results = mysqli_query($con, $query);


	$insert = "update users set phone = '$phone' where username = '$username'";
	$insertresults = mysqli_query($con, $insert);



	if($results) {
		$authKey = "202216A5QenzYQYP5aa6171d";
		$mobileNumber = $_POST['phone'];
		$senderId = "MSGIND";
		$rndno=rand(10000, 99999);
		$message = urlencode("The OTP you requested for: ".$rndno.". Thank You.");
		$route = "route=4";
		$postData = array(
		'authkey' => $authKey,
		'mobiles' => $mobileNumber,
		'message' => $message,
		'sender' => $senderId,
		'route' => $route
		);
		$_SESSION['phone']=$_POST['phone'];
		$_SESSION['otp']=$rndno;
		
		
		$url="https://control.msg91.com/api/sendhttp.php";
		$ch = curl_init();
		curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $postData
		//,CURLOPT_FOLLOWLOCATION => true
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//get response
		$output = curl_exec($ch);
		//Print error if any
		if(curl_errno($ch)) {
		?>
		<script>
		alert('Error in sending otp please check once agian');
		
		</script>
		<?php
		}
		
		curl_close($ch);
		header ("Location: verifyOTP.php");

	}else {
		$msg = 'Login Failed! Please make sure that you 
		enter the correct details and that you have 
		activated your account.';
		echo $msg;
	}
		
	}

}
?>
	</body>
</html>