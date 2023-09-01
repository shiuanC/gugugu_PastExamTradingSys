<!DOCTYPE html>
<title>gugugu</title>
<head>
    <link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="css/mobile.css">
	<script src="js/mobile.js" type="text/javascript"></script>
</head>

<style>
body {
  padding: 0;
  margin: 0;
  font-family: "Arial";
}
#container {
    top: 50px;
    width: 500px;
    margin: 0 auto;
    display: block;
    position: relative;
} 
#status-box {
    text-align: right;
    font-size: .6em;
} 
#content {
    width: 125%;
    height: 400px;
    border: 1px solid #cb3362;
    border-radius: 5px;
    background-color: #ffe6ff;
    overflow: auto;
}
#send-box {
    width: 100%;
    text-align: center;
}
#send-box input {
    display: inline-block;
}
input[name="name"] {
    width: 10%;
}
input[name="msg"] {
    width: 30%;
}
input[type="button"] {
    width: 10%;
}
.msg {
    width: 73%;
    display: inline-block;
    padding: 5px 0 5px 10px;
} 
.msg > span {
    width: 50%;
    display: inline-block;
} 
.msg > span::before {
    color: black;
    content: " { ";
}
.msg > span::after {
    color: black;
    content: " } ";
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
                    <h1>聊天室</h1>
                </div>
            </div>
            <div style="margin-left:330px;" id="container">
                <div id="content">
                <?php
                    include("connect.php");
                    $sql = "SELECT * FROM message order by id ASC"; 
                    $query = mysqli_query($con, $sql);
                    echo '<div class="msg">';
                    while($row = mysqli_fetch_array($query)){
                        if($row['msg']!=null){
                            echo '<span style="margin-left:50px;" class="time">'.$row['time'].'</span><strong>'.$row['name'].'</strong>說: ';
                            echo strip_tags($row['msg']);
                            echo '<br><br>';
                        }
                    }
                    echo '</div>';
                ?>
                </div>
            </div>
            <br><br>
            <div id="send-box">
                <form method="post" name = "myform" onsubmit="return CheckPost();">
                    <input type="text" name="msg" id="msg" placeholder="說點什麼？">
                    <input type="submit" name="submit" value="送出">
                </form>
            </div>
        </div>
        <br><br>
        <div id="body" class="home">
            <br><br><br>
            <p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
        </div>
    </div>
</body>

<body>
<?php
include("connect.php");

if(isset($_POST['submit'])){
    $msg = $_POST['msg'];
    $name = $_SESSION['loginId'];

    $sql = "INSERT INTO `message` (id, time, name, msg) VALUES (null, now(), '$name', '$msg')"; 
        $result = mysqli_query($con, $sql);
        if(!$result){
            echo("can't add".mysqli_error($con));//如果連結失敗輸出錯誤
        }
        else{
            echo "<script> window.location.href='chatroom.php'; </script>"; 
        }
    }
    mysqli_close($con);
?>
</body>

</html>
