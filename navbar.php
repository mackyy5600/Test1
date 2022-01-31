<html>
<title> เว็บไซต์คัดกรองยา </title>

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
?>

<html>

<head>
    <title>Document </title>
</head>
<style>
    @import url(http://fonts.googleapis.com/css?family=Raleway);

    body {
        font-family: 'Sarabun', sans-serif !important;
    }

    a {
        color: #000000 !important;
    }

    .cart-items-count {
        position: relative;
        display: flex;
        text-align: center;
        justify-content: center;
        top: -55px;
        padding: 0px;
        margin: 0px;
    }

    .navigation-bar {
        padding: 5px 10px;
    }

    .notification-counter {
        position: absolute;
        left: 8px;
        background-color: rgba(212, 19, 13, 1);
        color: #fff;
        border-radius: 50px;
        padding: 5px 3px;
        margin: 25px 10px;
    }

    /* แก้ไข layout ของ navbar*/

    /* 1. แก้ไขความห่างของแต่ละ column */
    .nav-item {
        font-family: 'Sarabun', sans-serif;
        margin: 0 auto;
        padding: 1em 1.0em;
        text-align: center;
    }

    /* 2. เลื่อนทั้งแถว row navbar และขอบของ navbar แก้ตรง padding*/
    .nav-item a {
        color: #FFF;
        text-decoration: none;
        font: 22px Century Gothic;
        margin: 0px 0px;
        padding: 15px 10px;
        font-weight: 900;
        position: relative;
        z-index: 0;
        font-family: 'Sarabun', sans-serif
    }

    .topBotomBordersOut a:before,
    .topBotomBordersOut a:after {
        position: absolute;
        left: 0px;
        width: 100%;
        height: 2px;
        background: #000000;
        content: "";
        opacity: 0;
        -webkit-transition: all 0.1s;
        transition: all 0.2s;
    }

    .topBotomBordersOut a:before {
        top: 0px;
        transform: translateY(5px);
    }

    .topBotomBordersOut a:after {
        bottom: 0px;
        transform: translateY(-10px);
    }

    .topBotomBordersOut a:hover:before,
    .topBotomBordersOut a:hover:after {
        opacity: 1;
        transform: translateY(0px);
    }

    p {
        font-size: 18px;
        font-family: 'Sarabun', sans-serif
    }
</style>

<?php
$sql = "SELECT * FROM `drug_reference` WHERE `session_id` LIKE ?;";
$q = $pdo->prepare($sql);
$q->execute(array($session_id));
$row = $q->fetch(PDO::FETCH_ASSOC);
$lot = $row['drug_reference_id'];

$sql = "SELECT COUNT(*) AS `total` FROM `drug_cart` WHERE `drug_cart_lot_id` = ?";
$q = $pdo->prepare($sql);
$q->execute(array($lot));
$data = $q->fetch(PDO::FETCH_ASSOC);
$total = $data['total'];
?>

<body>
    <nav class="menum navbar navbar-light navbar-expand-md justify-content-center">
        <div class="container">
            <div class="navbar-collapse collapse justify-content-between align-items-center w-100" id="collapsingNavbar2">
                <ul class="topBotomBordersOut navbar-nav mx-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">หน้าแรก</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="3.search.php">ค้นหายา</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">จัดการคลังสินค้า</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="4.stock.php">คลังสินค้า</a>
                            <!-- <a class="dropdown-item" href="1.add_stock_drug.php">เพิ่มยาเข้าสต๊อก</a> -->
                            <a class="dropdown-item" href="2.add_detail_drug.php">เพิ่มข้อมูลยาใหม่</a>
                            <a class="dropdown-item" href="add_document.php">เพิ่มข้อมูลเอกสารยา</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="5.report.php">สรุปยอดขาย</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="payment.php">ประวัติการขาย</a>
                    </li>
                    <li class="nav-item">
                        <a href="cart.php"><img src="images/cart2.png" class="navigation-bar" alt=""></a> <span class="cart-items-count">
                            <span class="notification-counter"><?php echo $total; ?></span></span>
                        </a>
                    </li>
                </ul><br>


</body>
<?php

if (!isset($_SESSION["user_login"]) || $_SESSION["user_login"] == False) {
    echo '<a class="btn btn-success" href="http://localhost/pharma/login.php"><i class="fas fa-user-circle"></i> Login</a>';
} else {
    echo '<a class="btn btn-danger" href="http://localhost/pharma/login.php"><i class="fas fa-user-circle"></i> Admin:Logout</a>';
}
?>
</nav>

</html>