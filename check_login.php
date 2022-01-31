<?php
ob_start();
session_start();
include 'consqli.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (!empty($_POST)) {
    $usernameError = null;
    $passwordError = null;

    $username = $_POST['username'];
    $password = $_POST['password'];

    $valid = true;
    if (empty($username)) {
        $usernameError = 'กรุณาใส่ชื่อ user';
        $valid = false;
        header("Location: index.php");
    }
    if (empty($password)) {
        $passwprdError = 'กรุณาใส่รหัสผ่าน';
        $valid = false;
        header("Location: index.php");
    }

    // insert data
    if ($valid) {

        $sql = "SELECT * FROM `member` WHERE `member_user` LIKE ?;";
        $q = $pdo->prepare($sql);
        $q->execute(array($username));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $member_id = $data['member_id'];
        $member_password = $data['member_password'];
        $member_status = $data['member_status'];
        $check_active = $data['check_active'];

        $pw = MD5($password);

        //echo $pw;
        if (($username == 'admin') && ($member_status == 'admin')) {
            $_SESSION["admin_login"] = $data['member_id'];
            header("Location: index.php");
        } else if ($pw == $member_password) {
            if ($check_active == 1) {
                $_SESSION["user_login"] = $data['member_id'];
                header("Location: 4.stock.php");
            } else {
                $_SESSION["user_login"] = $data['member_id'];
                header("Location: active.php");
            }
        } else {
            header("Location: login.php?Error=1");
        }
    }
}
Database::disconnect();

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เว็บไซต์คัดกรองยา</title>
</head>

</html>