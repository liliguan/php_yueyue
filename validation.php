<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
	
<?php 
	//connect database
	$con = mysqli_connect("localhost","root","123456","erms");
	if (!$con) {
		die ('Could not connect:'.mysqli_error());
	}
	mysqli_select_db($con,'erms');
	//quert username and password
	$query="select * from user where username='".$_POST['Username']."' and password='".$_POST['Password']."'";
	$result=mysqli_query($con,$query);
	//validate
	if (mysqli_num_rows($result)==0) {
		echo "Invalid username or password";
		echo "Please go back to Log in Page";
		echo "<br/>";
		$next_action="Log_in.php";
		$submit_value="Back";
	}
	else {
		echo "Welcome,you have successfully logged in.";
		echo "<br/>";
		$next_action="main_menu.php";
		$submit_value="Continue";
		$_SESSION['currentid']=session_id();
		$_SESSION[session_id()] = array('Username' => $_POST['Username'], 'Password'=> $_POST['Password']);

	}
	mysqli_close($con);
?>
	<form action=<?php echo $next_action ?> method="post">
	<input type="submit" name="submit" value=<?php echo $submit_value ?> >
	</form>

</body>
</html>