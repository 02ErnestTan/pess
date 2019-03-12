<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log Call</title>
<script>
	function validateForm() 
	{
		var x = document.forms["frmLogCall"]["callerName"].value;
		if (x == "") 
		{
			alert("Name must be filled out");
			return false;
		}
	}
</script>
<?php 
	include 'header.php';
	
	if(isset($_POST['btnProcessCall']))
	{
		$con = mysql_connect("localhost", "ErnestTan", "8364815");
		if(!con)
			die("Cannot connect to database: ". mysql_error());
		mysql_select_db("02_Ernest Tan_PESSDB", $con);
		
		$sql = "INSERT INTO incident(callerName, phoneNumber, incidentTypeId, incidentLocation, incidentDesc, incidentStatusId)
		VALUES('$_POST[callerName]', '$_POST[contactNo]','$_POST[incidentType]','$_POST[location]','$_POST[incidentDesc]','1')";
		$sql;
		if(!mysql_query($sql, $con))
		{
			die("Error: " . mysql_error());
		}
		mysql_close($con);
	}
?>
</head>
<body>
	<?php				
							// localhost, accountName, password
		$con = mysql_connect("localhost", "Ernest", "8364815");
		if(!$con)
			die("Cannot connect to database: " . mysql_error());
					
					// databaseName
		mysql_select_db("02_Ernest Tan_pessdb", $con);
		
		$result = mysql_query("SELECT * FROM incidenttype");
		
		$incidentType;
		
		while($row = mysql_fetch_array($result))
			$incidentType[$row['incidentTypeId']] = $row['incidentTypeDesc'];
		
		mysql_close($con);
	?>

	<form name="Form1" method="POST" onsubmit="return validateForm()" action="dispatch.php">
	<fieldset>
		<legend>Log Call</legend>
		<table>
			<tr>
				<td align="right">Caller Name:</td>
				<td><p><input type="text" name="callerName" /></p></td>
			</tr>
			<tr>
				<td align="right">Contact Number:</td>
				<td><p><input type="text" name="contactNo" /></p></td>
			</tr>
			<tr>
				<td align="right">Location:</td>
				<td><p><input type="text" name="location" /></p></td>
			</tr>
			<tr></tr>
			<tr>
			<td align="right" class="td_label">Incident Type:</td>
			<td class="td_Date">
				<p>
				<select name="incidentType" id="incidentType">
					<?php foreach($incidentType as $key => $value){?>
						<option value="<?php echo $key ?>"><?php echo $value ?></option>
					<?php }?>
				</select>
				</p>
			</td>
		</tr>
		<tr>
			<td align="right">Description:</td>
			<td><p><textarea name="incidentDesc" rows="5" cols="50"></textarea></p></td>
		</tr>
		<tr>
			<td align="right"><input type="reset" /></td>
			<td><input type="submit" name="btnProcessCall" value="Process Call" /></td>
		</tr>
		</table>
	</form>
</body>
</html>
		