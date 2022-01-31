<?php
ob_start();
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$session_id = session_id();
include_once 'consqli.php';
//connect
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$admin_login = null;
if (isset($_SESSION["admin_login"])) {
    // login pass
    $admin_login = $_SESSION["admin_login"];
    $sql = "SELECT * FROM `member` WHERE `member_id` = ?;";
    $q = $pdo->prepare($sql);
    $q->execute(array($admin_login));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $member_user = $data['member_user'];
}

$Id_drug = $_POST['Id_drug'];
$qty = $_POST['qty'];

$sql = "INSERT INTO `drug_reference` (`drug_reference_datetime`,`session_id`) VALUES (CURRENT_TIMESTAMP(),?) ON DUPLICATE KEY UPDATE `drug_reference_id`=`drug_reference_id`;";
$q = $pdo->prepare($sql);
$q->execute(array($session_id));

$sql2 = "SELECT `drug_reference_id` FROM `drug_reference` WHERE `session_id`=?;";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($session_id));

$row = $q2->fetch(PDO::FETCH_ASSOC);
$drug_reference_id = $row['drug_reference_id'];
$sql3 = "INSERT INTO `drug_cart` ( `drug_id`, `qty`, `drug_cart_lot_id`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE qty = qty +1;";
$q3 = $pdo->prepare($sql3);
$q3->execute(array($Id_drug, $qty, $drug_reference_id));

Database::disconnect();
header("Location: 3.search.php");
