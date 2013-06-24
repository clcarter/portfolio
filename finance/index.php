<?php
	/*this function is from the php man pages for bcrypt */	
	function hasher($info, $encdata = false) 
	{ 
		$strength = "12"; 
		//if encrypted data is passed, check it against input ($info) 
		if ($encdata) { 
	/*		print $encdata.'<br />';
  			print substr($encdata, 0, 60).'<br />';
			print crypt($info, "$2y$".$strength."$".substr($encdata, 60)).'<br />';*/
   		if (substr($encdata, 0, 60) == crypt($info, "$2y$".$strength."$".substr($encdata, 60))) { 
				return true; 
 			} 
			else { 
      		return false; 
			} 
		} 
		else { 
			//make a salt and hash it with input, and add salt to end 
			$salt = ""; 
  			for ($i = 0; $i < 22; $i++) { 
				$salt .= substr("./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789", mt_rand(0, 63), 1); 
			} 
			//return 82 char string (60 char hash & 22 char salt) 
			return crypt($info, "$2y$".$strength."$".$salt).$salt; 
		} 
	} 
 
session_start();
require_once 'ajax/runQuery.php';
require_once 'inc/docHead.php';

require_once 'inc/header.php';

print '<div class="gridContainer clearfix" >';

require_once 'auth/login.inc';

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$username=$_POST['myusername'];
	$password=mysql_real_escape_string($_POST['mypassword']);

/** All the code from this point on is my code **/

	$c = new sqlConnect();
	$sql="SELECT password FROM login_info WHERE username='$username' LIMIT 1";
	if($result=$c->runSQL($sql)){
		$data=$result->fetch_assoc();
		if(hasher($password,$data['password']) == true){
			//login is valid
			//$_SESSION['courses_set']=$data['courses_set'];
			$_SESSION['username']=$username;
			print ('<h2 style="color:#f3b63c">Authentication Successful</h2><p style="color:#fff">click <a href="home.php" style="color:#f3b63c">here</a> if you are not redireted in 5 seconds</p>');
			header('Refresh:3; URL=home.php');
		}
		else {
			//login invalid
			print ('<h2 style="color:#f00">Authentication Failed</h2>');
		}
		print('</div>');
	}
	$c->closeSQL();
}
elseif(!empty($_SESSION['username'])){
	header('Location:home.php');
}

?>
</div>
</body>
</html>
