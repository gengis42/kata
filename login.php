<!DOCTYPE HTML>
<?php
require("config.inc.php");

if(isset($_POST["user"]))
{
	$user_ctrl = addslashes($_POST["user"]);
	$pass_ctrl = md5(addslashes($_POST["pass"]));
	
	
	// controlla l'utente
	$sql = "SELECT * FROM users WHERE (username = :username AND password = :password)";
	
	$result = $db->prepare($sql);
	$result->bindValue(':username', $user_ctrl);
	$result->bindValue(':password', $pass_ctrl);
	$result->execute();
	
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$empty = $result->rowCount();
	
	if ($empty != 0) 
	{
		// Start session.
		session_start();
		//$_SESSION["login"] = "ok";
		$_SESSION["login"] = "kata";
		$_SESSION["username"] = $row['username'];
		$_SESSION["user_id"] = $row['userid'];
		$_SESSION["user_level"] = $row['user_level'];
		
	}
}

header("Location: index.php");
?>
