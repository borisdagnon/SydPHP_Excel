<?php

class page_base {
	protected  $titre;
	protected $menu;
	protected $corps;
	
	
	function __construct($t) {
		$this->titre=$t;
	}
	
	function __get($prop){
		return $this->corps;
	}
	function __set($prop,$val){
		switch ($prop){
			case 'titre': $this->titre=$val;
			break;
			
			case 'menu':$this->menu=$val;
			break;
			
			case 'corps':$this->corps=$val;
			break;
			
		}
		
	}
	
	public function menu()
	{
		echo'
				<div id="menu">
<dl>
	<a href="index.php" ><dt>Accueil</dt></a>
		<dd>
			<ul>
				
				<li><a href="">Questions</a></li>
				
			</ul>
				
		</dd>
</dl>
				
				<dl>
	<dt>Consulter fichier Excel</dt>
		<dd>
			<ul>
				
				<li><a href="consultation.php">Consulter</a></li>
				
			</ul>
				
		</dd>
</dl>
				
				<dl>
	<dt>Modifier fichier Excel</dt>
		<dd>
			<ul>
				
				<li><a href="maj.php">MAJ<a/></li>
				
			</ul>
				
		</dd>
</dl>
				
		</div>
				
				
				';
	}
	
	public function header()
	{
		echo 'Mise à jour du fichier Excel';
	}
	
	
	public function link() {
		echo '
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
				<link rel="stylesheet" type="text/css" href="./css/style.css">
				';
	}
	
	public function script()
	{
		echo '
				<script
			  src="https://code.jquery.com/jquery-3.1.1.min.js"
			  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
			  crossorigin="anonymous"></script>
				<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"> </script>
				
				
				';
	}
	public function footer()
	{
		echo 'Projet SydPHP_Excel';
	}
	
	public function afficher()
	{
		
	  ?>
		<!doctype html>
		<html lang="fr">
		<head>
		<meta charset="utf-8">
		<title><?php echo $this->titre;?></title>
		<?php echo $this->script();?>
		<?php echo $this->link();?>
		
		</head>
		
		<div class="container">
		
		<body>
		
		<div class="row" >
		<a href="./connexion.php" class="coul_connect">
		<div class="col-md-2 col-md-push-8" id="connect">
		<p>Connexion<p>
		</div>
		</a>
		</div>
		
		<div class="row">
		<div class="cold-md-10"><?php echo $this->menu();?></div>
		
		
		</div>
		
		<div class="row" id="space">
		
		  <div class="col-md-10">
		  
		<?php echo $this->corps;?>
		</div>
		</div>
		
		</body>
		
		        <div class="row">
		           <footer class="footer"><?php echo $this->footer();?></footer>
		       </div>
		</div>
		</html>
		<?php 
		
	}
	
}
?>