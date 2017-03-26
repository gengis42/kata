<div id="topbar" class="topbar">
<table border="0" width="100%" class="topbar">
	<tr class='topbar'>
		<td class='topbar'>
			<?php
			if(isset($_SESSION["login"]))
			{
				?>
				<a href="<?php echo $server_url;?>/index.php">home</a> | 
				<a href="<?php echo $server_url;?>/judges.php">judges</a> | 
				<a href="<?php echo $server_url;?>/kata.php">kata</a> | 
				<a href="<?php echo $server_url;?>/print.php">print</a> | 
				<a href="<?php echo $server_url;?>/result.php">live results</a> | 
				
				<?php
				if($_SESSION["user_level"] == 1) {
				?>
					<a href="<?php echo $server_url;?>/settings.php">settings</a> | 
					<a href="<?php echo $server_url;?>/users.php">users</a> | 
				<?php
				}
				?>
				<a href="<?php echo $server_url;?>/tablet.php">tablet</a> | 
				<a href="<?php echo $server_url;?>/tablet/monitor.php" target="_blank">monitor</a>
				<?php
			}
			?>
		</td>

		<td align="right" class='topbar'>
		<?php
		if(!(isset($_SESSION["login"])))
		{
		?>

		<form action="login.php" method="post" name="login" style="margin: 0px; padding: 0px; border: 0px;"> 
				<!--<input name="user" type="text" class="form"><br>-->
				<input name="user" type="text" class="form" value="username" onFocus="if(this.value=='username'){this.value='';this.focus();}" onBlur="if(this.value==''){this.value='username'}">
				<!--<input name="pass" type="password" class="form"> -->
				<input name="pass" type="password" class="form" value="password" onFocus="if(this.value=='password'){this.value='';this.focus();}" onBlur="if(this.value==''){this.value='password'}">
				<input name="ok" type="submit" value="login"> 
		</form>

		<?php
		}
		else
		{
			if($_SESSION["user_level"]=="1")
			{
				echo "<span style=\"color: red\">administrator</span> | ";
			}
			//print("{$_SESSION["username"]} <a href=\"logout.php\">logout</a>");
			
			echo $_SESSION["username"]." <a href='".$server_url."/logout.php'>logout</a>";
		}
		?>
		</td>
	</tr>
</table>
</div>
