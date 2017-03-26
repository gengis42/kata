<!DOCTYPE HTML>
<?php
require_once "config.inc.php";
session_start();
session_destroy();

header("Location: $server_url");
?>
