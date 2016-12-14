<?php

class controleur{
	
	private $vpdo;
	private $db;
	
	public function __construct(){
		$db=new mypdo();
		$vpdo=$db->__get('connexion');
	}
	
	public function connexion()
	{
		$form="";
		
		$form.='
				
<div class="login-page">
      <div class="form">
          <form class="register-form">
              <input type="text" placeholder="Nom"/>
                  <input type="password" placeholder="Mot de passe"/>
                      <input type="text" placeholder="Adresse Mail"/>
                          <button>Cr&#233;er</button>
                        <p class="message">D&#233;j&#226; un compte ? <a href="#">Sign In</a></p>
            </form>
				
    <form class="login-form">
          <input type="text" placeholder="Nom Utilisateur"/>
             <input type="password" placeholder="Mot de passe"/>
                 <button>login</button>
              <p class="message">Pas de Compte ? <a href="#">Create an account</a></p>
         </form>
     </div>
</div>
				<script type="text/javascript" src="./js/js_perso.js"> </script>
				';
		return $form;
	}
	
	
	public function acceuil()
	{
		$form="";
		
		$form.='
				<h1><i>Bienvenu sur le site de mise &agrave; jour Excel</i><h1>
				
				<p>Ici vous pouvez mettre votre fichier Tables Sysderep_V2 &agrave; jour <p>
				
				';
		
		return $form;
	}
	
	public function consultation(){
		$form="";
		
		require_once 'PHPExcel/IOFactory.php';
		$file='uploads/Tables Syderep_V2.xlsx';
		
		// Chargement du fichier Excel
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		
		/**
		 * récupération de la première feuille du fichier Excel
		 * @var PHPExcel_Worksheet $sheet
		 */
		$sheet = $objPHPExcel->getSheet(1);
	
		
		$form.='
				<div class="row">
				<table border="1">';
		$i=0;
		$entete_tab="th";
		foreach ($sheet->getRowIterator() as $row){
			
			$form.='
				<tr>
					
					';
				
				foreach ($row->getCellIterator() as $cell){
					if($i<=7){
						$form.='<'.$entete_tab.'>'.$cell->getValue().'</'.$entete_tab.'>';
					}
					else {
						$entete_tab="td";
						$form.='<'.$entete_tab.'>'.$cell->getValue().'</'.$entete_tab.'>';
					}
					
					$i++;
				}
				
				
				
				$form.='
				</tr>
			
			
				';
			
		}
				$form.='
		</table>
			</div>
		';
				
				return $form;
		
	}
	
	
	public function maj(){
		$form="";
		
		$form.='
				<h3 align="center" >Cliquez pour mettre 	&agrave; jour le fichier</h3>
			<button type="button" class="btn btn-primary btn-lg btn-block" id="submit">Cliquez pour MAJ</button>
				
				
				<div id="display">
				
           <div class="row">
				
		       <div class="col-md-4 " >
			       <div class="loader">	</div>
					   </div>
				
				           <div class="col-md-4 col-md-push-1" >
			                   <div class="loader">	</div>
					       </div>
				
				<div class="col-md-4 col-md-push-2" >
			       <div class="loader"></div>	
		       </div>
	</div>
				</div>
				
				<div id="maj_success" >
				
				<div class="alert alert-success">
  <strong>Success!</strong> MAJ effectu&eacute;e.
</div>
			
				</div>
				
				
				
				
				<div class="row" id="maj_fail">
				<div class="col-md-4">
				<div class="alert alert-danger">
  <strong>OUUPPSSS!</strong> MAJ erreur.
</div>
				</div>
				</div>
				
				
				<script src="js/maj.js"></script>
				';
		return $form;
	}
	
	
	
}
























