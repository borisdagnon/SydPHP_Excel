<?php

session_start();

/*include_once ('../class/autoload.php');*/
include_once('../class/mypdo.class.php');
$errors=array();
$data=array();
$data['result']=array();
$data['success']=false;
$mypdo=new mypdo();

$tmp_destion=$_POST['data'];

$tmp_destion=explode(",", $tmp_destion);


if(move_uploaded_file($tmp_destion[0], $tmp_destion[2])){
	$data['success']=true;
	$data['result']=$tmp_destion[0];
}
else
{
	
	$data['result']=$tmp_destion[1];
}

echo json_encode($data);

?>
