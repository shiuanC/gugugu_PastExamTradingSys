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
    <!--enable JQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</head>
		
<!--css-->
<style>
    html{
        width:100%;
        height:100%;
    }
    .container{
        margin: 10px;
        display:flex;
        justify-content: center;
    }
    #myCanvas{
        margin-right: 5px;
        border:1px solid rgb(10,10,150);
    }
    #target{
        display:none;
    }
    #color{
        width:100px;
        height:20px;
    }
    input{
        margin: 5px;
        cursor: pointer;
    }
    select{
        margin: 5px;
    }
    #text{
        cursor:text;
    }
    #form{
        display:none;
    }
</style>

<body>
    <div id="page">
        <p>
            <?php
                session_start();
                include("connect.php");
                $img_id= $_GET['img_id'];
                $_SESSION['img_id'] = $img_id;

                //get the target image
                $sql = "SELECT * FROM image WHERE id= '$img_id' ;";
                $img = '';
                $img_name = '';

                //encode base64 data
                $ret = mysqli_query($con,$sql);
                if(!$ret){
                    echo ("Error: ".mysqli_error($con));
                    exit();
                }
                while($row=mysqli_fetch_array($ret)){
                    $img = "data:image/jpeg;base64,".base64_encode($row['url']);
                    $img_name = $row['art_id'];
                    $_GET['img_id'] = $row['id'];
                    //echo '<img src="data:image/jpeg;base64,'.base64_encode($img).'"/>';
                }
            ?>	
            <?php
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
                    <h1>編輯題目</h1>
                </div>
            </div>

            <!--my image-->
            <img crossorigin="Anonymous" id='target' src='<?php echo $img ?>' alt='paper'>

            <!--canvas and tools-->
            <div class='container'>
                <canvas id="myCanvas" width='1000px' height='1000px'></canvas>
                <div  style="margin-left: 50px;" id='tools'>
                    <h3>painter:</h3>
                    <input id='color' type="color"><br>
                    <input id='undo' type="button" value='undo'>
                    <input id='redo' type="button" value='redo'>
                    <input id='reset' type="button" value='reset'><br>
                    <input id='eraser' type="button" value='eraser'>
                    <input id='brush' type="button" value='brush' style='color:red'><br>
                    <h3>text input:</h3>
                    <select id='font_size'>
                        <option value='12'>12</option>
                        <option value='14'>14</option>
                        <option value='16'>16</option>
                        <option value='20'>20</option>
                        <option value='30'>30</option>
                    </select>
                    <select id='font_family'>
                        <option value='Arial' style='font-family: Arial, sans-serif'>Arial</option>
                        <option value='Times New Roman' style="font-family: Times New Roman">Times New Roman</option>
                        <option value='Lucida Console' style="font-family:Lucida Console">Lucida Console</option>
                        <option value='verdana' style="font-family:verdana">verdana</option>
                        <option value='Courier New' style="font-family: Courier New">Courier New</option>
                    </select>
                    <input id='text' type="text">
                    <input id='write' type="submit" value='write'><br>
                    <h3>save:</h3>
                    <a id='save'>
                        <input type="button" id='savebutton' value="save">
                    </a>
                </div>
            </div>

            <script>
                //init canvas
                var canvas = document.getElementById("myCanvas");
                var ctx = canvas.getContext("2d");

                var img, maxwidth, maxheight;

                //draw the document we want to edit
                img = document.getElementById("target");
                
                window.onload = function(){
                    maxwidth = img.width;
                    maxheight = img.height;
                    //if the image is too big, resize it
                    if(maxwidth>1000){
                        maxheight*=(1000/maxwidth);
                        maxwidth = 1000;
                    }
                    canvas.setAttribute('width', maxwidth + 'px');
                    canvas.setAttribute('height', maxheight + 'px');
                    ctx.drawImage(img,0,0,maxwidth,maxheight);
                    //prepare for undo()
                    cPush();
                };

                //vars we need for painter
                var tool = 'brush';
                var clickX = [];
                var clickY = [];
                var clickDrag = [];
                var clickcolor = [];
                var paint;

                //color select
                var colors = document.getElementById('color');

                //reset
                document.getElementById('reset').addEventListener('click', function(){
                    ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                    while(clickX.length!=0) clickX.pop();
                    while(clickY.length!=0) clickY.pop();
                    while(clickDrag.length!=0) clickDrag.pop();
                    while(clickcolor.length!=0) clickcolor.pop();
                    ctx.drawImage(img,0,0,maxwidth,maxheight);
                    cPush();
                });

                //brush
                var brush = document.getElementById('brush');
                brush.addEventListener("click", function(){
                    tool = "brush";
                    //the tool which is selected will be marked red
                    brush.style.color = 'red';
                    eraser.style.color = '';
                    write.style.color = '';
                });

                //eraser
                var eraser = document.getElementById('eraser');
                eraser.addEventListener("click", function(){
                    tool = "eraser";
                    brush.style.color = '';
                    eraser.style.color = 'red';
                    write.style.color = '';
                });

                //save
                var save = document.getElementById('save');
                
                save.addEventListener('click', function(){
                    //create a file
                    var formdata = new FormData();
                    canvas.toBlob(function(blob){
                        //console.log(blob);
                        //append image to the file
                        formdata.append("name", 'image');
                        formdata.append("data", blob);
                        
                        //upload to the server
                        $.ajax({
                            type: 'POST',
                            url: 'canvas_update.php',
                            data: formdata,
                            processData: false,
                            contentType: false
                        }).done(function(data) {
                            console.log(data);
                        }).fail(function(){
                            alert('oops! something wrong!');
                        });
                    });
                });
                //undo
                var undo = document.getElementById('undo');
                undo.addEventListener("click", function(){
                    cUndo();
                });

                //redo
                var redo = document.getElementById('redo');
                redo.addEventListener("click", function(){
                    cRedo();
                });

                //text
                var write = document.getElementById('write');
                var font_family = document.getElementById('font_family');
                var font_size = document.getElementById('font_size');
                write.addEventListener("click", function(){
                    tool = 'text';

                    brush.style.color = '';
                    eraser.style.color = '';
                    write.style.color = 'red';
                });

                //when mousedown, start drawing
                canvas.addEventListener('mousedown', function(e){
                    var mouseX = e.pageX - this.offsetLeft;
                    var mouseY = e.pageY - this.offsetTop;
                    
                    switch(tool){
                        case 'brush':
                            paint = true;
                            addClick(mouseX, mouseY);
                            redraw();
                        break;
                        case 'text':
                            ctx.font = font_size.value + 'px ' + font_family.value;
                            ctx.fillStyle = colors.value;
                            ctx.fillText(text.value, mouseX, mouseY);
                        break;
                        default:
                            paint = true;
                            addClick(mouseX, mouseY);
                            redraw();
                        break;
                    }
                });

                //keep the position through the path and update the canvas
                canvas.addEventListener('mousemove', function(e){
                    if(paint){
                        addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
                        redraw();
                    }
                });

                //stop drawing
                canvas.addEventListener('mouseup', function(e){
                    paint = false;
                    cPush();
                });

                //when the mouse leave the canvas, stop drawing
                canvas.addEventListener('mouseleave', function(e){ paint = false;});

                //save the position we need to draw/erase
                function addClick(x, y, dragging)
                {
                    clickX.push(x);
                    clickY.push(y);
                    clickDrag.push(dragging);
                    if(tool == "eraser") clickcolor.push('');
                    else clickcolor.push(colors.value);
                };

                //update the canvas
                function redraw(){

                    ctx.lineJoin = "round";
                    ctx.lineWidth = 1;
                    
                    for(var i=0; i < clickX.length; i++) {
                        //erase everything except our background image on this position
                        if(clickcolor[i]==''){
                            ctx.clearRect(clickX[i], clickY[i], 10, 10);
                            ctx.drawImage(img, clickX[i], clickY[i], 10, 10, clickX[i], clickY[i], 10, 10);
                        }
                        //draw the line on the position we just pushed into clickX and clickY
                        else{
                            ctx.beginPath();
                            if(clickDrag[i] && i){
                                ctx.moveTo(clickX[i-1], clickY[i-1]);
                            }else{
                                ctx.moveTo(clickX[i]-1, clickY[i]);
                            }
                            ctx.lineTo(clickX[i], clickY[i]);
                            ctx.strokeStyle = clickcolor[i];
                            ctx.closePath();
                            ctx.stroke();
                        }
                    }
                };

                //when the content in the canvas changed, push the status then into this array
                var cPushArray = [];
                //this variable help us to now if we can undo() or redo()
                var cStep = -1;

                //save the current canvas by toDataUrl() in order to inplement undo() and redo()
                function cPush(){
                    cStep++;
                    if (cStep < cPushArray.length) { cPushArray.length = cStep;}
                    cPushArray.push(canvas.toDataURL());
                };

                //if previous step exists, undo()
                function cUndo(){
                    if (cStep > 0) {
                        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

                        cStep--;
                        
                        var canvasPic = new Image();
                        canvasPic.src = cPushArray[cStep];
                        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0);}
                        while(clickX.length!=0) clickX.pop();
                        while(clickY.length!=0) clickY.pop();
                        while(clickDrag.length!=0) clickDrag.pop();
                        while(clickcolor.length!=0) clickcolor.pop();
                    }
                };

                //if next step exists, redo()
                function cRedo(){
                    if (cStep < cPushArray.length-1) {
                        cStep++;
                        var canvasPic = new Image();
                        canvasPic.src = cPushArray[cStep];
                        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
                    }
                };
            </script>
        </div>
        <div id="body" class="home">
			    <br><br><br>
			    <p style="text-align:center;">&copy; 2019 Gugugu by us.</p>
        </div>
	</div>
</body>
</html>