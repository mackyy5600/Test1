<?php
session_start();
include 'consqli.php';

$admin_login = null;
if (isset($_SESSION["admin_login"])) {
	// login pass
	$admin_login = $_SESSION["admin_login"];
}

if (!empty($_GET)) {
	$id = $_GET['id'];
	if ($id !== null) {

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM `drug` WHERE `drug`.`drug_id` = ?;";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header('Location: 4.stock.php');
	} else {
		header('Location: 4.stock.php');
	}
}
