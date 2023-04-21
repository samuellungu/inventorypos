<?php

include_once 'connectdb.php';

if(session_status()!==PHP_SESSION_ACTIVE){
	
	session_start();
}

if($_SESSION['email']=='' OR $_SESSION['role']=='User'){
	header('location:index.php');
	
}


$id = $_POST['pidd'];

$sql = "delete from tbl_product where pid=$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
	
	
	
}else{
	
	echo 'Error in Deleting The Record';
}

?>