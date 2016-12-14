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
/*
if(file_exists('../uploads/Tables Syderep_V2.xlsx')) {
	chmod('../uploads/Tables Syderep_V2.xlsx',0755); //Change the file permissions if allowed
	unlink('../uploads/Tables Syderep_V2.xlsx'); //remove the file
	echo 'OK';
}
else {
	echo 'OHH NNO';
}
*/
$tmp_name='';
try{
	var_dump($tmp_destion);
	if(move_uploaded_file(/*$tmp_destion[2]*/$tmp_destion[2],$tmp_destion[5])){
		$data['success']=true;
	
	}
	else
	{
		throw new Exception('Could not move file');
		
	}
}catch(Exception $ex)
{
	var_dump($ex->getMessage());
}


echo json_encode($data);

?>
