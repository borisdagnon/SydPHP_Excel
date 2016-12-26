<?php

include_once 'class/autoload.php';


session_start();

$controleur=null;
$site=null;


$controleur=new upload();
$site=new page_base('Comparaison Centres VHU');

$site->__set('corps', $controleur->VHU());

$site->afficher();
?>


<?php 