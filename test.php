<?php

$a = 1;

//echo $a;

echo '<h1>This is login page, Please input your username and password</h1>';

for ( $i = 1 ; $i< 100 ; $i++)

{	
//	echo $i;
//	echo "</br>";
}


?>

<html>
	<head></head>
	<body>
		<form action = "tt.php" method="post">
			name:<input type = "text" name="name"><br>
			password:<input type = "password" name="pwd"><br>
			<input type="submit"><input type="reset">
		</form>

	</body>
</html>



