<?php

include_once 'class/autoload.php';


session_start();

$controleur=null;
$site=null;


$controleur=new upload();
$site=new page_base('Page Consulation');

$site->__set('corps', $controleur->upload());

$site->afficher();
?>


<?php 