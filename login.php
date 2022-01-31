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
?>
<html>

<style>
    html,
    body {
        background-image: url('https://image.freepik.com/free-photo/abstract-blur-defocused-pharmacy-drug-store_1203-9459.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        height: 100%;
        font-family: 'Numans', sans-serif;
    }

    #login-box {
        position: absolute;
        top: 150px;
        left: 50%;
        transform: translateX(-50%);
        width: 400px;
        margin: 0 auto;
        border: 1px solid black;
        background: rgba(48, 46, 45, 1);
        min-height: 250px;
        padding: 20px;
        z-index: 9999;
        border-radius: 10px;
    }

    #login-box .logo .logo-caption {
        font-family: 'Poiret One', cursive;
        color: white;
        text-align: center;
        margin-top: 30px;
    }

    #login-box .logo .tweak {
        color: #ff5252;
    }

    #login-box .controls {
        padding-top: 30px;
    }

    #login-box .controls input {
        border-radius: 0px;
        background: rgb(98, 96, 96);
        border: 0px;
        color: white;
        font-family: 'Nunito', sans-serif;
    }

    #login-box .controls input:focus {
        box-shadow: none;
    }

    #login-box .controls input:first-child {
        border-top-left-radius: 2px;
        border-top-right-radius: 2px;
    }

    #login-box .controls input:last-child {
        border-bottom-left-radius: 2px;
        border-bottom-right-radius: 2px;
    }

    #login-box button.btn-custom {
        border-radius: 2px;
        margin-top: 8px;
        background: #ff5252;
        border-color: rgba(48, 46, 45, 1);
        color: white;
        font-family: 'Nunito', sans-serif;
    }

    #login-box button.btn-custom:hover {
        -webkit-transition: all 500ms ease;
        -moz-transition: all 500ms ease;
        -ms-transition: all 500ms ease;
        -o-transition: all 500ms ease;
        transition: all 500ms ease;
        background: rgba(48, 46, 45, 1);
        border-color: green;
    }

    #particles-js {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: 50% 50%;
        position: fixed;
        top: 0px;
        z-index: 1;
    }

    p {
        font-size: 15px;
        font-family: 'Sarabun', sans-serif;
    }


    h1 {
        font-family: 'Sarabun', sans-serif;
    }
</style>

<body>

    <form action="check_login.php" method="post">
        <div class="container">
            <div id="login-box">
                <div class="text-center">
                    <img src="images/pharmacy.jpg" class="rounded" style="color:white;margin-top: 15px;" />
                    <h1 style="color:white;margin-top: 30px;" class="logo-caption">เข้าสู่ระบบ</h1>
                </div><!-- /.logo -->
                <div class="controls">
                    <input type="text" name="username" placeholder="Username" class="form-control" required>
                    <br>
                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                    <br>
                    <div class="checkbox">
                        <label>
                            <input name="remember" type="checkbox" value="Remember Me">
                            <p style="color: white;">จดจำฉัน</p>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default btn-block btn-custom">
                        <p style="font-size:18px; color:white; margin-top: 10px;">ยืนยัน</p>
                    </button>
                </div><!-- /.controls -->
            </div><!-- /#login-box -->
        </div><!-- /.container -->

</body>


</html>