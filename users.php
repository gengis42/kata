<!DOCTYPE HTML>
<?php
session_start();
require_once "session.inc.php";
require_once "session.admin.inc.php";
require_once "config.inc.php";

if(isset($_POST["addUser"]))
{
	require_once "session.admin.inc.php";
	if($_POST["password"] == $_POST["repeatpassword"] and $_POST["password"] != "")
	{
		$sql="INSERT INTO users (username, password, user_level) VALUES (:username, :password, :user_level)";
		$result = $db->prepare($sql);
		$result->bindValue(':username', $_POST["username"]);
		$result->bindValue(':password', md5($_POST["password"]));
		$result->bindValue(':user_level', $_POST["user_level"]);
		$result->execute();
	}
}
if(isset($_POST["removeUser"]))
{
	require_once "session.admin.inc.php";
	
	//controllo che non sia admin
	$sql="SELECT username FROM users WHERE userid = :userid";
	$result = $db->prepare($sql);
	$result->bindValue(':userid', $_POST["removeUser"]);
	$result->execute();
	$row = $result->fetch(PDO::FETCH_ASSOC);
	if($row["username"] != "admin")
	{
		$sql="DELETE FROM users WHERE userid = :userid";
		$result = $db->prepare($sql);
		$result->bindValue(':userid', $_POST["removeUser"]);
		$result->execute();
	}
}


?>

<html>
<head>
<title>Users</title>
<script type="text/javascript" src="jquery-1.7.2.min.js"></script>
<!--fancybox-->
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript" src="users.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<!--<body onload="checkDraw()" onFocus="checkDraw(); window.location.href=window.location.href">-->
<!--<body onload="checkDraw()">-->

<body>

<?php
require_once "top.php";
?>


	<p>

	<form method='post'>
	<table border='1'>
	<tr>
		<td width='250'>username</td>
		<td width='250'>level</td>
		<?php
		if($_SESSION["user_level"]=="1")
		{
			?>
			<td></td>
			<?php
		}
		?>
	</tr>
	<?php
	$sql="SELECT * FROM users ORDER BY userid";
	$result = $db->query($sql);
	while($row = $result->fetch(PDO::FETCH_ASSOC))
	{
		echo "<tr>";
		echo "<td>".$row["username"]."</td>";
		echo "<td width='40' align='center'>";
		if($row["user_level"] == "0")
			echo "normal";
		else
			echo "admin";
		echo "</td>";
		
		if($_SESSION["user_level"]=="1")
			echo "<td>
			<a class='editUser' href='edit/editUser.php?idUser=".$row["userid"]."'><img src='image/edit-icon.png' width='15' height='15'></a>
			<button type='submit' name='removeUser' value='".$row["userid"]."' onclick=\"return confirm('Confirm delete?')\">remove</button>
			</td>";
		echo "</tr>";
	}
	?>
	</table>
	<?php
	if($_SESSION["user_level"]=="1")
	{
		?>
		username:<input type='text' name='username'/><br>
		password:<input type='password' name='password'/><br>
		repeat: <input type='password' name='repeatpassword'/><br>
		<select name='user_level'>
			<option value='0'>normal</option>
			<option value='1'>admin</option>
		</select>
		<input type='submit' name='addUser' value='add'/>
		<?php
	}
	?>

	</form>
</p>
</body>
</html>
