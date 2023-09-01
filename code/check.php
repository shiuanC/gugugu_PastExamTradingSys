<?php
/* 
a transition between confirm.php and article.php
work for save the new data of user's 考古題 data

by 莊孝萱
*/
    session_start();
    require("connect.php");
    require("encoder.php");//取得加密檔案
    $user_name = $_SESSION['loginId'];
    $art_id = $_POST['art_id'];
    $new_gunum = $_POST['gunum'];
    $new_pts = $_POST['pts'];

    
    $json = '';
    $sql = "select * from users where username = '$user_name'";
    $ret = mysqli_query($con,$sql);
    if(!$ret){
        echo ("Error: ".mysqli_error($con));
        exit();
    }
    while($row=mysqli_fetch_array($ret)){
    $json = $row['gugugu'];
    }
    $json = json_decode($json);
    $json->{$new_gunum} = $art_id;
    $json = json_encode($json);
    $sql_save = "UPDATE `users` SET `points` = '$new_pts', `gunum` = '$new_gunum', `gugugu` = '$json' WHERE `username` = '$user_name';";
    //$result = mysqli_query($con, $sql_save);
    if (mysqli_query($con, $sql_save) === TRUE) {
        $str = "id=$art_id";
        $str_en = encrypt_url($str,$key_url_md_5);//將ＧＥT的網址部分加密
        echo ("<script>document.location.href='article.php?$str_en';</script>");
    } else {
        echo "Error updating record: " . $con->error;
    }
    
        
    //e
?>
