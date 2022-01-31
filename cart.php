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
// include("navbar.php");
?>

<head>

</head>

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

    h2,
    th,
    td,
    i,
    a {
        text-align: center;
        font-family: 'Sarabun', sans-serif;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .quantity {
        position: relative;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .quantity input {
        width: 45px;
        height: 42px;
        line-height: 1.65;
        float: left;
        display: block;
        padding: 0;
        margin: 0;
        padding-left: 20px;
        border: 1px solid #eee;
    }

    .quantity input:focus {
        outline: 0;
    }

    .quantity-nav {
        float: left;
        position: relative;
        height: 42px;
    }

    .quantity-button {
        position: relative;
        cursor: pointer;
        border-left: 1px solid #eee;
        width: 20px;
        text-align: center;
        color: #333;
        font-size: 13px;
        font-family: "Trebuchet MS", Helvetica, sans-serif !important;
        line-height: 1.7;
        -webkit-transform: translateX(-100%);
        transform: translateX(-100%);
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -o-user-select: none;
        user-select: none;
    }

    .quantity-button.quantity-up {
        position: absolute;
        height: 50%;
        top: 0;
        border-bottom: 1px solid #eee;
    }

    .quantity-button.quantity-down {
        position: absolute;
        bottom: -1px;
        height: 50%;
    }

    .input-group-prepend {
        position: absolute !important;
        text-align: center !important;
    }
</style>

<body>

    <?php
    $sql = "SELECT * FROM `drug_reference` WHERE `session_id` LIKE ?;";
    $q = $pdo->prepare($sql);
    $q->execute(array($session_id));
    $row = $q->fetch(PDO::FETCH_ASSOC);
    $lot = $row['drug_reference_id'];

    $sql = "SELECT COUNT(*) AS `total` FROM `drug_cart` WHERE `drug_cart_lot_id` = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($lot));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $total = $data['total'];
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <?php if ($total == 0) { ?>
                    <div class="text-center" style="margin-top:350px;margin-bottom:90px;">
                        <h2>ไม่มีสินค้าในตะกร้า !</h2>
                        <br><br><br><br><br><br><br><br>
                        <a href="3.search.php" class="btn btn-primary btn-lg"><i class="fa fa-arrow-left"></i> เลือกสินค้า</a>
                    </div>
                <?php } else { ?>

                    <table class="table">
                        <thead>
                            <tr class="table-info">
                                <th class="text-center">#</th>
                                <th class="text-center">รูปภาพ</th>
                                <th class="text-center">ชื่อสินค้า</th>
                                <th class="text-center">ราคา/ต่อหน่วย</th>
                                <th class="text-center" style="width: 165px;">จำนวน</th>
                                <th class="text-center">ทั้งหมด</th>
                                <th class="text-center">ตัวเลือก</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $i = 0;
                            $sql = "SELECT * FROM `drug_reference` WHERE `session_id` LIKE ?;";
                            $q = $pdo->prepare($sql);
                            $q->execute(array($session_id));
                            $data = $q->fetch(PDO::FETCH_ASSOC);
                            $member_reference_id_2 = $data['drug_reference_id'];

                            $sql2 = "SELECT * FROM `drug_cart`,`drug` WHERE `drug_cart`.`drug_id` = `drug`.`drug_id` AND `drug_cart_lot_id` = ?";
                            $q2 = $pdo->prepare($sql2);
                            $q2->execute(array($member_reference_id_2));
                            $total_price_sum = 0;

                            while ($row2 = $q2->fetch(PDO::FETCH_ASSOC)) {
                                $i++; ?>
                                <tr>

                                    <td><br><br><br><br><?= $i; ?></td>
                                    <td><br><img class="thumbnail" src="pic_drug/<?= $row2['drug_picture']; ?>" style="height: 150px;width: 150px;"><br><br></td>
                                    <td><br><br><br><?= $row2['drug_name']; ?></td>
                                    <td><br><br><br><?= $row2['drug_price']; ?></td>

                                    <td>
                                        <form action="update_qty.php?id=<?= $row2['drug_cart_id']; ?>" method="post">
                                            <div class="col-md-8"><br><br><br>
                                                <div class="input-group input-group-lg">
                                                    <div class="input-group-prepend">
                                                        <button class="form-control" onclick="stepDown(<?php echo $row2['drug_id'] ?>)">-</button>

                                                        <input style="text-align: center; width: 50px;" class="form-control" type="number" min="1" max="<?php echo $row2['drug_amount'] ?>" name="quantity" id="inputNumber<?php echo $row2['drug_id'] ?>" value="<?= $row2['qty']; ?>" required="">

                                                        <button class="form-control" onclick="stepUp(<?php echo $row2['drug_id'] ?>)">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($row2['drug_amount'] <= "10") {
                                                echo "<br><br><br>";
                                                echo "<p style='color:red;'>" . "จำนวนคงเหลือ: " . $row2['drug_amount'] . "</p>";
                                            }
                                            ?>
                                        </form>
                                    </td>

                                    <?php $total_price = $row2['drug_price'] * $row2['qty']; ?>
                                    <td><br><br><br><?= $total_price . " บาท"; ?></td>
                                    <td><br><br><br><a href="delete_cart.php?id=<?= $row2['drug_cart_id']; ?>" class="btn btn-danger btn-nm"><i class="fa fa-trash"> ลบ</i></a></td>
                                </tr>

                            <?php
                                $total_price_sum += $total_price;

                                $tax = ($total_price_sum * 7) / 100;

                                $total_price_tax = $total_price_sum - $tax;

                                $count += $row2['qty'];
                            }
                            ?>
                            <form action="?data=confirm" name="form" method="post">
                                <hr>
                                <h2 style="text-align:center"><span class="badge badge-pill badge-info"><?php echo "สินค้าในตะกร้า : " . $count . " ชิ้น" ?></span></h2>
                                <hr><br><br>
                                <tr class="table-light">
                                    <td>รวมราคา</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo number_format($total_price_tax) . ' บาท'; ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Vat (7%)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $tax . ' บาท'; ?></td>
                                    <td></td>
                                </tr>
                                <tr class="table-info">
                                    <td><b>ราคาสุทธิ</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo "<b>" . number_format($total_price_sum) . ' บาท' . "</br>"; ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="12">
                                        <a href="3.search.php" style="float:left" class="btn btn-primary btn-lg"><i class="fa fa-arrow-left"></i> เลือกสินค้าเพิ่ม</a>
                                        <input type="submit" value="ยืนยันการสั่งซื้อ" class="btn btn-success btn-lg" style="float: right" onClick="return confirm ('ยืนยันการสั่งซื้อ');"></input>
                                    </td>
                                </tr>
                                <input name="total_price_sum" type="hidden" value="<?php echo $total_price_sum; ?>">
                            </form>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php

    //update จำนวนสินค้า
    if ($_REQUEST['data'] == 'confirm') {

        $sum = $_POST['total_price_sum'];

        $conn->query("INSERT INTO `drug_orders`(`drug_orders_id`, `order_date`, `orders_sum`, `drug_reference_id`) VALUES(NULL,NOW(),'$sum','$lot')");

        $orders_id = mysqli_insert_id($conn);

        $sql2 = $conn->query("select * from drug_cart where member_id = '$_SESSION[admin_login]'") or die($mysqli->error);

        while ($row2 = $sql2->fetch_assoc()) {
            $conn->query("update drug set drug_amount = drug_amount-'$row2[qty]' where drug_id = '$row2[drug_id]'") or die($mysqli->error);

            $conn->query("INSERT INTO `drug_orders_detail`(`orders_id`, `orders_drug_id`, `orders_qty`, `orders_date`) 
            
            VALUES ('$orders_id','$row2[drug_id]' ,'$row2[qty]' ,NOW() )") or die($mysqli->error);
            
        }

        header("Location: success.php?orders_id=" . "$orders_id");
        // header('ทำการสั่งซื้อเรียบร้อย','location:success.php');
        // Alert('ทำการสั่งซื้อเรียบร้อย', 'success.php');
    }
    ?>

    <script type="text/javascript">
        function stepUp(idRow) {
            document.getElementById('inputNumber' + idRow).stepUp();
        }

        function stepDown(idRow) {
            document.getElementById('inputNumber' + idRow).stepDown();
        }

        // function goUrl() {
        //     Swal.fire({
        //         icon: 'warning',
        //         title: 'คุณต้องการคิดเงินใช่หรือไม่?',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'ใช่',
        //         cancelButtonText: 'ไม่!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             location = 'success.php'
        //         } else {
        //             location = '#'
        //         }
        //     });
        // }
    </script>

</body>

<?php Database::disconnect(); ?>

</html>