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


if (!empty($_GET)) {
    $id = $_GET['id'];

    // $sql = "SELECT * FROM `adidas_payment`,`adidas_orders` WHERE `adidas_payment`.`adidas_reference_id` = `adidas_orders`.`adidas_reference_id` AND `adidas_payment`.`adidas_reference_id` = ?;";
    $sql = "SELECT * FROM `drug_orders` WHERE `drug_reference_id` = `drug_reference_id` AND `drug_reference_id` = ?;";
    // $sql = "SELECT * FROM `drug_orders` WHERE `drug_reference_id` = `drug_reference_id` AND `drug_reference_id` = ?;";

    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    // $order_date = $data['order_date'];
    // $time_income = $data['time_income'];
    // $price_income = $data['price_income'];
}

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
</style>

<body>
    <!-- ใบเสร็จ -->

    <br><br><br><br><br><br><br>

    <?php

    $sql = "SELECT * FROM `member` WHERE `member_id`=?";
    $q = $pdo->prepare($sql);
    $q->execute(array($user_login));
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $id_m = $row['member_id'];
    $name = $row['name'];
    $last = $row['lastname'];
    ?>
    <h4 style="text-align: letf; margin-left: 21%;"><b><u>หมายเลขใบเสร็จ: <?php echo "$id" ?></u></b></h4>
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
                                    <strong>ที่อยู่: </strong>Silpakorn University
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
                                    <strong>พนักงานขาย: </strong><?php echo "pharma" . ' ' . "test"; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 text-center">
                            <strong>หมายเลขใบเสร็จ: </strong><?php echo "$id" ?>
                        </div>

                        <!-- <div class="col-md-10 text-center">
                            <strong>Date :</strong>
                            <?php echo $order_date; ?>
                        </div> -->
                    </div>
                </div>

                <br><br><br><br><br><br>


                <div class="row">
                    <table class="table table-white table-striped" border="2" align="center">
                        <thead>
                            <tr>
                                <th style="text-align:center">#</th>
                                <th class="text-center">สินค้า</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-center">ราคา</th>
                                <th class="text-center">รวม</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $i = 0;
                            // $sql2 = "SELECT * FROM `drug_cart`,`drug` WHERE `drug_cart`.`drug_id` = `drug`.`drug_id` AND `drug_cart_lot_id` = ?;";

                            // $sql2 = "SELECT * FROM `drug_orders_detail`,`drug` WHERE `drug_orders_detail`.`drug_id` = `drug`.`drug_id` AND `orders_id` = ?;";

                            $sql2 = "SELECT * FROM `drug_orders_detail`,`drug` WHERE `drug_orders_detail`.`orders_drug_id` = `drug`.`drug_id` AND drug_orders_detail.orders_id = '$_REQUEST[id]'";

                            $q2 = $pdo->prepare($sql2);
                            $q2->execute(array($id));
                            while ($row2 = $q2->fetch(PDO::FETCH_ASSOC)) {
                                $i++;
                                echo '<tr>';
                                echo '<td style="text-align:center">' . $i . '</td>';

                                echo '<td class="col-md-9">' . '<input name="product_name" type="hidden" value="' . $row2['drug_name'] . '">' . $row2['drug_name'] . '</td>';

                                echo '<td class="col-md-1 text-center">' . '<input type="hidden" name="qty" value="' . $row2['orders_qty'] . '" required="">' . $row2['orders_qty'] . '</td>';
                                echo '<td class="col-md-1 text-center">' . '<input name="price" type="hidden" value="' . $row2['drug_price'] . '">' . $row2['drug_price'] . '</td>';
                                $a =  $row2['orders_qty'];
                                $b =  $row2['drug_price'];
                                $total = $a *= $b;

                                echo '<td class="col-md-1 text-center">' . '<input name="qty_price" type="hidden" value="' . $row2['drug_price'] . '">' . "number_format"($total) . " บาท" . '</td>';

                                echo '</tr>';

                                $total_price += $total;
                            }
                            echo '<tr>';

                            echo '<tr>';
                            // echo '<td><strong>รวม: </strong></td>';
                            echo '<td style="text-align:center"><strong>Vat: </strong><br><br><br>
                                      <strong>รวม: </strong><br><br>
                                 </td>';
                            echo '<td></td>';
                            echo '<td></td>';

                            echo '<td class="text-right">';
                            echo '<p>';
                            echo '';
                            echo '</p>';
                            echo '<p>';

                            echo '</p></td>';
                            echo '<td class="text-center">';

                            $tax = ($total_price * 7) / 100;
                            echo "{$tax}" . " บาท";
                            echo '</p>';
                            echo number_format($total_price) . " บาท";
                            echo '</tr>';


                            echo '<td class="text-center"><h6><strong>รวมทั้งหมด: <strong></h6></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td></td>';
                            echo '<td class="text-center text-danger"><h4>';
                            $sum = ($tax + $total_price);
                            echo number_format($sum) . " บาท";
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
        <a href="payment.php" role="button"><button type="button" class="btn btn-danger btn-lg">ปิด</button></a>
    </div>
    <script>
        $(document).foundation();

        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>

</body>

</html>
<?php Database::disconnect(); ?>