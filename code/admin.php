<!doctype html>
<!-- Website template by freewebsitetemplates.com -->
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
	}
</style>

<body>
    <div id="page">
        <p>
            <?php 
				session_start();
				if($_SESSION['loginId']!='aaa'){
					echo '<script> window.location.href=\'index.php\'</script>';
				}
                require("connect.php");
                #沒有已註冊帳號進主頁面跳回登入頁
                if(!(isset($_SESSION['loginId']))){
                    echo '<script> window.location.href=\'index.php\'</script>';
                }
                #無帳號進主頁面跳回登入頁
                if($_SESSION['loginId']==''){
                    echo '<script> window.location.href=\'index.php\'</script>';
                }
                echo "<span style='font-size:16px; font-family: Comic Sans MS; margin-left:50px'>歡迎，管理員".$_SESSION['loginId']." !!!</span>";
                #登出帳號回登入頁
                echo "<span style='font-size:16px; font-family: Comic Sans MS; margin-left:900px;'><a href='member.php'>會員專區</a></span><span style='margin-left:20px;'><a href='index.php'>登出</a></span>";
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
                    <h1>管理員頁面</h1>
                </div>
            </div>
			<div>
				<h3 style="text-align: center;">修改資料</h3>
				<form method="POST">
					<h4 style="text-align: center;">文章編號(id)：<input type="text" name="id"></h4>
					<h4 style="text-align: center;">文章標題(title)：<input type="text" name="title"></h4>
					<h4 style="text-align: center;">科目(subject)：<input type="text" name="subject"></h4>
					<h4 style="text-align: center;">科目編號(sub_id)：<input type="text" name="sub_id"></h4>
					<h4 style="text-align: center;">科目類別(sub_type)：<input type="text" name="sub_type"> (0:必修, 1:選修, 2:通識)</h4>
					<h4 style="text-align: center;">年份(year)：<input type="text" name="year"></h4>
					<h4 style="text-align: center;">第幾次期中(mid)：<input type="text" name="mid"></h4>
					<h4 style="text-align: center;">備註(note)：<input type="text" name="context"></h4>
					<h4 style="text-align: center;"><input type="submit" value="送出"></h4>
				</form>
				
			</div>
			<div>
				<?php
						#連上資料庫
						require_once('/home/team10/public_html/config.php');
						$dsn='mysql:host=localhost;dbname=gugugu';
						$dbh=new PDO($dsn,$CFG['mysql_username'],$CFG['mysql_password']);
						#印出article內容
						$sth=$dbh->prepare('select * from article;');
						$sth->execute(array());
						$result=$sth->fetchAll(PDO::FETCH_ASSOC);
						
						foreach($result as $result)
						{
							echo '<div class="table">';
							foreach($result as $key => $value)
							{
								echo "<p style='text-align: center;'>".$key." : ".$value."</p>";
							}
							echo '</div><br><br>';
						}
						#根據前面表單輸入資料修改資料庫內容
						$sth=$dbh->prepare('update article set title=?,subject=?,sub_id=?,sub_type=?,year=?,mid=?,context=? where id = ? ;');
						if(isset($_POST['id'])){
							$sth->execute(array($_POST['title'],$_POST['subject'],$_POST['sub_id'],$_POST['sub_type'],$_POST['year'],$_POST['mid'],$_POST['context'],$_POST['id']));
						}	

					?>
				</table>
			</div>
		</div>
		<div id="body" class="home">
			<br><br><br>
			<p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
		</div>
		
    </div>
</body>
</html>
