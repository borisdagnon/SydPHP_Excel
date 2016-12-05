<?php
include_once 'class/autoload.php';
session_start();

$controleur=null;
$site=null;


$controleur=new controleur();
$site=new page_base('Page MAJ');

$site->__set('corps', $controleur->maj());

$site->afficher();
?>


<?php 