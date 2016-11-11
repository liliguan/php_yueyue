<?php session_start(); ?>
<!DOCTYPE html>
<html>
<body>
<?php
	if ($_SESSION['currentid']!=session_id()) {
		header("http://127.0.0.1:8080/Log_in.php");
		exit;
	}
	else {
		$username=$_SESSION[session_id()]['Username'];
	}
	$con = mysqli_connect("localhost","root","123456","erms");
	$query_getid="select max(resourceid) as max from resource";
	$result_getid=mysqli_query($con,$query_getid);
	$row_getid=mysqli_fetch_array($result_getid,MYSQLI_ASSOC); 
	$new_id=$row_getid['max']+1;
	$_SESSION[session_id()]['New_ResourceId']=$new_id;
	$Longitude_err="";
	$Latitude_err="";
	$costvalue_err="";
	$name_err="";
	$query_success=0;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$Longitude_success=0;
			$Latitude_success=0;
			$costvalue_success=0;
			$name_success=0;
			//check empty name 
			if (empty($_POST['ResourceName'])) {
				$name_err="Resource Name is mandatory";
			}
			else {
				$name_success=true;
			}
			//check Longitude
			if (empty($_POST['ResourceLongitude'])) {
				$Longitude_err="Longitude is mandatory";
			}
			elseif (!preg_match('/^-?\d*\.{0,1}\d+$/',$_POST['ResourceLongitude']) || (float)$_POST['ResourceLongitude'] < -180 || (float)$_POST['ResourceLongitude'] >180 ) {
				$Longitude_err='Invalid Longitude Number';
			}
			else {
				$_POST['ResourceLongitude']=(float)$_POST['ResourceLongitude'];
				$Longitude_success=true;
			}
			//check Latitude
			if (empty($_POST['ResourceLatitude'])) {
				$Latitude_err='Latitude is mandatory';
			}
			elseif (!preg_match('/^-?\d*\.{0,1}\d+$/', $_POST['ResourceLatitude']) || (float)$_POST['ResourceLatitude'] < -90 || (float)$_POST['ResourceLatitude'] >90 ) {
				$Latitude_err= 'Invalid Latitude Number';
			}  
			else {
				$_POST['ResourceLatitude']=(float)$_POST['ResourceLatitude'];
				$Latitude_success=true;
			}
			//check if cost value is number 
			if (empty($_POST['CostValue'])) {
				$costvalue_err="Cost Value is mandatory";
			}
			elseif (!preg_match('/^\d*\.?\d+$/', $_POST['CostValue'])) {
				$costvalue_err= 'Invalid Cost Value';
			} 
			else {
				$_POST['CostValue']=(int)$_POST['CostValue'];
				$costvalue_success=true;
			}
			//add resource query
			if ($Latitude_success && $Longitude_success && $costvalue_success && $name_success) {
			$query_add_resource="INSERT INTO Resource (ResourceName,CostType,PrimaryESFNumber,CostValue,Description,
		  ResourceLatitude,ResourceLongitude,ModelName,ResourceOwner,NextAvailableDate)
		VALUES ('".$_POST['ResourceName']."','".$_POST['CostType']."',".$_POST['PrimaryESFNumber'].",".$_POST['CostValue'].",'".$_POST['Description']."',".
		$_POST['ResourceLatitude'].",".$_POST['ResourceLongitude'].",'".$_POST['ModelName']."','".$_SESSION[session_id()]['Username']."',CURDATE());";
				$query_success=true;
				$result_add_resource=mysqli_query($con,$query_add_resource);	
				if (isset($_POST['Sec_ESFNumber'])) {
					foreach ($_POST['Sec_ESFNumber'] as $value) {
						$query_add_sec="INSERT INTO SecondaryESF VALUES (".$_SESSION[session_id()]['New_ResourceId'].','.$value.');';
						$result_add_sec=mysqli_query($con,$query_add_sec);
					}
				}
				if (isset($_POST['Capabilities'])){
					$Capabilities=trim($_POST['Capabilities']);
					$Capabilities_array=explode("\r\n",$Capabilities);
					foreach ($Capabilities_array as $value) {
						$query_add_cap="INSERT INTO ResourceCapability VALUES(".$_SESSION[session_id()]['New_ResourceId'].",'".$value."');";
						$result_add_cap=mysqli_query($con,$query_add_cap);
					}
				}
		}
	}
	
?>
	<!--Main form -->
	<h4> New Resource Info </h4>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id ="new_resource_form">
	<table>
		<!-- row of  resource id -->
		<tr> <td> ResourceID </td> <td> <?php echo $new_id ?> </td> </tr>
		<!-- row of owner -->
		<tr> <td> Owner</td> <td> <?php echo $_SESSION[session_id()]['Name'] ?></td> </tr>
		<!-- row of resource name -->
		<tr> <td> Resource Name </td> <td> <input type="text" name="ResourceName"> </td> <td><font color="red"><?php echo $name_err?> </font></td></tr>
		<!-- row of resource description -->
		<tr> <td> Resource Description</td> <td><input type="text" name="Description"> </td></tr>
		<!-- row of primary esf -->
		<tr> <td> Primary ESF</td>
				<td> <select name="PrimaryESFNumber">
				<?php 
					foreach ($_SESSION['esf'] as $key => $value) {
						echo '<option value='.$key.'>'.$key.":".$value.'</option>';
						}
				?>
					</select></td></tr>
		<!-- row of addtional esfs-->
		<tr><td> Addtional ESFs</td>
			<td> <select multiple="multiple" name="Sec_ESFNumber[]" size="5">
				<?php
					foreach ($_SESSION['esf'] as $key => $value) {
						echo '<option value='.$key.'>'.$key.":".$value.'</option>';
					}
				?></select></td></tr>
		<!-- row of model -->
		<tr> <td> Model</td><td> <input type="text" name="ModelName"></td>	</tr>
		<!-- Location-->
		<tr> <td>Location:Latitude </td> <td> <input type="text" name="ResourceLatitude"></td><td><font color="red"><?php echo $Latitude_err ?></font></td></tr>
		<tr> <td>Location Longitude </td><td><input type="text" name="ResourceLongitude"></td><td><font color="red"><?php echo $Longitude_err?> </font></td></tr>
		<!-- row of Cost Type-->
		<tr> <td>Cost Type</td>
			<td> <select name="CostType">
				<?php
				foreach($_SESSION['cost'] as $value) {
					echo '<option value='.$value.'>'.$value.'</option>';
				}?></select></td></tr>
		<!-- Cost Value-->
		<tr><td> Cost Value$</td> <td>  <input type="text" name="CostValue"></td><td><font color="red"><?php echo $costvalue_err ?></font></td></tr>
		<!-- row of Capabilities-->
		<tr> <td> Capabilities</td>
			<td> <input type="text" id ="one_cap" > </td>
			<td> <button type="button" onclick="add_cap()">Add</button>
		</tr>
		<tr> <td></td> 
		<td>
			<textarea nrows="10" cols="50" name ="Capabilities" readonly="true" id="re_cap" >  </textarea></td>
			<script>
			function add_cap() {
				x=document.getElementById('one_cap');
				y=document.getElementById('re_cap');
				y.value=y.value+'\r\n'+x.value;
				x.value="";
			}</script>
		</tr>
		<!-- Submit and main menu button -->
		<tr> <td><input type="submit" name="Submit"></td> <td> <a href="http://127.0.0.1:8080/main_menu.php">Main Menu</a></td></tr> 
	</table>
	
	</form>
	<?php
	if ($query_success) {
		echo "Add Resource Success";
		
	}
	mysqli_close($con);
	?>
</body>
</html>