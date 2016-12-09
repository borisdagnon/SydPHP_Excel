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
              <input type="text" placeholder="name"/>
                  <input type="password" placeholder="password"/>
                      <input type="text" placeholder="email address"/>
                          <button>create</button>
                        <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
				
    <form class="login-form">
          <input type="text" placeholder="username"/>
             <input type="password" placeholder="password"/>
                 <button>login</button>
              <p class="message">Not registered? <a href="#">Create an account</a></p>
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
				
				<table border="1">';
		
		foreach ($sheet->getRowIterator() as $row){
			
			$form.='
				<tr>
					
					';
				
				foreach ($row->getCellIterator() as $cell){
					
					$form.='<td>'.$cell->getValue().'</td>';
				}
				
				
				
				$form.='
				</tr>
			
			
				';
			
		}
				$form.='
		</table>
			
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
























