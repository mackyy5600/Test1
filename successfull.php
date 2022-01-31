<?php
session_start();
$se = session_id();
$admin_login = null;
if (isset($_SESSION["admin_login"])) {
	// login pass
	$admin_login = $_SESSION["admin_login"];
	session_regenerate_id();
	session_start();
	$se2 = session_id();
	$admin_login2 = $_SESSION["admin_login"];

	header("Location: 3.search.php");
} else {
	// no login
	header("Location: register.php");
}
