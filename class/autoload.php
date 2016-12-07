<?php
function __autoload($class_name)
{
	$ret=false;
	if(file_exists('class/'.$class_name.'.class.php'))
	{
		require_once ('class/'.$class_name.'.class.php');
		$ret=true;
	}
	return $ret;
}
?>