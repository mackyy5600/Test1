<?php
function Total_Cart()
{
    include "consqli.php";

    $sql = $conn->query("select * from drug_cart where member_id = '$_SESSION[admin_login]'") or die($mysqli->error);
    echo $rows = $sql->num_rows;
}
