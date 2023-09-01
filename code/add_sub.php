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
                require("encoder.php");//獲得加解密的檔案
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
            <?php 
                $en = $_SERVER['QUERY_STRING'];
                $de = geturl($en,$key_url_md_5);//將加密的GET網址解密
                $sub_id = $de['sub_id'];//利用sub id 直接紀錄就不用填哪麼多東西
                $sql ="SELECT * from article WHERE sub_id='$sub_id';";
                $ret = mysqli_query($con, $sql);
                $subject = '';
                while($row = mysqli_fetch_array($ret))
                {
                    $subject = $row["subject"];
                    $sub_type = $row["sub_type"];
                }
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
                    <h1>上傳題目</h1>
                </div>
            </div>
            <div>
                <form name="add_step1" method="POST">
                    <p><input style="margin-left:400px;" type="text" name="title" placeholder = "標題" /> (二十字以內)</p>
                    <p><input  style="display:none" type="text" name="subject" value = "<?php echo($subject);?>"/></p>
                    <p><input  style="display:none" type="text" name="sub_id" value = "<?php echo($sub_id);?>"/></p>
                    <p><input style="margin-left:400px;" type="text" name="teacher" placeholder = "老師姓名"/></p>
                    
                    <input  style="display:none" type="text" name="sub_type" value = "<?php echo($sub_type);?>"/>
                    <p style="margin-left:430px;" >
                        <label>年份:</label>
                        <select name="year" default = "2019">
                            <option value="2027">2027</option>
                            <option value="2026">2026</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019" selected>2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                            <option value="2015">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                            <option value="2012">2012</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>
                        </select>
                    </p>
                    <p style="margin-left:420px;">
                        第
                        <select name="mid">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="0">final</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        次考試
                    </p>
                    <p><input style="margin-left:455px;" type="submit" name="submit" /></p>
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
include("connect.php");

if(isset($_POST['submit'])){
    //use htmlentities() convert some characters to HTML entities
    $title = htmlentities($_POST['title']);
    $subject = htmlentities($_POST['subject']);
    $sub_id = htmlentities($_POST['sub_id']);
    $sub_type = htmlentities($_POST['sub_type']);
    $teacher = htmlentities($_POST['teacher']);
    $year = htmlentities($_POST['year']);
    $mid = htmlentities((integer)$_POST['mid']);
    $p_time = date("H:i:s");
    $p_date = date("Y-m-d");
    $member = $_SESSION['loginId'];
    
    if (!empty($title) && !empty($subject) && !empty($sub_id)&&!empty($sub_id) ){
        $sql ="INSERT INTO `article` (`title`,`subject`, `sub_id`, `sub_type`, `year`, `mid`, `p_time`, `p_date`, `teacher`,`member`) VALUES ('$title', '$subject', '$sub_id', '$sub_type',  '$year','$mid', '$p_time', '$p_date', '$teacher', '$member');";
        $result = mysqli_query($con, $sql);
        if(!$result){
            echo("can't add".mysqli_error($con));//如果連結失敗輸出錯誤
        }
        else{
            $en = encrypt_url("p_time=$p_time&p_date=$p_date&sub_type=$sub_type",$key_url_md_5);
            echo "<script>document.location.href='upimg.php?$en';</script>";
        }
    }else{
        echo '<script>document.location.href="add_sub.php";</script>';
        echo ('<script> alert("資料尚未填完喔！"); </script>');
    }
}
?>
