<!doctype html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GUGUGU 考古題交換系統</title>
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
				echo "<br><span style='font-size:16px; font-family: Comic Sans MS; margin-left:50px'>歡迎，".$_SESSION['loginId']." !!!</span>";
				#登出帳號回登入頁
				echo "<span style='font-size:16px; font-family: Comic Sans MS; margin-left:1000px;'>"."<a href='index.php'>"."登出"."</a></span>";
				echo "<br>";
			?>
		</p>
		<div id="header">
			<div>
                <a href="home.php" class="logo"><img src="images/logo.png" alt=""></a>
                <ul id="navigation">
                    <li class="menu">
                        <a href="home.php">Home</a>
                    </li>
                    <li class="menu">
                        <a href="about.php">About</a>
                    </li>
					<li class="selected">
                        <a href="contact.php">Contact</a>
                    </li>
                </ul>`
            </div>
        </div>
		<div id="body">
            <div class="header">
                <div>
                    <h1>聯絡我們</h1>
                </div>
            </div>
                <div>
					<table >
						
						<tr>
							<td>數學17 白雨晴：</td>
							<td></td>
						</tr>
						<tr>
							<td>資工21 莊孝萱：</td>
							<td></td>
						</tr>
						<tr>
							<td>資工21 李卓庭：</td>
							<td></td>
							
						</tr>
						<tr>
							<td>資工21 賴彥安：</td>
							<td></td>
						</tr>
					</table>
                </div>
				
            </div>
        </div>
        <div id="body" class="home">
            <div class="footer">
				<div>
					<ul>
						<li>
							<a href="required.php" class="product"></a>
							<h1>必修</h1>
						</li>
						<li>
							<a href="elective.php" class="about"></a>
							<h1>選修</h1>
						</li>
						<li>
							<a href="general.php" class="flavor"></a>
							<h1>通識</h1>
						</li>
						<li>
							<a href="chatroom.php" class="contact" target="chat"></a>
							<h1>聊天室</h1>
						</li>
					</ul>
				</div>
			</div>
			<br><br><br>
			<div id="footer">
				<div>
					<p>&copy; 2023 Freeeze. All Rights Reserved.</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
