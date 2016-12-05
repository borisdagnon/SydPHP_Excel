<?php

include_once 'class/autoload.php';


session_start();

$controleur=null;
$site=null;


$controleur=new controleur();
$site=new page_base('Page Consulation');

$site->__set('corps', $controleur->consultation());

$site->afficher();
?>


<?php 