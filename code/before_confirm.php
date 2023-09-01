<?php
/*
by 莊孝萱
*/
    session_start();
    require("connect.php");
    require("encoder.php");//取得加密檔案
    $en = $_SERVER['QUERY_STRING'];
    $de = geturl($en,$key_url_md_5);//將存有GET值的網址解密，解密後得到的資料性質為array
    $art_id = $de['id'];
    $user_name = $_SESSION['loginId'];

    //get the data of user
    $sql_user = "SELECT * FROM users WHERE username = '$user_name'";
    $ret_user = mysqli_query($con, $sql_user);
    $USER = mysqli_fetch_array($ret_user);
    $gunum = $USER['gunum'];//nuber of 考古題
    $gu = $USER['gugugu'];// 存有考古題的id 的JSON data
    $pts = $USER['points'];//user現有的積分
    $gu_json = json_decode($gu);//將紀錄考古的欄位轉換成json

    //get the data of article
    $sql_a = "SELECT * FROM article WHERE id = '$art_id'";
    $ret_a = mysqli_query($con, $sql_a);
    $ARTI = mysqli_fetch_array($ret_a);
    $sub_type = $ARTI['sub_type'];
    $sub_id = $ARTI['sub_id'];


    //get the points cost according to the subject's type
    switch($sub_type){
        //for 必修 each data need 5 pts
        case 0:
            $cost = 5;
            break;
        //for 選修 each data need 3 pts
        case 1:
            $cost = 3;
            break;
        //for 通識 each data need 2 pts
        case 2:
            $cost = 2;
            break;
    }       
        
    //check if the point is enough for the data
    if($pts>=$cost){
        $str = "id=$art_id&cost=$cost";
        $str_en = encrypt_url($str,$key_url_md_5);//加密GET的部分
        echo ("<script>document.location.href='confirm.php?$str_en';</script>");
    }else{
        echo ('<script> alert("點數不夠啊～～QQ"); </script>');
        echo $pts;
    }
    
?>