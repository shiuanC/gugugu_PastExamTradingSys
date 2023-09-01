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
			session_unset();
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
					<h1>Welcome  to  Gugugu !!!</h1>
				</div>
			</div>
			<div>
				<form method="POST">
					<br><span style="margin-left:350px;">帳號：<input type="text" name="id"></span>
					<br><br>
					<span style="margin-left:350px;">密碼：<input type="password" name="pw"></span>
					<br><br>
					<span style="margin-left:450px;"><input type="submit" value="登入"></span>
					<br><br>
					<span style="margin-left:410px;"><a href="register.php">註冊</a></span><span style="margin-left:25px;"><a href="forget.php">忘記密碼</a></span>
				</form>
			</div>
			<div>
				<?php
				#連上資料庫
				require_once('/home/team10/public_html/config.php');
				$dsn='mysql:host=localhost;dbname=gugugu';
				$dbh=new PDO($dsn,$CFG['mysql_username'],$CFG['mysql_password']);
				#確認帳號密碼是否正確
				$sth=$dbh->prepare('select count(*) as r from users where username = ? and password = ? ;');
				if(isset($_POST['id'])){
					#處理特殊字元
					$x=htmlentities($_POST['id']);
					$y=htmlentities($_POST['pw']);
					$sth->execute(array($x,$y));
					$result=$sth->fetch(PDO::FETCH_ASSOC);
					if($result['r']==1){
						#帳號密碼正確即進入主頁面
						$_SESSION['loginId']=$x;
						echo '<script> window.location.href=\'home.php\'</script>';
					}else{
						#帳號密碼錯誤即跳出提示
						$_SESSION['loginId']='';
						echo '<script> alert(\'ID or Password Error !\') </script>';
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

