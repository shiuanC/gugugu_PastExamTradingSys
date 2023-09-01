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
					<h1>會員專區</h1>
				</div>
			</div>
			<div>
				<?php
					echo "<h3 style='text-align:center;'>使用者名稱：".$_SESSION['loginId'].'</h3>';
					#連上資料庫
					require_once('/home/team10/public_html/config.php');
					$dsn='mysql:host=localhost;dbname=gugugu';
					$dbh=new PDO($dsn,$CFG['mysql_username'],$CFG['mysql_password']);
					#搜尋使用者相關資料
					$sth=$dbh->prepare('select points,gunum,gugugu from users where username = ? ;');
					$sth->execute(array($_SESSION['loginId']));
					$result=$sth->fetch(PDO::FETCH_ASSOC);
					#印出使用者積分和現有考古題
					echo "<div class='table'>";
					echo "<h3 style='text-align:center;'>現有積分：".$result['points'].'</h3><br>';
					echo "<h3 style='text-align:center;'><現有考古題></h3>";
					#將gugugu欄位的json格式轉換為陣列
					$obj = json_decode($result['gugugu']);
					for($i=1;$i<=$result['gunum'];$i++){
						#依據獲取的考古題id去搜尋對應的考古題名稱與所屬科目
						$sth2=$dbh->prepare('select title,subject from article where id = ? ;');
						$sth2->execute(array($obj->{$i}));
						$result2=$sth2->fetch(PDO::FETCH_ASSOC);
						#列出考古題名稱與科目，並且在點擊考古題名稱時，可以連結到對應頁面
						echo "<h4 style='text-align:center;'><a href='article.php?id=".$obj->{$i}."'>".$result2['title'].'</a>'."，"."所屬科目：".$result2['subject'].'</h4>';
					}
					#新增JSON格式的內容並印出（測試用）
					#$obj->{$i} = "qqq";
					#$myJSON = json_encode($obj);
					#echo $myJSON;
					
					#修改密碼與回主頁面
					echo "</div>";
					echo "<h3 style='text-align:center;'><a href='change.php'>修改密碼</a></h3>";
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

