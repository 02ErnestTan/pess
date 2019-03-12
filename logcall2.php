<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log Call</title>
<?php include 'header.php'; ?>
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
		
		$incidenttype;
		
		while($row = mysql_fetch_array($result))
			$incidenttype[$row['incidentTypeId']] = $row['incidentTypeDesc'];
		
		mysql_close($con);
	?>
	
	<form name+"frmLogCall" method="POST" onsubmit="return validateForm()" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
		<table>
			<tr>
				<td>Caller Name:</td>
				<td><p><input type="text" name="callerName" /></p></td>
			</tr>
			<tr>
				<td>Contact No:</td>
				<td><p><input type="text" name="contactNo" /></p></td>
			</tr>
			<tr>
				<td>Location</td>
				<td><p><input type="text" name="location" /></p></td>
			</tr>
			<tr>
			<td align="right" class="td_label">Incident Type:</td>
			<td class="td_Date">
				<p>
				<select name="incidentType" id="incidentType">
					<?php foreach($incidenttype as $key => $value){?>
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