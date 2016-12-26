<?php

include_once 'class/autoload.php';


session_start();

$controleur=null;
$site=null;


$controleur=new upload();
$site=new page_base('Page Questions');

$site->__set('corps', $controleur->question());

$site->afficher();
?>


<?php 