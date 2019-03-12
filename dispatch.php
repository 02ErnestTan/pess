<?php
	if(!isset($_POST['btnProcessCall']) && !isset($_POST['btnSubmit']))
		header("Location: logcall.php");
	include 'header.php';
?>
<?php
		if(isset($_POST["btnSubmit"]))
		{
			// Connect to database
		$con = mysql_connect("localhost", "Ernest", "8364815");
	
	
		if(!$con)
		{
			die('Cannot connect to database : '. mysql_error());
		}
	
		mysql_select_db("02_Ernest Tan_pessdb", $con);
	
		// Update patrolcar status table and dispatch table
		$patrolcarDispatched = $_POST["chkPatrolcar"];
	
		$c = count($patrolcarDispatched);	
	
		// Insert new incident	
		$status;
		if($c > 0)
		{
			$status ='2';
		}
		else
		{	
			$status ='1';
		}
	
		$sql = "INSERT INTO incident(callerName, phoneNumber, incidentTypeId, incidentLocation, incidentDesc, IncidentStatusId)
		VALUES ('".$_POST['callerName']."','".$_POST['contactNo']."', '".$_POST['incidentType']."','".$_POST['location']."','".$_POST['incidentDesc']."','$status')";
	
		if(!mysql_query($sql, $con))
		{
			die('Error1:' . mysql_error());
		}
	
		// Retrieve new incremental key for incidentId
		$incidentId = mysql_insert_id($con);
	
		for($i = 0; $i < $c; $i++)
		{
			$sql = "UPDATE patrolcar SET patrolcarStatusId ='1' WHERE patrolcarId = '$patrolcarDispatched[$i]'";
						
			if(!mysql_query($sql, $con))
			{
				die('Error2: '. mysql_error());
			}
			
			$sql = "INSERT INTO dispatch (incidentId, patrolcarId, timeDispatched)
			VALUES ('$incidentId', '$patrolcarDispatched[$i]', NOW())";
			
			if (!mysql_query($sql, $con))
			{
				die('Error3: '. mysql_error());
			}
		}
	
		mysql_close($con);
		}
?>	

<!DOCTYPE HTML>
<html>
<head>
<title>Dispatch</title>
</head>
<body>	
<?php
		/* Search and retrieve similar pending incidents
		and populate a table */
	
		// Connect to database
		$con = mysql_connect("localhost", "Ernest", "8364815");
		if(!$con)
		{
			die("Cannot connect to database:" . mysql_error());
		}	
	
		// Select a table in the database	
		mysql_select_db("02_Ernest Tan_pessdb", $con);
	
		$sql = "SELECT patrolcarId, statusDesc FROM patrolcar JOIN patrolcar_status
				ON patrolcar.patrolcarStatusId = patrolcar_status.statusId
				WHERE patrolcar.patrolcarStatusId = '2' OR patrolcar.patrolcarStatusId = '3'";
	
		$result = mysql_query($sql, $con);	
	
		$incidentArray;
		$count = 0;
	
		while($row = mysql_fetch_array($result))
		{
			$patrolcarArray[$count] = $row;
			$count++;
		}
	
		if(!mysql_query($sql, $con))
			die('Error: '. mysql_error());
	
		mysql_close($con);
	
	?>
	<form name="dispatchForm" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
	<table>
		<tr>
			<td>Caller Name:</td>
			<td>
				<?php echo $_POST['callerName']; ?>
				<input type="hidden" name="callerName" value="<?php echo $_POST['callerName']; ?>" />
			</td>
		</tr>
		<tr>
			<td>Contact Number:</td>
			<td>
				<?php echo $_POST['contactNo']; ?>
				<input type="hidden" name="contactNo" value="<?php echo $_POST['contactNo']; ?>" />
			</td>
		</tr>
		<tr>
			<td>Location:</td>
			<td>
				<?php echo $_POST['location']; ?>
				<input type="hidden" name="location" value="<?php echo $_POST['location']; ?>" />
			</td>
		</tr>
		<tr>
			<td>Incident Type:</td>
			<td>
				<?php echo $_POST['incidentType']; ?>
				<input type="hidden" name="incidentType" value="<?php echo $_POST['incidentType']; ?>" />
			</td>
		</tr>
		<tr>
			<td>Description:</td>
			<td>
				<?php echo $_POST['incidentDesc']; ?>
				<input type="hidden" name="incidentDesc" value="<?php echo $_POST['incidentDesc']; ?>" />
			</td>
		</tr>
	</table>
	<table width = "40%" border="1" align="center" cellpadding="4" cellspacing="8">
		<tr>
			<td width = "20%">&nbsp;</td>
			<td width = "51%">Patrol Car ID</td>
			<td width = "29%">Status</td>
		</tr>

		<?php
			$i = 0;
			while($i < $count) {
		?>
	
		<tr>
			<td class = "td_label"><input type="checkbox" name="chkPatrolcar[]" value="<?php echo $patrolcarArray[$i]['patrolcarId'] ?>"></td>
			<td><?php echo $patrolcarArray[$i]['patrolcarId'] ?></td>
			<td><?php echo $patrolcarArray[$i]['statusDesc'] ?></td>
		</tr>

		<?php $i++;
			} 
		?>

	</table>

	<table width ="80%" border ="0" align ="center" cellpadding ="4" cellspacing ="4">
		<td width ="46%" class ="td_label">
			<input type ="reset" name ="btnCancel" id ="btnCancel" value ="Reset">
		</td>
		<td width ="54%" class ="td_Data">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type ="submit" name="btnSubmit" id ="btnSubmit" value ="Submit">
		</td>
	</table>
	</form>
</body>
</html>