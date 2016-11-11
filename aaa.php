<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
	$con = mysqli_connect("localhost","root","123456","erms");
	//check void input of new resource form 
	$check_resource_void_array = array("ResourceName","ResourceLatitude","ResourceLongitude","CostValue");
	foreach ($check_resource_void_array as $value) {
		if (strlen($_POST[$value])==0) {
			echo "Please input ".$value."<br/>";
			exit();
		}
	}
	//check if longitude is number
	echo $_POST['ResourceLongitude'];
	if (!preg_match('/^-?\d*\.{0,1}\d+$/',$_POST['ResourceLongitude']) || (float)$_POST['ResourceLongitude'] < -180 || (float)$_POST['ResourceLongitude'] >180 ) {
		echo 'Invalid Longitude Number';
		exit();
	}
	else {
		//echo 'correct number';
		$_POST['ResourceLongitude']=(float)$_POST['ResourceLongitude'];
		echo $_POST['ResourceLongitude'];
	}
	//check if latitude is number
	if (!preg_match('/^-?\d*\.{0,1}\d+$/', $_POST['ResourceLatitude']) || (float)$_POST['ResourceLatitude'] < -90 || (float)$_POST['ResourceLatitude'] >90 ) {
		echo 'Invalid Latitude Number';
		exit();
	}  
	else {
		$_POST['ResourceLatitude']=(float)$_POST['ResourceLatitude'];
		echo $_POST['ResourceLatitude'];
	}
	//check if cost value is number 
	if (!preg_match('/^\d*\.?\d+$/', $_POST['CostValue'])) {
		echo 'Invalid Cost Value';
		exit();
	} 
	else {
		$_POST['CostValue']=(int)$_POST['CostValue'];
		echo $_POST['CostValue'];
	}
	$query_add_resource="INSERT INTO Resource (ResourceName,CostType,PrimaryESFNumber,CostValue,Description,
  ResourceLatitude,ResourceLongitude,ModelName,ResourceOwner,NextAvailableDate)
VALUES ('".$_POST['ResourceName']."','".$_POST['CostType']."',".$_POST['PrimaryESFNumber'].",".$_POST['CostValue'].",'".$_POST['Description']."',".
$_POST['ResourceLatitude'].",".$_POST['ResourceLongitude'].",'".$_POST['ModelName']."','".$_SESSION[session_id()]['Username']."',CURDATE());";
	echo $query_add_resource;
	$result_add_resource=mysqli_query($con,$query_add_resource);
	echo "<br/>";
	echo "Add new Resource success";
	echo "<br/>";
	//echo array_values($_POST['Sec_ESFNumber']);
	
	if (isset($_POST['Sec_ESFNumber'])) {
		foreach ($_POST['Sec_ESFNumber'] as $value) {
			$query_add_sec="INSERT INTO SecondaryESF VALUES (".$_SESSION[session_id()]['New_ResourceId'].','.$value.');';
			$result_add_sec=mysqli_query($con,$query_add_sec);
		}
	}
	echo "valid?";
	if (isset($_POST['Capabilities'])){
		echo "aaa"."<br/>";
		//$Capabilities=nl2br($_POST['Capabilities']);
		//$Capabilities_array=explode("<br/>", $Capabilities);
		$Capabilities=trim($_POST['Capabilities']);
		$Capabilities_array=explode("\r\n",$Capabilities);
		echo count($Capabilities_array)."<br/>";
		foreach ($Capabilities_array as $value) {
			echo $value."<br/>";
			$query_add_cap="INSERT INTO ResourceCapability VALUES(".$_SESSION[session_id()]['New_ResourceId'].",'".$value."');";
			echo $query_add_cap."<br/>";
			$result_add_cap=mysqli_query($con,$query_add_cap);
		}
	}
	

?>	

</body>
</html>