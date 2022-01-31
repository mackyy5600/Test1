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

?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="js/document.js">  -->
</head>

<style>
    body {
        font-family: 'Sarabun', sans-serif;
    }
</style>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-info table-striped" border="2" align="center">
                    <thead>
                        <tr class="table-info">
                            <th style="text-align:center" width="38%">รูปยา</th>
                            <th style="text-align:center" width="10%">บาร์โค้ด</th>
                            <th style="text-align:center" width="20%">ชื่อทางการค้า</th>
                            <!-- <th style="text-align:center" width="10%">ชื่อสามัญ</th> -->
                            <th style="text-align:center" width="12%">ประเภทยา</th>
                            <th style="text-align:center" width="12%">คงเหลือ</th>
                            <th style="text-align:center" width="12%">ราคา/หน่วย</th>
                            <th style="text-align:center" width="20%">จำหน่าย</th>
                        </tr>
                    </thead>

                    <?php
                    echo '<font size="6em" color="red">';
                    echo 'คำค้น = ';
                    echo $_GET['search'];
                    echo '</font>';
                    echo '<br/>';
                    $sql = "SELECT * FROM `drug`
                    WHERE drug_name LIKE '%$search%' OR drug_document_id LIKE '%$search%' OR drug_barcode_id  LIKE '%$search%'OR drug_properties  LIKE '%$search%'                    
                    ORDER BY drug_id ASC";

                    // $result = mysqli_query($conn, $sql);
                    // while ($row = mysqli_fetch_array($result)) { 
                    // foreach ($pdo->query($sql) as $row) {
                    foreach ($pdo->query($sql) as $row) { ?>
                        <tr>
                            <?php echo "<td style='background-color:#F1EEEE' align='center'><img src='pic_drug/" . $row["drug_picture"] . " ' width='150' >" ?>
                            <td style="text-align:center;background-color:#F1EEEE"><?php echo $row['drug_barcode_id']; ?></td>
                            <td style="text-align:center;background-color:#F1EEEE"><?php echo $row['drug_name']; ?></td>
                            <td style="text-align:center;background-color:#F1EEEE"><?php echo $row['drug_category']; ?>
                                <br><br>
                                <button class="btn btn-success btn-sm" id="btnDoc<?php echo $row['drug_compound_id'] ?>" onclick="myDocument(<?php echo $row['drug_compound_id'] ?>)">ฉลากยาเสริม</button>
                            </td>
                            <td style="text-align:center;background-color:#F1EEEE"><?php echo number_format($row['drug_amount']); ?> <?php echo $row['drug_unit_price']; ?></td>
                            <td style="text-align:center;background-color:#F1EEEE"><?php echo $row['drug_price'] . " บาท"; ?></td>
                            <form action="order.php" method="post">
                                <input type="hidden" name="Id_drug" value="<?php echo $row['drug_id']; ?>">
                                <input type="hidden" name="qty" value="1">
                                <td style="text-align:center;background-color:#F1EEEE"><button type="submit" class="btn btn-info btn-nm add-cart" onclick="basket(<?php echo $row['drug_id']; ?>)">
                                        <i class="fa fa-shopping-cart"></i> ใส่ตะกร้า</button>
                            </form>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>

<script>
    function myDocument(idDoc) {
        if (idDoc == '1') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ขนาดยาในผู้ใหญ่ ไม่เกิน 15 มก./กก./ครั้ง(สูงสุด 1,000 มก.) และไม่เกิน 4,000 มก.(8 เม็ด) ใน 24 ชั่วโมง',
                footer: '<p style="color:red; font-size:17px;">ผู้ใหญ่ไม่ควรใช้ยานี้ติดต่อกันนานเกิน 10 วัน โดยไม่ปรึกษาแพทย์</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '2') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ขนาดยาในเด็ก ไม่เกิน 15 มก./กก./ครั้ง(สูงสุด 1,000 มก.) และไม่เกิน 75 มก./กก./24 ชั่วโมง(สูงสุด 3,250 มก./24 ชั่วโมง)',
                footer: '<p style="color:red; font-size:17px;">เด็กไม่ควรใช้ยานี้ติดต่อกันนานเกิน 5 วันโดยไม่ปรึกษาแพทย์</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '19') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'เพื่อบรรเทาอาการปวดหัว ปวดฟัน ปวดประจำเดือนปวดกล้ามเนื้อ (สำหรับอาการปวดระดับน้อยถึงปานกลาง)',
                footer: '<p style="color:red; font-size:17px;">ห้ามจ่ายยาให้กับผู้ที่มีอาการแพ้ยาในกลุ่ม NSAID ห้ามใช้แก้ปวดลดไข้ในผู้ป่วยที่เป็นไข้หวัดใหญ่ ไข้เลือดออก และอีสุกอีใส</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '9') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ยานี้เป็นยาปฏิชีวนะ ใช้รักษาโรคติดเชื้อแบคทีเรีย ไม่ออกฤทธิ์ต่อไวรัส',
                footer: '<p style="color:red; font-size:17px;">การใช้ยานี้โดยไม่จำเป็นเพิ่มความเสี่ยงจากผลข้างเคียงของยา เช่น อาการท้องร่วงหรืออาจแพ้ขั้นรุนแรงที่เป็นอันตรายถึงชีวิตได้</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '6') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ยานี้เป็นยาแก้แพ้ชนิดง่วงน้อย ใช้เฉพาะเมื่ออาการของโรคมีสาเหตุจากการแพ้',
                footer: '<p style="color:red; font-size:17px;">ยานี้ไม่ช่วยลดน้ำมูกในผู้ที่มีน้ำมูกไหลจากโรคหวัด ไอ เจ็บคอ เนื่องจากโรคดังกล่าวเป็นโรคติดเชื้อ</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '5') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ยาแก้ปวดที่มีอาการเล็กน้อยถึงปานกลาง ยาลดไข้ ยาลดการอักเสบของกล้ามเนื้อและเส้นเอ็น',
                footer: '<p style="color:red; font-size:17px;">ยานี้เป็นยาในกลุ่มเอ็นเสด ห้ามใช้ยานี้ถ้าเคยแพ้เอ็นเสดชนิดอื่น ไม่ควรใช้ไอบรูโพรเฟนร่วมกับแอสไพริน</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '4') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ยาแก้ปวดที่มีอาการเล็กน้อยถึงปานกลาง ยาลดไข้ ยาลดการอักเสบของกล้ามเนื้อและเส้นเอ็น ควรใช้ NSAID ด้วยขนาดยาต่ำที่สุด และด้วยระยะเวลาที่สั้นที่สุด',
                footer: '<p style="color:red; font-size:17px;">ยานี้เป็นยาในกลุ่มเอ็นเสด ห้ามใช้ยานี้ถ้าเคยแพ้เอ็นเสดชนิดอื่น ไม่ควรใช้ไอบรูโพรเฟนร่วมกับแอสไพริน</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '3') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'การใช้พาราเซตามอลเกินขนาด อาจทำให้เซลล์ตับถูกทำลาย มีอาการตาเหลือง ตัวเหลืองอ่อนเพลีย นำไปสู่ภาวะตับวายและการเสียชีวิตได้',
                footer: '<p style="color:red; font-size:17px;">ยานี้อาจทำให้ง่วง รวมถึงระวังการได้รับพาราเซตามอลเพิ่มเติมจากแหล่งอื่น เพราะจะได้รับพาราเซตามอลอย่างซ้ำซ้อน จนได้รับยาเกินขนาด</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '17') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ใช้ยานี้ตามแพทย์สั่ง ไม่เพิ่มขนาดยาเองเพราะหากใช้เกินขนาดอาจเกิดพิษต่อระบบต่าง ๆ ของร่างกายได้',
                footer: '<p style="color:red; font-size:17px;">หยุดยาทันทีถ้ามีอาการท้องเสียตั้งแต่ 3 ครั้งคลี่นไส้อาเจียน หรือปวดท้อง ถ้าอาการรุนแรงต้องรีบไปพบแพทย์ทันที</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '18') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ผู้มีกรดยูริกสูงในเลือดเพียงประการเดียวไม่ควรใช้ยานี้ แต่ควรใช้เมื่อมีอาการอื่นร่วมด้วย',
                footer: '<p style="color:red; font-size:17px;">หยุดยาทันทีถ้ามีผื่นขึ้น เป็นไข้ ตาแดงหรือมีแผลในปากหลังใช้ยา</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '16') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ใช้เพื่อป้องกันโรคหลอดเลือดหัวใจและสมองในคนที่มีความเสี่ยงสูง หรือใช้ป้องกันการกลับเป็นซ้ำของผู้เป็นโรคหลอดเลือดหัวใจและสมองแล้ว',
                footer: '<p style="color:red; font-size:17px;">ยานี้อาจทำให้กล้ามเนื้ออักเสบจนเกิดภาวะกล้ามเนื้อสลาย ถ้าเจ็บกล้ามเนื้อรุนแรงโดยไม่มีสาเหตุควรไปพบแพทย์ทันที</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '15') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'การใช้ยานี้ต้องทำควบคู่ไปกับการควบคุมอาหาร และการออกกำลังกายอย่างสม่ำเสมอมิฉะนั้นจะรักษาไม่ได้ผล',
                footer: '<p style="color:red; font-size:17px;">ควรใช้ยาต้านเบาหวานตามแพทย์สั่งอย่างเคร่งครัด ไม่ลดหรือเพิ่มขนาดยาเอง</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '14') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'การใช้ยานี้ต้องทำควบคู่ไปกับการควบคุมอาหาร และการออกกำลังกายอย่างสม่ำเสมอมิฉะนั้นจะรักษาไม่ได้ผล',
                footer: '<p style="color:red; font-size:17px;">ห้ามใช้ถ้ามีไตวายเรื้อรังขั้นรุนแรง(ระยะที่ 4 และ 5) ปรึกษาแพทย์เพื่อหยุดใช้ยานี้ชั่วคราวกรณีต้องเอกซเรย์ด้วยการฉีดสี (สารทึบรังสี)</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '13') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ยานี้อาจทำให้เกิดการบวมที่เท้า ซึ่งเกิดจากการขยายตัวของหลอดเลือดแดงขนาดเล็กที่ส่วนปลายของร่างกาย ส่วนใหญ่เป็นการบวมในระดับน้อยถึงปานกลาง และมักไม่จำเป็นต้องหยุดยาเนื่องจากไม่เป็นอันตรายต่อผู้ป่วยอาการบวมนี้ไม่ได้หมายถึงการเป็นโรคไต',
                footer: '<p style="color:red; font-size:17px;">เมื่อมีอาการบวมควรแจ้งให้แพทย์ทราบไม่ควรหยุดยาเอง แพทย์อาจใช้ยานี้ด้วยสาเหตุอื่นนอกเหนือจากภาวะความดันเลือดสูง หากสงสัยให้ปรึกษาแพทย์หรือเภสัชกร</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        } else if (idDoc == '12') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ยานี้อาจทำให้มีอาการไอเรื้อรัง ลักษณะไอแบบแห้ง ๆ รู้สึกคันในลำคออาการนี้เป็นผลข้างเคียงจากยา ควรแจ้งให้แพทย์ทราบว่ามีอาการไอ เพื่อทำการวินิจฉัยและเปลี่ยนเป็นยากลุ่มอื่นให้แทน',
                footer: '<p style="color:red; font-size:17px;">ห้ามใช้กับหญิงมีครรภ์ช่วงไตรมาส 2, 3 แพทย์อาจใช้ยานี้ด้วยสาเหตุอื่นนอกเหนือจากภาวะความดันเลือดสูง หากสงสัยให้ปรึกษาแพทย์หรือเภสัชกร</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        }
        else if (idDoc == '11') {
            Swal.fire({
                icon: 'info',
                title: 'ฉลากยาเสริม',
                text: 'ไม่ควรใช้ยานี้เกิน 0.75 มก./กก./วัน และไม่ควรใช้ยานี้ติดต่อกันเกิน 7 วัน ระมัดระวังเป็นพิเศษกับผู้มีการทำงานของไตผิดปกติ ',
                footer: '<p style="color:red; font-size:17px;">ยานี้อาจทำให้หัวใจเต้นผิดจังหวะ ซึ่งเป็นอันตรายถึงชีวิตได้หากใช้เกินขนาด หากใช้ติดต่อกันเป็นเวลานาน</p>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'รับทราบ'
            });
        }

    }

    // $('.id-doc').click(function(e) {
    //     e.preventDefault();
    //     swal.fire({
    //         icon: 'warning',
    //         title: 'ข้อควรระวัง !',
    //         text: 'ขนาดยาในเด็ก ไม่เกิน 15 มก./กก./ครั้ง(สูงสุด 1,000 มก.) และไม่เกิน 75 มก./กก./24 ชั่วโมง(สูงสุด 3,250 มก./24 ชั่วโมง)',
    //         footer: '<p style="color:red; font-size:17px;">เด็กไม่ควรใช้ยานี้ติดต่อกันนานเกิน 10 วันโดยไม่ปรึกษาแพทย์</p>',
    //         confirmButtonColor: '#3085d6',
    //         confirmButtonText: 'รับทราบ'
    //     });
    // });
</script>

</html>