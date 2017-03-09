<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'class/autoload.php';
session_start();

$controleur=null;
$site=null;


$controleur=new upload();
$site=new page_base('Page Export');

$site->__set('corps', $controleur->export_VHU());

$site->afficher();

?>
