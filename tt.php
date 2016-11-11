<?php
error_reporting(E_ALL);
#echo $_POST['name'];
echo "</br>";
#echo $_POST['pwd'];
echo "<br/>";
echo "connect mysql<br/>";
echo 'search user:  '.$_POST['name']."<br/>";


if ($_POST['name'] != 'yueyue')
{
	echo "<h1 color='red'>User not allowed</h1><br/>";
}

if( $_POST['pwd'] != 123 )
{
	echo "<h1 color='red'>password not correct, User not allowed</h1><br/>";
}else{


	echo 'login success!';
	echo "<br/>";

	echo 'redirct to homepage,please waiting...';
	echo "<br/>";

	header('b.php');
}
	
?>
