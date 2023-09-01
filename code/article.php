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

<style>
	div.table1{
		border: 1px solid #990073;
		background-color: #f3e6ff;
    }
    div.table2{
		border: 1px solid #663300;
        background-color: #ffffcc;
        width: 900px;
        height: 300px;
        overflow: auto;
	}
</style>

<body>
    <div id="page">
        <p>
            <?php
                session_start();
                require("connect.php");
                require("encoder.php");//取得加密檔案
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
                $en = $_SERVER['QUERY_STRING'];// 取得加密的get網址
                $de = geturl($en,$key_url_md_5);//解密網址，得到紀錄了資料的array
                $id = $de['id'];//取得這篇article的id
                $sql ="SELECT * from article WHERE id=$id;";//取得mysql中article的資料
                $ret = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($ret);
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
                    <h1>題目</h1>
                </div>
            </div>
            <div>
                <table class = "big_board">
                <?php
                    $title = $row["title"];
                    $subject = $row["subject"];
                    $sub_id = $row["sub_id"];
                    $year = $row["year"];
                    $p_time = $row["p_time"];
                    $p_date = $row["p_date"];
                    $member = $row["member"];
                    $mid = $row["mid"];
                    
                    echo '<h3 style="text-align:center;">科目：'.$subject.'</h3>';
                    echo '<h4 style="text-align:center;">'.$year.'年，';
                    if($mid == 'final'){
                        echo '期末考';
                    }else{
                        echo '第 '.$mid.' 次考試';
                    }
                    echo"</h4>";
                    echo '<h4 style="text-align:center;">提供者：'.$member.'</h4>';
                    echo '<h4 style="text-align:center;">上傳時間：'.$p_date.'--'.$p_time.'</h4>';
                    echo"<br>";
                    $sql_img = "SELECT * FROM image WHERE art_id= $id;";
                    $ret_img =  mysqli_query($con, $sql_img);
                    while($row = mysqli_fetch_array($ret_img))
                    {
                        $img_id = (int)$row['id'];
                        $img = $row['url'];
                        echo "<div class='table1'>";
                        echo '<img style="margin-left: 100px;" width="80%;" src="data:image/jpeg;base64,'.base64_encode($img).'"/><br><br>';
                        $href = "<span style='margin-left:450px;'><a href=canvas.php?img_id=".$img_id."><strong> ↑ 編輯圖片</strong></a></span>";
                        echo $href.'</div><br><br>';
                    }   
                    
                ?>
                </table>
            </div> 
            <div>
                <table>
                    <?php 
                        $ret_msg = mysqli_query($con, "SELECT * from comment where art_id=$id;");
                        echo "<h3 style='text-align: center;'>留個言吧</h3><div class='table2'>";
                        while($MSG = mysqli_fetch_array($ret_msg))
                        {
                            $msg_time = $MSG["msg_time"];
                            $msg_date = $MSG["msg_date"];
                            $msg = $MSG["msg"];
                            $poster = $MSG['user'];
                            if(!$poster)
                                $poster = '匿名';
                            if($msg){
                                echo '<p style="margin-left: 20px;">{'.$msg_date.' '.$msg_time.'} <strong>'.$poster.'</strong>表示：'.$msg.'</p>';
                            }
                        }
                        echo "</div>";
                    ?>
                </table>
            </div>
        </div>
        <div style="margin-left: 380px;">
            <form method="POST">
                <input type="checkbox" name="hide_name" value='1'>
                <label>匿名</label><br>
                <textarea name="comment" rows="10" cols="70" placeholder = "Type your comment in here!"></textarea><br>
                <input style="margin-left: 250px;" type="submit" name="post"/>
            </form>
            <br><br><br>
        </div>
        <div id="body" class="home">
			<br><br><br>
			<p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
		</div>
    </div>   
</body>
</html>

<?php
//deal with the postcomment
if(isset($_POST['post'])){
    //use htmlentities() convert some characters to HTML entities
    $msg = htmlentities($_POST['comment']);
    $user = $_SESSION['loginId'];
    $msg_time = date("H:i:s");
    $msg_date = date("Y-m-d");

    if($_POST["hide_name"]=='1'){
        $user_name = NULL;
    }else{
        $user_name = $user;
    }
    
    if (!empty($msg) ){
        $sql_post ="INSERT INTO `comment` (`user`,`msg`, `msg_time`, `msg_date`, `art_id`) VALUES ('$user_name', '$msg', '$msg_time', '$msg_date', '$id');";
        $result_post = mysqli_query($con, $sql_post);
        if(!$result_post){
            echo("can't add".mysqli_error($con));//如果連結失敗輸出錯誤
        }
        else{//送出後回到頁面
            $str = "id=$id";
            $en = encrypt_url($str,$key_url_md_5);
            echo "<script>document.location.href='article.php?$en';</script>";
        }
    }
    else{
        //echo '<script>document.location.href="add.php";</script>';
        echo ('<script> alert("尚未發表任何意見喔！"); </script>');
    }
}

?>