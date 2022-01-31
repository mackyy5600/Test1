<html>
<title> เว็บไซต์คัดกรองยา </title>
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

?>

<head>
    <meta charset="utf-8">
    <!-- Font ตรง Topic-->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="https://scontent.fkkc3-1.fna.fbcdn.net/v/t1.0-9/119980752_337785307574954_1757152202764221432_o.jpg?_nc_cat=105&ccb=2&_nc_sid=09cbfe&_nc_eui2=AeEdQ3uuMUpSNsKpHfjvpUDro1XX0a4IIyujVdfRrggjKx0oaTlnEEJRQqIYyg0KJMUxDMwjlPd-dN2hT7EGYqeo&_nc_ohc=0bT4uczorNcAX96yl_4&_nc_ht=scontent.fkkc3-1.fna&oh=6b8d05997d7e1dd2078a3062bc4a3886&oe=5FBB4911" />
    <!-- การลิ้ง css bootstrap เเบบ cdn -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- การลิ้ง javascript ของ bootstrap เเบบ cdn -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- การลิ้ง sweetalert2 เเบบ cdn  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<style>
    body {
        background-image: url('images/bgg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-family: 'Numans', sans-serif;
    }

    h2 {
        font-family: 'Sarabun', sans-serif;
        font-size: 35px;
    }

    button {
        font-family: 'Sarabun', sans-serif;
    }
</style>

<body>
    <div class="container my-5 px-0 1">
        <!--Section: Content-->
        <section class="p-4 my-md-5 text-center">

            <div class="row">
                <div class="col-md-6 mx-auto">
                    <!-- Material form login -->
                    <div class="card">
                        <!--Card content-->
                        <div class="card-body">
                            <!-- Form -->
                            <!-- <form class="text-center" style="color: #757575;" action="insert_to_db.php" method="POST"> -->

                            <form class="text-center" style="color: #757575;" action="" method="POST">

                                <h2 class="font-weight-bold my-4 pb-3 text-center text-dark">เพิ่มข้อมูลเอกสารยา </h2>

                                <!-- ไม่แน่ใจว่าต้องลบไหม -->
                                <!-- <div class="form-group">
                                    <input type="text" class="form-control" placeholder="รหัสสารประกอบยา" name="barcode" required>
                                </div> -->

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="ชื่อสารประกอบ" name="name_document" required>
                                </div>

                                <!-- <div class="form-group">
                                    <select class="custom-select custom-select-md mb-6" name="compound" required>
                                        <option value="">ฉลากยาเสริม</option>
                                        <?php
                                        $sql = "SELECT * FROM `drug_compound` ORDER BY `drug_compound`.`compound_id` ASC";
                                        $q = $pdo->prepare($sql);
                                        $q->execute(array());
                                        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row['compound_id'] . '">' . $row['compound_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div> -->

                                <div class="form-group">
                                    <select class="custom-select custom-select-md mb-6" name="type" required>
                                        <option value="">ชนิดการบริโภคยา</option>
                                        <?php
                                        $sql = "SELECT * FROM `drug_type` ORDER BY `drug_type`.`type_id` ASC";
                                        $q = $pdo->prepare($sql);
                                        $q->execute(array());
                                        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row['type_id'] . '">' . $row['type_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- <div class="form-group">
                                    <select class="custom-select custom-select-md mb-6" name="category" required>
                                        <option value="">ประเภทยา</option>
                                        <?php
                                        $sql = "SELECT * FROM `drug_category` ORDER BY `drug_category`.`category_id` ASC";
                                        $q = $pdo->prepare($sql);
                                        $q->execute(array());
                                        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div> -->

                                <div class="container">
                                    <div class="row justify-content-left">
                                        <div class="col-md-7">
                                            <button type="submit" name="SubmitInsert" id="save_drug" class="btn btn-success btn-lg" value="save">ยืนยัน</button>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="4.stock.php"><button type="button" class="btn btn-danger btn-lg">ย้อนกลับ</button></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Form -->

                        </div>

                    </div>
                    <!-- Material form login -->
                </div>
            </div>
            <!-- จบ คลาส container -->
        </section>
    </div>

    <?php

    if (isset($_POST["SubmitInsert"])) {
        //นำเข้าไฟล์ การเชื่อมต่อฐานข้อมูล
        include_once("consqli.php");

        $name_document = $_POST["name_document"];
        // $compound = $_POST["compound"];
        $type = $_POST["type"];
        $category = $_POST["category"];

        //คำสั่ง SQL บันทึกข้อมูลลงฐานข้อมูล
        // $sql = "INSERT INTO drug (barcode, ean13, name, name_main, type, category, use, lot, reg, size, unit, manufacturer, pic) 
        // VALUES (NULL, '{$_POST["barcode"]}', '{$_POST["ean13"]}', '{$_POST["name"]}', '{$_POST["name_main"]}', '{$_POST["type"]}', '{$_POST["category"]}', '{$_POST["use"]}'
        // , '{$_POST["lot"]}', '{$_POST["reg"]}', '{$_POST["size"]}', '{$_POST["unit"]}', '{$_POST["manufacturer"]}', '{$_POST["pic"]}');";

        $sql = "INSERT INTO drug_document (document_name, document_type_id, document_category_id)
                VALUES('$name_document', '$type', '$category')";
        // $result = mysqli_query($conn, $sql) or die("Error in query: $sql " . mysqli_error());

        if (mysqli_query($conn, $sql)) {
            echo
            "<script> 
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            }).then(()=> location = '4.stock.php')
        </script>";
        } else {
            echo
            "<script> 
            Swal.fire({
                icon: 'error',
                title: 'บันทึกข้อมูลไม่สำเร็จ', 
                text: 'โปรดตรวจสอบความถูกต้องของข้อมูล!',
            }) 
        </script>";
        }
        mysqli_close($conn);
    }

    ?>
</body>

</html>