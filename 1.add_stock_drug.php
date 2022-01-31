<html>
<title>เว็บไซต์สำหรับคัดกรองยา</title>

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

if (!empty($_GET)) {
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM `drug` WHERE `drug_id` = ?;";
    $q2 = $pdo->prepare($sql2);
    $q2->execute(array($id));
    $data2 = $q2->fetch(PDO::FETCH_ASSOC);
    $drug_name = $data2['drug_name'];
    $drug_price = $data2['drug_price'];
    $drug_picture = $data2['drug_picture'];
    $drug_document = $data2['drug_document'];
    $drug_unit_input = $data2['drug_unit_input'];
    $drug_unit_price = $data2['drug_unit_price'];
    $drug_unit_input_amount = $data2['drug_unit_input_amount'];
}

include("bootstrap.php");
include("navbar.php");

?>

<style>
    body {
        background-image: url('images/bgg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
        font-family: 'Numans', sans-serif;
    }

    h1 {
        font-family: 'Sarabun', sans-serif;
        font-size: 50px;
        font-weight: bold;
    }

    p {
        font-weight: bold !important;
    }
</style>

<body>
    <!-- <form action="insert_to_db.php" method="post"> -->
    <br><br><br>
    <div class="container my-5 px-0 1 ">
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
                                <input type="hidden" name="item_id" value="<?= $id; ?>">
                                <h2 class="font-weight-bold my-4 pb-3 text-center text-dark">
                                    เพิ่มยาเข้าสต๊อก
                                </h2>

                                <div class="form-group">
                                    <input type="hidden" name="item_id" value="<?= $id; ?>">
                                    <input class="form-control" type="text" name="item_name" value="<?= $drug_name ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <input type="date" class="form-control" name="date_come" required>
                                        </div>
                                        <input class="form-control input-group-field" placeholder="วันที่รับเข้า" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="input" class="form-control" placeholder="ผู้จัดจำหน่าย" name="seller" required>
                                </div>

                                <div class="form-group">
                                    <input type="input" class="form-control" placeholder="ล็อตยานำเข้า" name="lot" required>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <input type="date" class="form-control" name="date_exp" required>
                                        </div>
                                        <input class="form-control input-group-field" placeholder="วันหมดอายุ" readonly>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <input style="width:310px;" type="input" class="form-control" placeholder="ราคารับเข้า/หน่วยรับเข้า" name="price_input" required>
                                            <div class="input-group-append">
                                                <input class="form-control" type="text" name="" value="บาท/<?= $drug_unit_input ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <!-- <input style="width:300px;" id="input1" type="input" class="form-control" placeholder="จำนวน/หน่วยรับเข้า" name="amount_input" onkeyup='nStr()' required> -->
                                            <input id='input1' name="amount_input" style="width:310px;" placeholder="จำนวน/หน่วยรับเข้า" class="form-control" type='text' onkeyup='nStr()'>
                                            <div class="input-group-append">
                                                <input class="form-control" type="text" name="" value="<?= $drug_unit_input ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <input style="width:300px;" type="input" class="form-control" placeholder="จำนวน(หน่วยย่อย)" name="amount_price" required>
                                            <div class="input-group-append">
                                                <input class="form-control" type="text" name="" value="<?= $drug_unit_price ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <input type='hidden' id='input2' type="" value="<?= $drug_unit_input_amount ?>" onkeyup='nStr()'>
                                            <!-- <input class="form-control" id="input2" type="hidden" name="" value="" onkeyup='nStr()' readonly> -->
                                            <!-- <input style="width:300px;" type="input" class="form-control" placeholder="" name="amount_price" value="" readonly required> -->
                                            <textarea type="text" name="amount_price" class="form-control" placeholder="จำนวน(หน่วยย่อย)" style="height: 37px; width:310px" id="show" type="" value="" readonly></textarea>
                                            <div class="input-group-append">
                                                <input class="form-control" type="text" name="" value="<?= $drug_unit_price ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <input style="width:310px;" type="input" class="form-control" placeholder="ราคาขาย" name="stock_price" required>
                                            <div class="input-group-append">
                                                <input class="form-control" type="text" name="" value="บาท" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

<script type='text/javascript'>
    function nStr() {
        var int1 = document.getElementById('input1').value;
        var int2 = document.getElementById('input2').value;
        var n1 = parseInt(int1);
        var n2 = parseInt(int2);
        var show = document.getElementById('show');

        if (isNaN(n1)) {
            document.getElementById("show").setAttribute("color", "red");
            show.innerHTML = "ERROR"
            if (int2.length > 0) {
                if (isNaN(int1)) {
                    document.getElementById("show").setAttribute("color", "red");
                    show.innerHTML = "ERROR"
                } else if (isNaN(int2)) {
                    document.getElementById("show").setAttribute("color", "red");
                    show.innerHTML = "ERROR"
                } else if (int1.length > 0) {
                    document.getElementById("show").setAttribute("color", "Blue");
                    show.innerHTML = n1 * n2;
                } else if (int2.length > 0) {
                    document.getElementById("show").setAttribute("color", "Blue");
                    show.innerHTML = n2;
                }
            }
        } else if (int1.length > 0) {
            if (isNaN(int2)) {
                document.getElementById("show").setAttribute("color", "red");
                show.innerHTML = "ERROR"
            } else if (int2.length > 0) {
                document.getElementById("show").setAttribute("color", "Blue");
                show.innerHTML = n1 * n2;
            } else if (int1.length > 0) {
                document.getElementById("show").setAttribute("color", "Blue");
                show.innerHTML = n1;
            }
        }
    }

    function addCommas(nStr) //ฟังชั่้นเพิ่ม คอมม่าในการแสดงเลข
    {
        nStr += '';
        x = nStr.split('.');
        show = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            show = show.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>

<?php

if (isset($_POST["SubmitInsert"])) {
    //นำเข้าไฟล์ การเชื่อมต่อฐานข้อมูล
    include_once("consqli.php");
    $date_come = $_POST["date_come"];
    $seller = $_POST["seller"];
    $lot = $_POST["lot"];
    $date_exp = $_POST["date_exp"];
    $price_input = $_POST["price_input"];
    $amount_input = $_POST["amount_input"];
    $amount_price = $_POST["amount_price"];
    $stock_price = $_POST["stock_price"];

    $sql = "INSERT INTO drug_stock (stock_date_come, stock_seller, stock_lot, stock_date_exp, stock_price_input
                        , stock_input, stock_input_amount, stock_price)
            VALUES('$date_come','$seller', '$lot', '$date_exp','$price_input', '$amount_input','$amount_price', '$stock_price')";
    // $result = mysqli_query($conn, $sql) or die("Error in query: $sql " . mysqli_error());

    $item_id = $_POST['item_id'];
    $conn->query("UPDATE `drug` SET `drug_amount`= `drug_amount` + $amount_price WHERE `drug_id` = '" . intval($item_id) . "'") or die($mysqli->error);

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql3 = "UPDATE `drug` SET `drug_price` = ?, `drug_edit` = NOW() WHERE `drug_id`= ?;";
    $q = $pdo->prepare($sql3);
    $q->execute(array($stock_price, $item_id));
    Database::disconnect();

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

</html>