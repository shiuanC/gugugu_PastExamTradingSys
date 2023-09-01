<!doctype html>
<!-- Website template by freewebsitetemplates.com -->
<!-- CSS, html by李卓庭 php, html by莊孝萱 -->
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gugugu</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/mobile.css">
    <script src="js/mobile.js" type="text/javascript"></script>
</head>

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    td, th {
        border: 1px solid black;
        text-align: left;
        padding: 8px;
    }
    tr:nth-child(even) {
        background-color: #f3e6ff;
    }
</style>
    
<body>
    <div id="page">
        <p>
            <?php
                session_start();
                require("connect.php");
                require("encoder.php");
                $user_name = $_SESSION['loginId'];
                $en = $_SERVER['QUERY_STRING'];
                $de = geturl($en,$key_url_md_5);//將加密的GET網址解密
                //解密後會獲得array
                $sub_id= $de['sub_id'];

                //get the data of user
                $sql_user = "SELECT * FROM users WHERE username = '$user_name'";
                $ret_user = mysqli_query($con, $sql_user);
                $USER = mysqli_fetch_array($ret_user);
                $gu = $USER['gugugu'];//取得紀錄user擁有考古的JSON檔
                $gunum = $USER['gunum'];//已有的考古數量
                $gu_json = json_decode($gu);//將紀錄考古的欄位轉換成json

                //check if the json file:"gugugu" record this data
                function check_gu($obj, $gunum, $art_id){
                    for($i=1;$i<=$gunum;$i++){
                        if($obj->{$i}==$art_id) {
                            return true;
                            break;
                        }
                    }
                    return false;
                }

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
        <div id = "body">
            <div class="header">
                <div>
                    <h1>題目列表</h1>
                </div>
            </div>
            <div>
                <br><br>
                <table>
                    <tr>
                        <th>科目代碼</th>
                        <th>標題</th>
                        <th>提供者</th>
                        <th>上傳時間</th>
                        <th>備註</th>
                    </tr>
                    <?php
                        $sql ="SELECT * from article WHERE sub_id='$sub_id';";
                        $ret = mysqli_query($con, $sql);
                        while($row = mysqli_fetch_array($ret))
                        {
                            $title = $row["title"];//文章標題
                            $sub = $row["sub_id"];//科目編號
                            $p_time = $row["p_time"];//上傳時間
                            $p_date = $row["p_date"];//上傳日期
                            $member = $row["member"];//上傳者
                            $today = date("Y-m-d");//今天的日期
                            $sql_fid = "SELECT id FROM article WHERE p_time='$p_time' AND p_date='$p_date' AND member='$member'";
                            $ret_fid = mysqli_query($con, $sql_fid);//取得文章資料
                            $rowfid  = mysqli_fetch_array($ret_fid);
                            $art_id = $row['id'];
                            echo"<tr><td>";
                            echo $sub;
                            echo"</td> <td>";
                            echo $title;
                            echo"</td><td>";
                            echo $member;
                            echo"</td><td>";
                            //time
                            //假設是今天上傳的只會顯示時間不會顯示日期
                            if($p_date == $today)
                                echo $p_time;
                            else 
                                echo $p_date."--".$p_time;
                            echo"</td><td>";
                            
                            if(check_gu($gu_json, $gunum, $art_id)){
                                $en = encrypt_url("id=$art_id",$key_url_md_5);
                                echo"<a href = 'article.php?$en'><strong>進入討論</strong></a>";
                            }
                            else{
                                $en = encrypt_url("id=$art_id",$key_url_md_5);
                                echo"<a href = 'before_confirm.php?$en'><strong>得到此份考古題<strong></a>";
                            }       
                            echo "</td></tr>";
                        }
                    ?>
                </table>
            </div>
            <div>
                <?php
                $en = encrypt_url("sub_id=$sub_id",$key_url_md_5);
                ?>
                <span style="margin-left:450px;"><button onclick="location.href='add_sub.php?'+'<?php echo($en)?>'">提供題目</button></span>
            </div>
        </div>
        <div id="body" class="home">
		    <br><br><br>
		    <p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
		</div>
    </div>
</body>
</html>