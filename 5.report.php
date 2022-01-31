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

//ตั้งค่าการเชื่อมต่อฐานข้อมูล
$database_host             = 'localhost';
$database_username         = 'root';
$database_password         = '';
$database_name             = 'pharma';

$mysqli = new mysqli($database_host, $database_username, $database_password, $database_name);
//กำหนด charset ให้เป็น utf8 เพื่อรองรับภาษาไทย
$mysqli->set_charset("utf8");

//กรณีมี Error เกิดขึ้น
if ($mysqli->connect_error) {
    die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
//เรียกข้อมูลจาก ตาราง chart 
$get_data = $mysqli->query("SELECT * FROM chart");

while ($data = $get_data->fetch_assoc()) {

    $result[] = $data;
}
?>


<head>
</head>

<style>
    h1 {
        font-family: 'Sarabun', sans-serif;
        font-size: 50px;
        font-weight: bold;
    }
</style>
<br><br><br><br><br>
<h1 style="text-align: center;">สรุปยอดขาย</h1>

<body>

    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

    <table class="table" id="datatable">

        <thead>
            <tr>
                <th></th>
                <th>ยอดขาย/เดือน</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $result_tb) {
                echo "<tr>";
                echo "<td>" . $result_tb['month'] . "</td>";
                echo "<td>" . $result_tb['sales'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

    <script>
        $(function() {

            $('#container').highcharts({
                data: {
                    //กำหนดให้ ตรงกับ id ของ table ที่จะแสดงข้อมูล
                    table: 'datatable'
                },
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'ยอดขายยาประจำเดือน'
                },
                yAxis: {
                    allowDecimals: false,
                    title: {
                        text: 'ยอดขายต่อเดือน/บาท'
                    }
                },

                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y; + ' ' + this.point.name.toLowerCase();
                    }
                }
            });
        });
    </script>
    <form method="post" action="export_excel.php">
        <div class="col-md-12 text-center">
            <!-- <button href="export_excel.php" class="btn btn-info btn-lg" style='font-size:24px'>Excel <i class='far fa-file-excel'></i></button> -->
        </div>
    </form>
</body>

</html>