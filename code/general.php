<!doctype html>
<!-- Website template by freewebsitetemplates.com -->
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>gugugu</title>
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
                    <h1>通識</h1>
            
                </div>
            </div>
                <div>
                    <?php
                        #連上資料庫
						require_once('/home/team10/public_html/config.php');
						$dsn='mysql:host=localhost;dbname=gugugu';
						$dbh=new PDO($dsn,$CFG['mysql_username'],$CFG['mysql_password']);
						#搜尋所有科目
						$sth4=$dbh->prepare('select subject,sub_id from article;');
						$sth4->execute();
						while($result4=$sth4->fetch(PDO::FETCH_ASSOC)){
							#將所有科目的count預設為0
							$x=(string)$result4['sub_id'];
							$count[$x] = 0;
						}
						
						#搜尋type為2（通識）的科目
						$sth3=$dbh->prepare('select subject,sub_id from article where sub_type= 2 ;');
						$sth3->execute();
						#當科目的count為0時，將type為2（通識）的科目印出，並將印出科目的count設為1
						while($result3=$sth3->fetch(PDO::FETCH_ASSOC)){
							$x=(string)$result3['sub_id'];
							if($count[$x] == 0){
								$sub_id = $result3['sub_id'];
								$sub_id_en = encrypt_url("sub_id=$sub_id",$key_url_md_5);
								if($count[$x] == 0){
									echo "<h3 style='text-align:center;'><a href='art_list.php?".$sub_id_en."'>".$result3['subject'].'</a></h3>'.'<br>';
									$count[$x]=1;
								}
							
							}
						}
                    ?>
                </div>
				<div>
                    <span style="margin-left:450px;"><button onclick="location.href='add.php'">新增科目</button></span>
                </div>
            </div>
        </div>
        <div id="body" class="home">
			<br><br><br>
			<p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
        </div>
	</div>
</body>
</html>
