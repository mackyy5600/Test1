<html>
<title>เว็บไซต์สำหรับคัดกรองยา</title>

<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$session_id = session_id();
require_once "function.php";
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

?>

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
    <br><br><br>
    <div class="container my-5 px-0 1">
        <!--Section: Content-->
        <section class="p-4 my-md-5 text-center">
            <div class="col-md-6 mx-auto">
                <!-- Material form login -->
                <div class="card">
                    <!--Card content-->
                    <div class="card-body">
                        <!-- Form -->
                        <!-- <form class="text-center" style="color: #757575;" action="insert_to_db.php" method="POST"> -->

                        <form class="text-center" style="color: #757575;" action="" method="POST">

                            <h2 class="font-weight-bold my-4 pb-3 text-center text-dark">เพิ่มข้อมูลยาใหม่ </h2>
                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="รหัสบาร์โค้ด" name="barcode" autocomplete=off required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="ชื่อยา" name="name" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="ชื่อผู้ผลิต" name="manufacturer" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="เลขทะเบียนยา/เลขที่ใบรับจดแจ้ง" name="reg" required>
                            </div>

                            <div class="form-group">
                                <select class="custom-select custom-select-md mb-6" name="compound" required>
                                    <option value="">สารประกอบยา</option>
                                    <?php
                                    $sql = "SELECT * FROM `drug_compound` ORDER BY `drug_compound`.`compound_id` ASC";
                                    $q = $pdo->prepare($sql);
                                    $q->execute(array());
                                    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $row['compound_id'] . '">' . $row['compound_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="custom-select custom-select-md mb-6" name="category" required>
                                    <option value="">ประเภทยา</option>
                                    <option value="ยาสามัญประจำบ้าน">ยาสามัญประจำบ้าน</option>
                                    <option value="ยาอันตราย">ยาอันตราย</option>
                                    <option value="ยาควบคุมพิเศษ">ยาควบคุมพิเศษ</option>
                                    <option value="ยาแผนโบราณ">ยาแผนโบราณ</option>
                                    <option value="ยาปฏิชีวนะ">ยาปฏิชีวนะ</option>
                                    <option value="ผลิตภัณฑ์บำรุงผิว">ผลิตภัณฑ์บำรุงผิว</option>
                                    <option value="ผลิตภัณฑ์เสริมอาหาร">ผลิตภัณฑ์เสริมอาหาร</option>
                                    <option value="อุปกรณ์ทางการแพทย์">อุปกรณ์ทางการแพทย์</option>
                                    <option value="อื่นๆ">อื่นๆ</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="custom-select custom-select-md mb-6" name="document" required>
                                    <option value="">สารประกอบยา</option>
                                    <?php
                                    $sql = "SELECT * FROM `drug_document` ORDER BY `drug_document`.`document_id` ASC";
                                    $q = $pdo->prepare($sql);
                                    $q->execute(array());
                                    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $row['document_id'] . '">' . $row['document_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="custom-select custom-select-md mb-6" name="unit_input" required>
                                    <option value="">หน่วยรับเข้า</option>
                                    <option value="กล่อง">กล่อง</option>
                                    <option value="ลัง">ลัง</option>
                                    <option value="โหล">โหล</option>
                                    <option value="แพ็ค">แพ็ค</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="custom-select custom-select-md mb-6" name="unit_price" required>
                                    <option value="">หน่วยขาย</option>
                                    <option value="กระปุก">กระปุก</option>
                                    <option value="หลอด">หลอด</option>
                                    <option value="ขวด">ขวด</option>
                                    <option value="แผง">แผง</option>
                                    <option value="แท่ง">แท่ง</option>
                                    <option value="เม็ด">เม็ด</option>
                                    <option value="ชิ้น">ชิ้น</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="จำนวนย่อยต่อหน่วยรับ" name="unit_input_amount" required>
                            </div>

                            <!-- <div class="form-group">
                                <input type="text" class="form-control file" placeholder="ราคาขายต่อหน่วย" name="price" required>
                            </div> -->

                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="สรรพคุณยา" name="properties" required>
                            </div>

                            <div class="form-group">
                                <input type="file" class="form-control file" placeholder="รูป" name="pic" required>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-append">
                                            <input class="form-control" type="hidden" name="" value="<?= $stock_price ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <div class="input-group-append">
                                            <input class="form-control" type="hidden" name="" value="<?= $stock_input_amount ?>" readonly>
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
        </section>
    </div>

    <?php
    if (isset($_POST["SubmitInsert"])) {
        //นำเข้าไฟล์ การเชื่อมต่อฐานข้อมูล
        include_once("consqli.php");

        $barcode = $_POST["barcode"];
        $name = $_POST["name"];
        $manufacturer = $_POST["manufacturer"];
        $reg = $_POST["reg"];
        $compound = $_POST["compound"];
        $category = $_POST["category"];
        $document = $_POST["document"];
        $unit_input = $_POST["unit_input"];
        $unit_price = $_POST["unit_price"];
        $unit_input_amount = $_POST["unit_input_amount"];
        // $price = $_POST["price"];
        $properties = $_POST["properties"];
        $pic = $_POST["pic"];

        //SQL บันทึกข้อมูลลงฐานข้อมูล
        $sql = "INSERT INTO drug (drug_barcode_id, drug_name, drug_manufacturer, drug_reg_no, drug_compound_id, drug_category, drug_document_id, drug_unit_input, drug_unit_price, 
                drug_unit_input_amount, drug_properties, drug_picture)
                VALUES('$barcode', '$name', '$manufacturer', '$reg', '$compound', '$category', '$document', '$unit_input', '$unit_price', '$unit_input_amount' , '$properties', '$pic')";
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