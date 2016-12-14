<?php
include_once 'class/autoload.php';
session_start();

$controleur=null;
$site=null;


$controleur=new upload();
$site=new page_base('Page Export');

$site->__set('corps', $controleur->export());

$site->afficher();
?>
<!--
<<script type="text/javascript">

setTimeout("location.reload(true);", 9000);

</script>//-->

<?php 