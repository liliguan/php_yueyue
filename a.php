<?php


echo 'aa';
echo $_POST['name'];
echo $_POST['pwd'];

echo 'connect mysql<br/>';

echo 'search user'.$_POST['name'].'<br/>';

if ($_POST['name'] != 'yueyue')
{
	echo "<h1 color="red">User not allowed</h1>".<br/>;
}

if( $_POST['pwd'] != 123 )
{
	echo '<h1 color="red">password not correct, User not allowed</h1><br/>';
}

echo 'login success!';

echo 'redirct to homepage,please waiting...';

header('b.php');
	
?>
