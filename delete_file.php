<?php
session_start();
include 'consqli.php';

$admin_login = null;
if (isset($_SESSION["admin_login"])) {
	// login pass
	$admin_login = $_SESSION["admin_login"];
	//echo $user_login.'<== $user_login <br>';
}

if (!empty($_GET)) {
	$filename = $_GET['filename'];
	$p_id = $_GET['p_id'];

	if ($filename !== null) {

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE `drug` SET `drug_picture` = '-' WHERE `drug`.`drug_id` = ?;";
		$q = $pdo->prepare($sql);
		$q->execute(array($p_id));
		Database::disconnect();
		unlink("pic_drug/$filename");
		header('Location: stock_edit.php?id=' . $p_id);
		//header('Location: product_edit.php?id='.$p_id);
	} else {
		echo 'fail!';
	}
}
