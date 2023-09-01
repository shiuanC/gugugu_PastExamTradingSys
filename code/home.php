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
		<div id="body" class="home">
			<br><br>
			<div>
				<img style="margin-left: 200px;" src="images/bg-home.png" alt="">
			</div>
			<br><br>
			<p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
		</div>
	</div>
</body>
</html>
