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
<body>
	<div id="page">
		<p>
			<?php
				session_start();
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
				</ul>
			</div>
		</div>
		<div id="body">
			<div class="header">
				<div>
					<h1>Sign Up For Gugugu !!!</h1>
				</div>
			</div>
			<div>
				<form method="POST">
					<br><span style="margin-left:350px;">帳號：<input type="text" name="id"></span>
					<br><br>
					<span style="margin-left:350px;">密碼：<input type="password" name="pw"></span>
					<br><br>
					<span style="margin-left:350px;">信箱：<input type="text" name="mail"></span>
					<br><br>
					<span style="margin-left:200px;">請輸入最讓你印象深刻的一個單詞(找回密碼用)：<input type="text" name="fg"></span>
					<br><br><br>
					<span style="margin-left:450px;"><input type="submit" value="註冊"></span>
				</form>
			</div>
			<div>
				<?php
				#連上資料庫
				require_once('/home/team10/public_html/config.php');
				$dsn='mysql:host=localhost;dbname=gugugu';
				$dbh=new PDO($dsn,$CFG['mysql_username'],$CFG['mysql_password']);
				#確認帳號是否存在
				$sth=$dbh->prepare('select count(*) as r from users where username = ?  ;');
				if(isset($_POST['id'])){
				#處理特殊字元
				$x=htmlentities($_POST['id']);
				$y=htmlentities($_POST['pw']);
				$z=htmlentities($_POST['fg']);
				$m=htmlentities($_POST['mail']);
				$sth->execute(array($x));
				$result=$sth->fetch(PDO::FETCH_ASSOC);
				if($result['r']==1){
					#帳號存在則顯示提示
					echo '<script>alert("帳號已存在")</script>';
				}else{
					#帳號不存在則新增帳號，並提示註冊成功
					$sth2=$dbh->prepare('INSERT INTO users (username,password,points,forget,gunum,mail) VALUES (?,?,30,?,0,?) ;');
					$sth2->execute(array($x,$y,$z,$m));
					echo '<script> alert(\'註冊成功\') </script>';
					echo '<script> window.location.href=\'index.php\'</script>';

				}
				}	
				?>
			</div>
		</div>
		<div id="body" class="home">
			<br><br><br>
			<p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
		</div>
	</div>
</body>
</html>




