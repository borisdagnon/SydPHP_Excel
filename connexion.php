<?php
include_once 'class/autoload.php';
session_start();

$controleur=null;
$site=null;


	$controleur=new controleur();
	$site=new page_base('Page Connexion');

	$site->__set('corps', $controleur->connexion());

$site->afficher();
?>


<?php 