<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Sign up</title>
    
</head>
<body>
    <div id="header">
        <h3>Multi Factor Authentication</h3>
    </div>

<?php
	$con = mysqli_connect("localhost:3308","root","") 
	or die("Unable to connect");
	mysqli_select_db($con, 'mfs');

	if(isset($_GET['email']) && !empty($_GET['email'])
	AND isset($_GET['hash']) && !empty($_GET['hash'])){
    
    $email = mysql_escape_string($_GET['email']); 
    $hash = mysql_escape_string($_GET['hash']);
	
	
	$query = "SELECT email, hash, active FROM 
	users WHERE email='".$email."' AND hash='"
	.$hash."' AND active='0'";
    $result = mysqli_query($con, $query);             

                 
    if($result){
        
        $updatequery = "UPDATE users SET active='1'
		WHERE email='".$email."' AND hash='".$hash.
		"' AND active='0'";
		$updateresult = mysqli_query($con, $updatequery);
        echo '<div class="statusmsg"><h2>Your account 
		has been activated, you can now login</h2></div>';
    }else{
        
        echo '<div class="statusmsg">The url is either
		invalid or you already have activated your account.</div>';
    }
                 
}else{
  
    echo '<div class="statusmsg">Invalid approach,
	please use the link that has been send to your email.</div>';
}

?>

<a href = "login.php"><button>Login</button> </a>

</body>
</html>

