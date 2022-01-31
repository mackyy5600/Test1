
<html>
<title>เว็บไซต์สำหรับคัดกรองยา</title>

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


include("bootstrap.php");
include("navbar.php");
$search = (isset($_GET['search']) ? $_GET['search'] : '');

?>

<style>
    body {
        background-image: url('images/bgg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-family: 'Numans', sans-serif;
    }

    h1 {
        font-family: 'Sarabun', sans-serif;
        font-size: 50px;
        font-weight: bold;
    }

    input {
        font-family: 'Sarabun', sans-serif;
        width: 100%;
        height: 69%;
    }

    p,
    span {
        font-size: 20px;
        font-weight: bold;
    }
</style>

<body>
    <br><br><br><br><br>
    <h1 style="text-align: center;">ค้นหายา</h1><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <label for="drug_name" class="col-form-label-responsive">
                    <br>
                    <p>ชื่อยาทางการค้า/ทางการแพทย์/
                        รหัสบาร์โค้ด/กลุ่มฉลากยาเสริม </p>
                </label>
            </div>

            <div class="col-md-3"><br>
                <form action="3.search.php" method="get" class="form-horizontal">
                    <input style="height: 50px;" type="text" name="search" class="form-control" placeholder="กรุณากรอกชื่อยา" autocomplete="on" required autofocus>

            </div>

            <div class="col-md-2"><br>
                <input style="height: 50px;" type="submit" class="btn btn-primary btn-lg" value="ค้นหา">
                <!-- <a href="3.search.php" class="btn btn-primary btn-lg"><i class="fa fa-arrow-left"></i> เลือกสินค้าเพิ่ม</a>
                    <input class="btn btn-success btn-lg" style="float: right" ; type="button" onclick="goUrl()" value="ยืนยัน"> -->
            </div>
            </form>
        </div><br>
    </div>

    <?php
    if ($search != '') {
        include('show_search.php');
    }
    ?>

</html>