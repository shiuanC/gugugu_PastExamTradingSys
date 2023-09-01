<!doctype html>
<!-- Website template by freewebsitetemplates.com -->
<!-- CSS, html by李卓庭 php, html by莊孝萱 -->
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gugugu</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/mobile.css">
	<script src="js/mobile.js" type="text/javascript"></script>
</head>
<body>
    <div id = "page">
        <p>
            <?php 
                session_start();
                require("connect.php");
                #沒有已註冊帳號進主頁面跳回登入頁
                if(!(isset($_SESSION['loginId']))){
                    echo '<script> window.location.href=\'index.php\'</script>';
                }
                #無帳號進主頁面跳回登入頁
                if($_SESSION['loginId']==''){
                    echo '<script> window.location.href=\'index.php\'</script>';
                }
                echo "<span style='font-size:16px; font-family: Comic Sans MS; margin-left:50px'>歡迎，".$_SESSION['loginId']." !!!</span>";
                #登出帳號回登入頁
                echo "<span style='font-size:16px; font-family: Comic Sans MS; margin-left:950px;'><a href='member.php'>會員專區</a></span><span style='margin-left:20px;'><a href='index.php'>登出</a></span>";
                echo "<br>";
            ?>
        </p>
        <div id="header">
			<div>
				<a href="home.php" class="logo"><img src="images/logo.png" alt=""></a>
				<ul id="navigation">
                    <li class="selected">
						<a href="home.php">Home</a>
					</li>
					<li class="menu">
						<a href="required.php">必修題目</a>
					</li>
					<li class="menu">
						<a href="elective.php">選修題目</a>
					</li>
					<li class="menu">
						<a href="general.php">通識題目</a>
					</li>
					<li>
						<a href="chatroom.php">Chatroom</a>
					</li>
					<li>
						<a href="about.php">關於我們</a>
					</li>
                    <li>
                        <?php
                        #管理者頁面
                        if($_SESSION['loginId']=='aaa'){
                            echo '<a href="admin.php" target="_blank">管理者頁面</a>';
                        }
                        ?>
                    </li>
				</ul>
			</div>
        </div>
        <div id="body">
            <div class="header">
                <div>
                    <h1>上傳題目圖片</h1>
                </div>
            </div>
            <div>
                <form method="POST" enctype='multipart/form-data'>
                    <h3 style="text-align:center;">Only image file accepted !!!</h3>
                    <!-- 上傳考題 可上傳多個圖片 -->
                    <p><input input style="margin-left:440px;" name="img[]" type="file" accept="image/*" multiple/></p>
                    <br><p><textarea input style="margin-left:250px;" name="content" rows="10" cols="70" placeholder = "Type your message in here!"></textarea><input style="margin-left: 20px;" type="submit" name='submit' /></p>
                </form>
            </div>           
        </div>
        <div id="body" class="home">
			<br><br><br>
			<p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
        </div>
    </div>
</body>
</html>

<?php
include("connect.php");//連接上database
require("encoder.php");//連接加解密檔案

if(isset($_POST['submit'])){
    $user_name = $_SESSION['loginId'];
    $en = $_SERVER['QUERY_STRING'];
    $de = geturl($en,$key_url_md_5);//將加密的GET網址解密
    //解密後會獲得array
    $p_time = $de['p_time'];
    $p_date = $de['p_date'];
    $sub_type = $de['sub_type'];
    $member = $_SESSION['loginId'];
    $context = $_POST['content'];

    //取得文章id 用來存給img的table 紀錄
    $sql = "SELECT id FROM article WHERE p_time='$p_time' AND p_date='$p_date' AND member='$member'";
    $ret =  mysqli_query($con, $sql);
    $row = mysqli_fetch_array($ret);
    $art_id = $row['id'];
    
    # 取得上傳檔案數量
    $img_num = count($_FILES['img']['name']);
    if($img_num == 0){
        echo "<script>alert('尚未上傳任何檔案！！'); </script>";
    }else{
        for ($i = 0; $i < $img_num; $i++) {
            # 檢查檔案是否上傳成功
            if ($_FILES['img']['error'][$i] === UPLOAD_ERR_OK){
                $data = file_get_contents($_FILES['img']['tmp_name'][$i]);
                $data = $con->real_escape_string($data);
                $sql = "INSERT INTO `image` (`url`,`art_id`, `page`) VALUES ('$data', '$art_id', '$i');";
                $result = mysqli_query($con, $sql);
                if(!$result){
                    echo("can't add".mysqli_error($con));//如果連結失敗輸出錯誤
                }else{
                    $sql_id="UPDATE `article` SET context= '$context' WHERE id=$art_id";
                    $result = mysqli_query($con, $sql_id);
                    if(!$result){
                        echo("can't add".mysqli_error($con));//如果連結失敗輸出錯誤
                    }else{
                        $en = encrypt_url("sub_type=$sub_type",$key_url_md_5);
                        echo "<script>alert('檔案上傳成功！！'); </script>";
                        echo "<script>document.location.href='addpts.php?$en';</script>";
                        
                    }
                }
            } else {
                echo "<script>alert('檔案上傳失敗'); </script>";
            }  
        }

    }
    
}
?>