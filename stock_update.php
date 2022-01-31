<?php
session_start();
include 'consqli.php';

$admin_login = null;
if (isset($_SESSION["admin_login"])) {
    // login pass
    $admin_login = $_SESSION["admin_login"];
}
//turn on php error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    // $item_use = $_POST['item_use'];
    $item_amount = $_POST['item_amount'];
    // $item_picture = $_POST['item_picture'];

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE `drug` SET `drug_name` = ?,`drug_price` = ?, `drug_amount` = ?,
    `drug_edit` = NOW() WHERE `drug_id`= ?;";
    $q = $pdo->prepare($sql);
    $q->execute(array($item_name, $item_price,  $item_amount, $item_id));


    $sql2 = "UPDATE `drug_stock` SET `stock_price` = ?,`stock_input_amount` = ?, `stock_edit` = NOW() WHERE `stock_id`= ?;";
    $q = $pdo->prepare($sql2);
    $q->execute(array($item_price, $item_amount,  $item_id));

    Database::disconnect();
    header('Location: 4.stock.php');
}
echo $response;
