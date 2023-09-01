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
						/*session_start();
						#管理者頁面
						if($_SESSION['loginId']=='aaa'){
							echo '<a href="admin.php" target="_blank">管理者頁面</a>';
						}*/
						?>
					</li>
				</ul>
			</div>
		</div>
		<div id="body">
			<div class="header">
				<div>
					<h1>忘記密碼了 ???</h1>
				</div>
			</div>
			<div>
				<form method="POST">
					<br><span style="margin-left:350px;">帳號：<input type="text" name="id"></span>
					<br><br>
					<span style="margin-left:250px;">請輸入你印象最深刻的單詞：<input type="text" name="fg"></span>
					<br><br>
					<span style="margin-left:350px;">新密碼：<input type="password" name="pw"></span>
					<br><br>
					<span style="margin-left:450px;"><input type="submit" value="送出"></span>
				</form>
			</div>
			<div>
				<?php
					#連上資料庫
					require_once('/home/team10/public_html/config.php');
					$dsn='mysql:host=localhost;dbname=gugugu';
					$dbh=new PDO($dsn,$CFG['mysql_username'],$CFG['mysql_password']);
					if(isset($_POST['id'])){
						#確認帳號和忘記密碼內容是否正確
						$sth=$dbh->prepare('select count(*) as r from users where username = ? and forget = ? ;');
						#處理特殊字元
						$x=htmlentities($_POST['id']);
						$y=htmlentities($_POST['fg']);
						$z=htmlentities($_POST['pw']);
						$sth->execute(array($x,$y));
						$result=$sth->fetch(PDO::FETCH_ASSOC);
						if($result['r']==1){
							#如果帳號和忘記密碼內容正確則修改密碼
							$sth2=$dbh->prepare('update users set `password` = ? where `username` = ? ;');
							$sth2->execute(array($z,$x));
							echo '<script> alert("密碼修改成功 !!!") </script>';
							#在資料庫搜尋使用者註冊時所填寫的email
							$sth3=$dbh->prepare('select mail from users where username = ? ;');
							$sth3->execute(array($x));
							$result3=$sth3->fetch(PDO::FETCH_ASSOC);
							#寄通知信告知使用者密碼已變更
							mail($result3['mail'],"密碼變更提醒","密碼已變更");
							echo '<script> window.location.href=\'home.php\'</script>';
						}else{
							#如果帳號和忘記密碼內容錯誤則提示錯誤
							echo '輸入錯誤';
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