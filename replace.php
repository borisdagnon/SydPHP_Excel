<?php

include_once 'class/autoload.php';


session_start();

$controleur=null;
$site=null;


$controleur=new upload();
$site=new page_base('Remplacer Fichier');

$site->__set('corps', $controleur->replace());

$site->afficher();
?>


<?php 