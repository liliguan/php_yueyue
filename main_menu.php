<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
<?php
	if ($_SESSION['currentid']!=session_id()) {
		header("http://127.0.0.1:8080/Log_in.php");
		exit();
	}
	else {
		$username=$_SESSION[session_id()]['Username'];
	}
	//connect database
	$con = mysqli_connect("localhost","root","123456","erms");
	//get esf and their description
	$query_getesf="select * from esf";
	$result_getesf=mysqli_query($con,$query_getesf);
	$esf_array=array();
	while ($row_getesf=mysqli_fetch_array($result_getesf,MYSQLI_ASSOC)) {
		$esf_array[$row_getesf['ESFNumber']]=$row_getesf['ESFDescription'];
	}
	$_SESSION['esf']=$esf_array;
	//get cost type
	$query_getcost="select * from cost";
	$result_getcost=mysqli_query($con,$query_getcost);
	$cost_array = array();
	while ($row_getcost=mysqli_fetch_array($result_getcost,MYSQLI_ASSOC)) {
		array_push($cost_array, $row_getcost['TypeName']);
	}
	$_SESSION['cost']=$cost_array;


	//find user information
	$users_type= array("Municipality","Company","GovernmentAgency","Individual");
	foreach($users_type as $table) {
		$query="select * from ".$table." inner join user on user.username = ".$table.".username where user.username ='".$username."'";
		$result=mysqli_query($con,$query);
		if (mysqli_num_rows($result)==1) {
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$user_type_table=$table;
			break;
		}
	}
	echo $row['Name'];
	$_SESSION[session_id()]['Name']=$row['Name'];
	echo "<br/>";
	//show characteristics of different users 
	if ($user_type_table=="Municipality") {
		$User_detail=$row["PopulationSize"];
	}
	elseif ($user_type_table=="Company") {
		$User_detail=$row["LocationOfHeadquarter"];
	}
	elseif ($user_type_table=="GovernmentAgency") {
		$User_detail=$row["Jurisdiction"];
	}
	else {
		$User_detail= $row["JobTitle"]."  ".$row["HiredDate"];
	}
	$_SESSION[session_id()]['User_Detail']=$User_detail;
	echo $_SESSION[session_id()]['User_Detail'];

	mysqli_close($con);
?>
	<table>
	<tr> <td><a href="http://127.0.0.1:8080/New_Resource.php"> Add Resource </a> </td></tr>
	<tr><td><a href="http://127.0.0.1:8080/Add_Incident.php"> Add Emergency Incident </a></td></tr>
	<tr> <td><a href="http://127.0.0.1:8080/Search_Resource.php"> Search Resources </a> </td></tr>
	<tr> <td><a href="http://127.0.0.1:8080/Resource_Satus.php"> Resource Status </a> <td></tr>
	<tr> <td><a href="http://127.0.0.1:8080/Resource_Report.php"> Resource Report </a> </td></tr>
	<tr> <td><a href="http://127.0.0.1:8080/Log_in.php">Exit</a> </td></tr>
	</table>
</body>
</html>








