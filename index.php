<?php
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
include("bootstrap.php");
error_reporting(E_ALL ^ E_NOTICE);

?>

<html>

<head>
    <title>เว็บไซต์สำหรับคัดกรองยา</title>
</head>

<style>
    ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .heading.heading-icon {
        display: block;
    }

    .padding-lg {
        display: block;
        padding-top: 60px;
        padding-bottom: 60px;
    }

    .practice-area.padding-lg {
        padding-bottom: 55px;
        padding-top: 55px;
    }

    .practice-area .inner {
        border: 1px solid #999999;
        text-align: center;
        margin-bottom: 28px;
        padding: 40px 25px;
    }

    .our-webcoderskull .cnt-block:hover {
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        border: 0;
    }

    .practice-area .inner h3 {
        color: #3c3c3c;
        font-size: 24px;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        padding: 10px 0;
    }

    .practice-area .inner p {
        font-size: 14px;
        line-height: 22px;
        font-weight: 400;
    }

    .practice-area .inner img {
        display: inline-block;
    }

    .our-webcoderskull .cnt-block {
        float: left;
        width: 100%;
        background: #fff;
        padding: 30px 20px;
        text-align: center;
        border: 2px solid #d5d5d5;
        margin: 0 0 28px;
    }

    .our-webcoderskull .cnt-block figure {
        width: 148px;
        height: 148px;
        border-radius: 100%;
        display: inline-block;
        margin-bottom: 15px;
    }

    .our-webcoderskull .cnt-block img {
        width: 148px;
        height: 148px;
        border-radius: 100%;
    }

    .our-webcoderskull .cnt-block h3 {
        color: #2a2a2a;
        font-size: 40px;
        font-weight: 500;
        padding: 6px 0;
        text-transform: uppercase;
        font-family: 'Sarabun', sans-serif;
    }

    .our-webcoderskull .cnt-block h3 a {
        text-decoration: none;
        color: #2a2a2a;
    }

    .our-webcoderskull .cnt-block h3 a:hover {
        color: #337ab7;
    }

    .our-webcoderskull .cnt-block p {
        color: #2a2a2a;
        font-size: 13px;
        line-height: 20px;
        font-weight: 400;
    }

    .our-webcoderskull .cnt-block .follow-us {
        margin: 20px 0 0;
    }

    .our-webcoderskull .cnt-block .follow-us li {
        display: inline-block;
        width: auto;
        margin: 0 5px;
    }

    .our-webcoderskull .cnt-block .follow-us li .fa {
        font-size: 24px;
        color: #767676;
    }

    .our-webcoderskull .cnt-block .follow-us li .fa:hover {
        color: #025a8e;
    }

    body {
        background-image: url('images/bgg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-family: 'Numans', sans-serif;
    }

    .row.heading h2 {
        color: #2a2a2a;
        font-size: 52.52px;
        line-height: 95px;
        font-weight: 800;
        margin: 0 0 40px;
        padding-bottom: 20px;
        text-transform: uppercase;
        font-family: 'Sarabun', sans-serif;
        text-align: center;
    }
</style>

<body>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <section class="our-webcoderskull padding-lg"><br><br>
        <div class="container">
            <div class="row heading heading-icon">
                <h2>ระบบคัดกรองยา</h2>
            </div><br><br>
            <ul class="row">
                <li class="col-12 col-md-6 col-lg-4">
                    <div class="cnt-block equal-hight" style="height: 349px; cursor: pointer;" onclick="window.location='2.add_detail_drug.php'">
                        <a href="2.add_detail_drug.php">
                            <figure><img src="images/add.png" class="img-responsive" alt="">
                        </a></figure>
                        <h3 style="margin-top: 35px;"><a href="2.add_detail_drug.php">เพิ่มข้อมูลยา</a></h3>
                    </div>
                </li>
                <li class="col-12 col-md-6 col-lg-4">
                    <div class="cnt-block equal-hight" style="height: 349px; cursor: pointer;" onclick="window.location='3.search.php'">
                        <a href="3.search.php">
                            <figure><img src="images/search.png" class="img-responsive" alt="">
                        </a></figure>
                        <h3 style="margin-top: 35px;"><a href="3.search.php">ค้นหายา
                    </div>
                </li>
                <li class="col-12 col-md-6 col-lg-4">
                    <div class="cnt-block equal-hight" style="height: 349px; cursor: pointer;" onclick="window.location='4.stock.php'">
                        <a href="4.stock.php">
                            <figure><img src="images/db.png" class="img-responsive" alt=""><br>
                        </a></figure>
                        <h3 style="margin-top: 35px;"><a href="4.stock.php">จัดการคลังสินค้า </a></h3>
                        <p></p>
                    </div>
                </li>
            </ul>
        </div>

    </section>
</body>


</html>