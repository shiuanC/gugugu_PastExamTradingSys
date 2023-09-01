<?php
    session_start();
    include("connect.php");
	
	
    //get the image after edited
	$file = file_get_contents($_FILES['data']['tmp_name']);
	//var_dump($_FILES);
	
	//get the id of target image
	$img_id = $_SESSION['img_id'];

	//prepare to upload to MYSQL
	$file = $con->real_escape_string($file);

	$sql = "update image set url = '$file' where id = '$img_id'";
	//$sql = "delete from image where img_id = '123'";
	//$sql = "insert into image (img_id, url, art_id) values ('1', '$file', 'canvas_test')";
	
	//upload & error handler
	if ($con->query($sql)){
		echo "Record updated successfully";
	} else {
		echo "Error updating record: " . $con->error;
	}
?>
