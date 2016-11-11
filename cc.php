
			<?php
				$con = mysqli_connect();
				$sql = 'select option from xxxx';
				$sql_user= 'select * from user';
				$result = mysqli_query($con, $sql);
				$result_user = mysqli_query($con, $sql_user);
				$options = as_array($result);
				$user = as_array($result_user);
				mysqli_close();
			?>
<html>
<head>
</head>
<body>
	
	<form action='ccxx.php' method="post">	
		<select name ="ll">

			<?php
				foreacho($options as $k => $v)
				{
					echo '<option value="'.$k.'">'.$v.'</option>';
				}
			?>
				
		</select>
		<br/>
		
		name:<input type="text" name="name"/>
		<input type="submit" value="Submit Button"/>
		<input type="reset" value = "Reset Button"/>	
	</form>

	<>
	<>
</body>
</html>
