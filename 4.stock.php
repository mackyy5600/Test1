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
?>



<head>
</head>

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
</style>

<body>

    <div class="text-center">
        <div class="header">
            <div class="button-group"><br><br><br><br><br>
                <h1 style="text-align: center;">จัดการคลังสินค้า</h1><br>
                <!-- <a href="1.add_stock_drug.php" style="font-family: 'Sarabun', sans-serif; color: #FFFFFF !important; margin-left:25px" class="btn btn-primary btn-lg">
                    <i class="fa fa-database"></i> เพิ่มยาเข้าสต๊อก
                </a> -->
            </div>
        </div>
    </div>


    <div class="container my-5">
        <!-- data table ใช้เเสดงข้อมูลเเละเเบ่งหน้าให้อัตโนมัติ -->
        <table id="example" class="table table-striped table-bordered table-hover table-responsive-sm" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th style="text-align: center;">ไอดีสินค้า</th>
                    <th style="text-align: center;">บาร์โค้ด</th>
                    <th style="text-align: center;" width="20%">รูป</th>
                    <th style="text-align: center;" width="20%">ชื่อสินค้า</th>
                    <th style="text-align: center;" width="12%">ราคา</th>
                    <th style="text-align: center;" width="15%">จำนวนคงเหลือ</th>
                    <th style="text-align: center;" width="20%">ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // $sql = "SELECT * FROM drug, drug_stock";

                $sql = "SELECT * FROM drug";

                // $sql = "SELECT drug.drug_id, drug.drug_barcode_id, drug.drug_picture, drug.drug_name, drug_stock.stock_price, drug_stock.stock_input_amount, drug_unit_price
                //         FROM drug
                //         INNER JOIN drug_stock
                //         ON drug.drug_id=drug_stock.stock_id";

                $result = mysqli_query($conn, $sql);
                while ($item = mysqli_fetch_assoc($result)) { ?>

                    <!-- เเสดงข้อมูลจากฐานข้อมูล -->

                    <tr>
                        <td style="background-color:#F1EEEE" align="center" class="" width="15%"><?php echo $item["drug_id"]; ?></td>
                        <td style="background-color:#F1EEEE" align="center" class="" width="15%"><?php echo $item["drug_barcode_id"]; ?></td>
                        <td style="background-color:#F1EEEE" align="center"><?php echo '<img class="thumbnail" src="pic_drug/' . $item['drug_picture'] . '" style="height: 150px;width: 150px;">'; ?></td>
                        <td style="background-color:#F1EEEE" align="center"><?php echo $item["drug_name"]; ?></td>
                        <td style="background-color:#F1EEEE" align="center"><?php echo number_format($item["drug_price"]); ?> บาท/<?php echo $item["drug_unit_price"]; ?></td>
                        <td style="background-color:#F1EEEE" align="center"><?php echo number_format($item["drug_amount"]); ?> <?php echo $item["drug_unit_price"]; ?></td>
                        <td style="background-color:#F1EEEE" align="center" class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a class="btn btn-primary btn-lg" href="1.add_stock_drug.php?id=<?php echo $item["drug_id"]; ?>" style="color:white !important;"><i class="fa fa-plus"> </i> เพิ่มสต๊อก</a>
                                <a class="btn btn-warning btn-lg" href="stock_edit.php?id=<?php echo $item["drug_id"]; ?>" style="color:black !important;"><i class="fa fa-edit"> </i> แก้ไข</a>
                                <!-- <a class="btn btn-danger" href="index.php?deleteR=req&p_id=<?php echo $item["p_id"]; ?>">
                                    <i class="fas fa-trash"> </i>
                                </a> -->
                                <a class="btn btn-danger btn-lg" href="4.stock.php?deleteR=req&id=<?php echo $item["drug_id"]; ?>" style="color: #FFFFFF !important;"><i class="fa fa-trash"> </i> ลบ</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php

    if (isset($_GET["deleteR"])) {
        echo
        "<script> 
                Swal.fire({
                    icon: 'warning',
                    title: 'ยืนยันการลบข้อมูล?',
                    text: 'ท่านเเน่ใจว่า ท่าต้องการลบข้อมูล!',
                    showCancelButton: true,
                    confirmButtonColor: '#24CB4A',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ไม่!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location = 'stock_delete.php?id={$_GET["id"]}'
                    }else{
                        location = '4.stock.php'
                    }
                }); 
        </script>";
    }
    ?>

    <!-- DataTable แบบภาษาไทย -->
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#example').dataTable({
                "oLanguage": {
                    "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด ต่อหน้า",
                    "sZeroRecords": "ไม่เจอข้อมูลที่ค้นหา",
                    "sInfo": "แสดง _START_ ถึง _END_ ของ _TOTAL_ เร็คคอร์ด",
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                    "sInfoFiltered": "(จากเร็คคอร์ดทั้งหมด _MAX_ เร็คคอร์ด)",
                    "sSearch": "ค้นหา :",
                    "aaSorting": [
                        [0, 'desc']
                    ],
                    "oPaginate": {
                        "sFirst": "หน้าแรก",
                        "sPrevious": "ก่อนหน้า",
                        "sNext": "ถัดไป",
                        "sLast": "หน้าสุดท้าย"
                    },
                }
            });
        });
    </script>

</body>

</html>
<?php Database::disconnect(); ?>