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
	div.table{
		border: 1px solid #990073;
        background-color: #f3e6ff;
        width: 40%;
        margin: auto;
	}
</style>

<body>
    <div id = "page">
        <p>
            <?php 
                session_start();
                require("connect.php");
                require("encoder.php");
                $user_name = $_SESSION['loginId'];
                
				
                
                #沒有已註冊帳號進主頁面跳回登入頁
                if(!(isset($user_name))){
                    echo '<script> window.location.href=\'index.php\'</script>';
                }
                #無帳號進主頁面跳回登入頁
                if($user_name==''){
                    echo '<script> window.location.href=\'index.php\'</script>';
                }
                echo "<span style='font-size:16px; font-family: Comic Sans MS; margin-left:50px'>歡迎，".$user_name." !!!</span>";
                #登出帳號回登入頁
                echo "<span style='font-size:16px; font-family: Comic Sans MS; margin-left:900px;'><a href='member.php'>會員專區</a></span><span style='margin-left:20px;'><a href='index.php'>登出</a></span>";
                echo "<br>";

                $en = $_SERVER['QUERY_STRING'];
                $de = geturl($en,$key_url_md_5);
                $art_id = $de['id'];
                $cost = $de['cost'];

                //get the data of user
                $sql_user = "SELECT * FROM users WHERE username = '$user_name'";
                $ret_user = mysqli_query($con, $sql_user);
                $USER = mysqli_fetch_array($ret_user);
                $gunum = $USER['gunum'];
                $pts = $USER['points'];
                

                //get the data of article
                $sql_a = "SELECT * FROM article WHERE id = '$art_id'";
                $ret_a = mysqli_query($con, $sql_a);
                $ARTI = mysqli_fetch_array($ret_a);
                $sub_type = $ARTI['sub_type'];
                $sub_id = $ARTI['sub_id'];

                //將要存為GET的部分先加密
                $sub_en = encrypt_url("sub_id=$sub_id",$key_url_md_5);
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
                        if($user_name=='aaa'){
                            echo '<a href="admin.php" target="_blank">管理者頁面</a>';
                        }
                        
                        ?>
                    </li>
				</ul>
			</div>
        </div>
        <br><br>
        <div class="table">
            <form id='confirm box' action="check.php" method="POST">
                <h3 style="text-align:center;">確定得到此份考古嗎？</h3>
                <h3 style="text-align:center;">將使用<?php echo($cost); ?>點積分</h3>
                <span><input type="text" name='art_id' id='art_id' style="display:none"></span><br>
                <span><input type="text" name='gunum' id='gunum' style="display:none"></span><br>
                <span><input type="text" name='pts' id='pts' style="display:none"></span><br><br>
                <span><input style="margin-left: 200px;" type="button" value='取消' onclick="location.href='art_list.php?'+'<?php echo($sub_en)?>'">
                <input style="margin-left: 20px;"type="submit" value='確定' name="submit" /></span>
            </form>
            <br><br>
        </div>
		<div id="body" class="home">
			<br><br><br>
			<p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
        </div>
    </div>
</body>
</html>


<script type="text/javascript" >
    /*因為php在js之前產生
    不能在js跑php的function
    try:用js 運行
    新增文章進user的資料 && 記錄他的幾分
    將js這裡取得的值給下一個php檔：「check.php」用*/
    var art_id="<?php echo($art_id);?>";
    var gunum = <?php echo($gunum);?>;
    var pts = "<?php echo($pts)?>";
    gunum+=1;
    pts-=<?php echo($cost); ?>;
    
    document.getElementById("gunum").value = gunum;
    document.getElementById("pts").value = pts;
    document.getElementById("art_id").value = <?php echo($art_id);?>;
</script>

