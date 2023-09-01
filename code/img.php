<?php
    session_start();
    include("connect.php");

    $sql ="SELECT * FROM image WHERE name = 'cywang'";
   
   // $ret = $con->query($sql);
    $ret = mysqli_query($con,$sql);
    while($row=mysqli_fetch_array($ret)){
        $name = $row['name'];
        $img = $row['url'];
        echo($name);
        echo '<img src="data:image/jpeg;base64,'.base64_encode( $img).'"/>';
    }
?>