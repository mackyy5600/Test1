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

/*กำหนด username password และ database name ของ mysql */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharma";

# เชื่อมต่อ Database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Error: " . $conn->connect_error);
}

echo "<table id='myTable'>";
echo "<tr>";
echo "<td>ID</td>";
echo "<td>บาร์โค้ด</td>";
echo "<td>ชื่อยา</td>";
echo "<td>ประเภทยา</td>";
echo "<td>เลขทะเบียนยา</td>";
echo "<td>จำนวนคงเหลือ</td>";
echo "<td>ผู้ผลิต</td>";
echo "</tr>";

/*นำข้อมูลจากตาราง food มาแสดง*/
$sql = "SELECT * FROM drug";
$result = $conn->query($sql);
foreach ($pdo->query($sql) as $row) {
    echo "<tr>";
    echo "<td>$row[drug_id]</td>";
    echo "<td>$row[drug_barcode_id]</td>";
    echo "<td>$row[drug_name]</td>";
    echo "<td>$row[drug_category]</td>";
    echo "<td>$row[drug_reg_no]</td>";
    echo "<td>$row[drug_amount]</td>";
    echo "<td>$row[drug_manufacturer]</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();

?>

<head>

</head>

<body></body>
<!-- เรียกใช้ javascript สำหรับ export ไฟล์ excel  -->
<script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>

<script>
    function ExcelReport() //function สำหรับสร้าง ไฟล์ excel จากตาราง
    {
        var sheet_name = "excel_sheet"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
        var elt = document.getElementById('myTable'); /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/

        /*------สร้างไฟล์ excel------*/
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: sheet_name
        });
        XLSX.writeFile(wb, 'report.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
    }
</script>
<?php
echo "<a href='#' id='download_link' onClick='javascript:ExcelReport();''>ดาวน์โหลด Excel</a>" . "&nbsp" . "&nbsp" . "&nbsp";
echo "<a href='index.php' id='download_link' >หน้าแรก</a>" . "&nbsp" . "&nbsp" . "&nbsp";
echo "<a href='5.report.php' id='download_link' >ย้อนกลับ</a>";
?>
<style type="text/css">
    table {
        border-collapse: collapse;
        height: 200px;
        width: 1300px;
    }


    th,
    td {
        border: 1px solid black;
    }
</style>

</html>