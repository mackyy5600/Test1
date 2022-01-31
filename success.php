<html>
<title>เว็บไซต์สำหรับคัดกรองยา</title>

<?php
session_start();
ob_start();
error_reporting(E_ALL ^ E_NOTICE);
$session_id = session_id();

include 'consqli.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$admin_login = null;
if (isset($_SESSION["admin_login"])) {
    // login pass
    $admin_login = $_SESSION["admin_login"];

    $sql = "UPDATE `drug_reference` SET `drug_reference_member_id` = ? WHERE `drug_reference`.`session_id` = ?;";
    $q = $pdo->prepare($sql);
    $q->execute(array($admin_login, $session_id));

    $sql = "SELECT * FROM `drug_reference` WHERE `session_id`=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($session_id));
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $lot = $row['drug_reference_id'];
    // $date = $row['orders_date'];

    $orders_id = $_REQUEST['orders_id'];

    // $ref_id = mysqli_insert_id($conn);
    // $ref_id = $pdo->lastInsertId();
    // $sql = "UPDATE `drug_orders` set `drug_reference_id` = '$ref_id' WHERE `drug_orders_id` = '$_REQUEST[order_id]' ";
    // echo $sql;
    //  $sql = "INSERT INTO `drug_orders` (`drug_reference_id`, `orders_date`) VALUES (?, CURRENT_TIMESTAMP()) ON DUPLICATE KEY UPDATE `drug_reference_id` = `drug_reference_id`;";
    $q = $pdo->prepare($sql);
    $q->execute(array($lot));
} else {
    // no login
    header("Location: login.php");
}
include("bootstrap.php");
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
        font-family: 'Sarabun', sans-serif;
    }
</style>

<body>
    <?php
    $sql = "SELECT * FROM `member` WHERE `member_id` = ?;";
    $q = $pdo->prepare($sql);
    $q->execute(array($admin_login));
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $id_m = $row['admin_id'];
    $name = $row['name'];
    $last = $row['lastname'];
    $address = $row['address'];
    ?>
    <div style="margin-top:60px;" id="payment">
        <div class="container p-3 my-6 bg-light border text-black">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-12 ">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <div>
                                <div id="headsite">
                                    <strong>ร้าน: </strong>cutkrongya
                                </div>
                                <div id="address">
                                    <strong>ที่อยู่: </strong>Silpakorn University<?php echo $address; ?>
                                    <br>
                                    <strong title="Phone">โทรศัพท์:</strong> 012 345 678
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="user">
                        <div class="row text-center">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <div class="col-md-12">
                                    <strong>พนักงานขาย: </strong><?php echo  $name . ' ' . $last; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 text-center">
                            <strong>หมายเลขใบเสร็จ: </strong><?php echo $orders_id; ?>

                        </div>
                        <div class="col-md-10 text-center">
                            <strong>Date :</strong>
                            <?php
                            $date = date_create($date, timezone_open("Asia/Bangkok"));
                            echo date_format($date, "d/m/Y");
                            date_default_timezone_set("Asia/Bangkok");
                            echo "<b>" . " เวลา " . "</b>" . date("H:i:s");
                            ?>
                        </div>
                    </div>
                </div>

                <br><br><br><br><br><br><br>


                <div class="row">
                    <table class="table table-white table-striped" border="2" align="center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center" width="10px">สินค้า</th>
                                <th class="text-center" width="200px">จำนวน</th>
                                <th class="text-center" width="200px">ราคา/หน่วย</th>
                                <th class="text-center" width="200px">รวม</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql = "SELECT * FROM `drug_reference`,`drug_cart`,`drug`,`drug_orders` WHERE `drug_reference`.`drug_reference_id`=`drug_cart`.`drug_cart_lot_id` 
                                AND `drug`.`drug_id`=`drug_cart`.`drug_id`AND `drug_orders`.`drug_reference_id`= `drug_reference`.`drug_reference_id` 
                                AND `drug_reference_member_id` = ? AND `drug_reference`.`drug_reference_id`= ?;";
                            $q = $pdo->prepare($sql);
                            $q->execute(array($admin_login, $lot));
                            $total_price = 0;
                            $i = 0;
                            while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
                                $i++;
                                echo '<tr>';
                                echo '<td>' . $i . '</td>';
                                echo '<td class="col-md-9">' . '<input name="product_name" type="hidden" value="' . $row['drug_name'] . '">' . $row['drug_name'] . '</td>';
                                echo '<td class="col-md-1 text-center">' . '<input type="hidden" name="qty" value="' . $row['qty'] . '" required="">' . $row['qty'] . " " . $row['drug_unit_price'] . '</td>';
                                echo '<td class="col-md-1 text-center"width="200px">' . '<input name="price" type="hidden" value="' . $row['drug_price'] . '">' . $row['drug_price'] . '</td>';
                                $a =  $row['qty'];
                                $b =  $row['drug_price'];
                                $total = $a *= $b;

                                echo '<td class="col-md-1 text-center">' . '<input name="qty_price" type="hidden" value="' . $row['drug_price'] . '">' . $total . '</td>';
                                echo '</tr>';

                                $total_price += $total;
                            }
                            echo '<tr>';
                            echo '<td></td>';
                            echo '<td><strong>Vat: </strong><br><br><br>
                            <strong>รวม: </strong></td>';
                            echo '<td></td>';

                            echo '<td class="text-right">';

                            echo '<td class="text-center">';

                            $tax = ($total_price * 7) / 100;
                            echo "{$tax}" . " บาท";
                            echo '</p>';
                            $totaltax = $total_price - $tax;
                            echo "{$totaltax}" . " บาท";
                            echo '</tr>';
                            echo '<tr>';
                            // echo '<td><div class="text-center"> (<input style="width: 90%;">) <br> Total fee (text)</div></td>';

                            echo '<td class="text-center"></td>';
                            echo '<td><h6><strong>ราคาสุทธิ: <strong></h6></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td class="text-center text-danger"><h4>';
                            $sum = ($total_price);
                            echo "number_format"("{$sum}") . " บาท";
                            echo '</h4></td>';
                            echo '</tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <br>
        <button onclick="printContent('payment')" class="btn btn-success btn-lg">ปริ้นท์</button>
        <a class="btn btn-danger btn-lg " href="successfull.php" role="button">ปิด</a>
    </div>
    <script src="js/bootstrap.min.js"></script>

    <script>
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
        // ทำลาย session ใน table drug_cart ออก
        <?php $conn->query("delete from drug_cart where member_id = '$_SESSION[admin_login]'"); ?>
    </script>

</body>

</html>
<?php Database::disconnect(); ?>