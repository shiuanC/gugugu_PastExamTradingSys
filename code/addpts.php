 <?php
 /*
    work for update of the points data of user

    by 莊孝萱
 */
    session_start();
    include("connect.php");
    require("encoder.php");
    $user_name = $_SESSION['loginId'];
    $en = $_SERVER['QUERY_STRING'];
    $de = geturl($en,$key_url_md_5);//將加密的GET網址解密
    $sub_type = $de['sub_type'];
    //get the data of user
    $sql_user = "SELECT * FROM users WHERE username = '$user_name'";
    $ret_user = mysqli_query($con, $sql_user);
    $USER = mysqli_fetch_array($ret_user);
    $gunum = $USER['gunum'];
    $pts = $USER['points'];

    //get the points cost according to the subject's type
    switch($sub_type){
        //for 必修 each data need 5 pts
        case 0:
            $pts += 5;
            break;
        //for 選修 each data need 3 pts
        case 1:
            $pts += 3;
            break;
        //for 通識 each data need 2 pts
        case 2:
            $pts += 2;
            break;
    }       
    $sql_save = "UPDATE `users` SET `points` = '$pts' WHERE `users`.`username` = '$user_name';";
    
    if (mysqli_query($con, $sql_save) === TRUE) {
        echo ("<script>document.location.href='home.php';</script>");//上傳成功後回到home
    } else {
        echo "Error updating record: " . $con->error;
    }


?>