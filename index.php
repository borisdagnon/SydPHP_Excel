<?php
include_once 'class/autoload.php';
session_start();

$controleur=null;
$site=null;


if(isset($_SESSION['type']) && isset($_SESSION['id']))
{
	
}else 
{
	$controleur=new controleur();
	$site=new page_base('Home');
	
	$site->__set('corps', $controleur->acceuil());

}
$site->afficher();
?>
<script>

    setTimeout("location.reload(true);", 9000);


</script>
<?php 