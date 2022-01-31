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

include("bootstrap.php");
include("navbar.php");

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
    $drug_amount = $data2['drug_amount'];
    $drug_properties = $data2['drug_properties'];
}
?>

<style>
    body {
        background-image: url('images/bgg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }

    h1 {
        font-family: 'Sarabun', sans-serif;
        font-size: 50px;
        font-weight: bold;
    }

    p {
        text-align: left;
        font-size: 18px;
        font-weight: bold;
    }
</style>

<body>
    <br><br><br>
    <div class="container">
        <section class="p-10 my-md-5 text-center">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card" style="height:100%; width:114%">
                        <div class="card-body">
                            <div class="callout callout-primary"><br>
                                <h3 style="font-size:27px; text-align: center; font-family: 'Sarabun', sans-serif;"><i class="fa fa-edit"></i><mark> กำลังแก้ไขข้อมูล</mark></h3>
                            </div><br>

                            <div class="text-center">
                                <div class="header">
                                    <div class="button-group">
                                        <a href="4.stock.php" style="font-family: 'Sarabun', sans-serif;" class="btn btn-info btn-nm"><i class="fa fa-arrow-left"></i> กลับ</a>
                                    </div>
                                </div>
                            </div><br>

                            <form id="myForm" action="stock_update.php" method="post" enctype="multipart/form-data">
                                <!-- <form class="text-center" style="color: #757575;" action="" method="POST"> -->
                                <input type="hidden" name="item_id" value="<?= $id; ?>">
                                <input type="hidden" name="stock_id" value="<?= $id; ?>">
                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <label>
                                            <p>ชื่อทางการค้า</p>
                                            <input style="height:30%; width:108%;" class="form-control" type="text" name="item_name" value="<?= $drug_name ?>">
                                        </label>
                                    </div>

                                    <div class="col-md-4">
                                        <label>
                                            <p>ราคา</p>
                                            <div class="input-group mb-3">
                                                <input class="form-control input-group-field" min="1" max="999" type="number" name="item_price" value="<?= $drug_price; ?>">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">บาท</span>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label>
                                            <p>จำนวน</p>
                                            <input style="size: 30;" class="form-control" type="number" min="1" max="999" name="item_amount" value="<?= $drug_amount; ?>">
                                            <span class="input-group-label">
                                                <input style="size: 30;" class="form-control" type="text" name="item_unit" value="<?= $drug_unit_price; ?>" readonly>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row justify-content-center">
                                    <div class="col-md-8.5 text-center"><br>
                                        <img class="thumbnail" name="item_picture" src="pic_drug/<?= $drug_picture; ?>" style="height:300px; width:300px; ">
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <br><br><br>
                                    <select class="custom-select custom-select-md mb-6" name="document" required>
                                        <?php
                                        $sql = "SELECT * FROM `drug_document` ORDER BY `drug_document`.`document_id` ASC";
                                        $q = $pdo->prepare($sql);
                                        $q->execute(array());
                                        while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<option value="' . $row['document_id'] . '">' . $row['document_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div> -->

                                <br><br>
                                <textarea id="w3review" class="form-control" name="w3review" rows="4" cols="50"><?php echo $drug_properties; ?></textarea>
                                <br>


                                <button class="btn btn-success btn-lg" id="submitBtn2" type="submit" onclick="enter()" name="save" value="">ยืนยัน</button>

                                <!-- <?php
                                        if ($drug_picture == '-') { ?>
                                    <input type="hidden" name="check_img" value="1">
                                    <div class="row justify-content-center">
                                        <div class="medium-6 columns">
                                            <label>
                                                <p>อัพโหลดรูป</p>
                                            </label>
                                            <label for="exampleFileUpload" class="button"><i class="fa fa-upload"></i> Browse...</label>
                                            <input type="file" id="exampleFileUpload" class="show-for-sr" name="file">
                                        </div>
                                    </div><br><br>
                                <?php } else { ?>


                                 <div class="col-md-9 text-center"><br>
                                            <a href="delete_file.php?filename=<?= $drug_picture; ?>&p_id=<?= $id; ?>" class="btn btn-danger btn-lg" type="button" style="color: white !important;" onclick="return confirm('ต้องการลบรูป?')"><i class="fa fa-trash"></i> ลบรูป</a>
                                        </div>
                                    </div>
                                <?php } ?> 

                                <div class="col-md-12 text-center"><br>
                                     <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('ยืนยันการแก้ไข?')" name="submitUpdate"><i class="fa fa-check"></i> ยืนยัน</button> 

                                </div>  -->
                            </form>
                        </div><br>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- <script>
        $(document).ready(function() {
            $("#submitBtn2").click(function() {
                $("#myForm").submit();
                Swal.fire(
                    'Good job!',
                    'You clicked the button!',
                    'success'
                )
            });
        });
    </script> -->

    <script type="text/javascript">
        function enter() {
            Swal.fire({
                icon: 'success',
                title: 'เเก้ไขข้อมูลสำเร็จ'
            }).then(() => location = '4.stock.php');
        }
    </script>

    <!-- //////// JS ปุ่มลบรูป -->
    <!-- <?php
            function deletePic()
            {
                "<script> 
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'แก้ไขข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1000
            }).then(()=> location = '4.stock.php')
     </script>";
            }


            ?> -->

    <!-- 
    function deletePic() {
    Swal.fire({
    icon: 'warning',
    title: 'ลบรูปสำเร็จ'
    })
    } -->


</body>

</html>