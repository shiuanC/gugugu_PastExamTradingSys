<?php
    require('encoder.php');
    $id = 5;
    $cost = 19;
    $sql_en = encrypt_url("id=$id&cost=$cost",$key_url_md_5);
    $val = geturl($sql_en,$key_url_md_5);
    echo $sql_en."<br>";
    echo $val."<br>";
    $id_de = $val['id'];
    $cost_de = $val['cost'];
    echo $id_de;
?>