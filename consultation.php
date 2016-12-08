<?php

include_once '/class/controleur.class.php';
include_once '/class/mypdo.class.php';
include_once '/class/page_base.class.php';
require_once '/class/PHPExcel/IOFactory.php';
session_start();

$controleur=null;
$site=null;


$controleur=new controleur();
$site=new page_base('Page Consulation');

$site->__set('corps', $controleur->consultation());

$site->afficher();
?>


<?php 