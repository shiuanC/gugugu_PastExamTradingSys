<?php
    $server="140.114.87.219";
    $db_username="gugugu";
    $db_password="YwHdnpzEB";
    $con = mysqli_connect($server, $db_username, $db_password); //連結資料庫
    if(!$con){
        die("can't connect".mysqli_error());//如果連結失敗輸出錯誤
    }
    mysqli_select_db($con, "gugugu");
?>