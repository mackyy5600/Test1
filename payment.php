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
    $member_user = $data["admin_login"];
}
include("bootstrap.php");
include("navbar.php");
?>
<html>

<style>
    body {
        background-image: url('images/bgg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-family: 'Sarabun', sans-serif;
    }

    h1 {
        font-family: 'Sarabun', sans-serif;
        font-size: 50px;
        font-weight: bold;
    }
</style>

<body>
    <div class="container my-5">
        <br><br><br>
        <h1 style="text-align: center;">ประวัติการขาย</h1><br>
        <!-- data table ใช้เเสดงข้อมูลเเละเเบ่งหน้าให้อัตโนมัติ -->
        <table id="search" class="table table-striped table-bordered table-hover table-responsive-sm" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">หมายเลขใบเสร็จ</th>
                    <th class="text-center">วันที่</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <!-- <tbody style="text-align: center;">
                <?php
                $sql2 = "SELECT `drug_reference`.`drug_reference_id`,`drug_reference`.`drug_reference_datetime` FROM `drug_reference`,`drug_cart`,`drug`
                    WHERE `drug`.`drug_id` = `drug_cart`.`drug_id` 
                    AND `drug_reference`.`drug_reference_id` = `drug_cart`.`drug_cart_lot_id` 
                    AND `drug_reference_member_id` = ? GROUP BY `drug_reference_id` ASC";
                $q2 = $pdo->prepare($sql2);
                $q2->execute(array($admin_login));
                while ($row2 = $q2->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?= $row2['drug_reference_id']; ?></td>
                        <td><?= $row2['drug_reference_datetime']; ?></td>
                        <td><a href="payment_view.php?id=<?= $row2['drug_reference_id']; ?>" class="button"><i class="fa fa-eye" style="font-size:30px;color:red"></i></td>
                    </tr>
                <?php } ?>
            </tbody> -->

            <!-- <tbody style="text-align: center;">
                <?php
                $sql2 = "SELECT `drug_reference`.`drug_reference_id`,`drug_reference`.`drug_reference_datetime` FROM `drug_reference`,`drug_orders_detail`,`drug`
                    WHERE `drug`.`drug_id`
                    AND `drug_reference`.`drug_reference_id` 
                    AND `drug_reference_member_id` = ? GROUP BY `drug_reference_id` ASC";
                $q2 = $pdo->prepare($sql2);
                $q2->execute(array($admin_login));
                while ($row2 = $q2->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?= $row2['drug_reference_id']; ?></td>
                        <td><?= $row2['drug_reference_datetime']; ?></td>
                        <td><a href="payment_view.php?id=<?= $row2['drug_reference_id']; ?>" class="button"><i class="fa fa-eye" style="font-size:30px;color:red"></i></td>
                    </tr>
                <?php } ?> -->

            <tbody style="text-align: center;">
                <?php
                $sql2 = $conn->query("select * from drug_orders where member_id = '$_SESSION[admin_login]'") or die($mysqli->error);
                while ($row2 = $sql2->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row2['drug_orders_id']; ?></td>
                        <td><?= $row2['order_date']; ?></td>
                        <td><a href="payment_view.php?id=<?= $row2['drug_orders_id']; ?>" class="button"><i class="fa fa-eye" style="font-size:30px;color:red"></i></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- DataTable แบบภาษาไทย -->
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#search').dataTable({
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

<?php Database::disconnect(); ?>

</html>