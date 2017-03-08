<?php
	
class controleur{
	private $vpdo;
	private $db;
    private $db2;
    private $vpdo2;
	
	public function __construct(){
		include_once('mypdo_SydPHP_Excel.class.php');
		$this->vpdo2 = new mypdo_SydPHP_Excel();
		 $this->vpdo = new mypdo();
        
        $this->db   = $this->vpdo->connexion;
        $this->db2 = $this->vpdo2->connexion;
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
				<h2><i>Bienvenu sur SydPHP_Excel</i></h2>
				
				<p>Ici vous pouvez mettre votre fichier Tables Syderep_V4 facilement<p>
                <p>Si vou n\'avez pas encore importer votre fichier vous pouvez le faire en allant sur Acceuil
            puis dans Importer ou remplacer si vous désirez remplacer le fichier déjà présent.</p>
				
				';
		
		return $form;
	}
	
	public function consultation(){
		$form="";
		
		require_once 'PHPExcel/IOFactory.php';
        
        $nom_fichier="";
$nom_final=$this->vpdo2->final_name();
while($n_f = $nom_final->fetch()){
    $nom_fichier=$n_f[0];
}
$file='uploads/'.$nom_fichier.'.xlsx';
	
		
		// Chargement du fichier Excel
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		
		
		/**
		 * récupération de la première feuille du fichier Excel
		 * @var PHPExcel_Worksheet $sheet
		 */
		$sheet = $objPHPExcel->getSheet(0);
	
		
		$form.='
				<div class="row">
				<div class="col-md-12 col-md-pull-1">
				<table border="1">';
		$i=0;
		$entete_tab="th";
		foreach ($sheet->getRowIterator() as $row){
			
			$form.='
				<tr>
					
					';
				
				foreach ($row->getCellIterator() as $cell){
					if($i<=7){//Si l'itérateur est inférieur au sept premiers résultats -> qui représenterons, les titres des collones du tableau HTML
						//Alors on dit que se sont les titre sinon se sont les valeurs du tableau
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
						</div>
		';
				
				return $form;
		
	}
	
	
	public function maj(){
		$form="";
		
		$form.='
				<div class="row">
<div class="col-md-5">
                    <p>Cet outil permet de récupérer les nouvelles tables de la base de données</p>
                    <p>Le fichier est mis à jour et il est possible de l\'exporter dans l\'onglet Modifier fichier Excel -> Exporter Excel </p>
                </div>
                <div class="col-md-5">
                <button type="button" class="btn btn-primary btn-lg btn-block" id="submit">Cliquez pour comparer</button>
            </div>
            </div>
			
				
				
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
	
	
	public function question(){
		$form="";
		$form.='';
		return $form;
	}

	public function VHU(){
		
		$form="";

		$form.='
        
<div class="row">
<div class="col-md-5">
                    <p>Cet outil permet de comparer les centres VHU de la BDD Syderep et du fichier ICPE</p>
                    <p>Le fichier est mis à jour et les VHU du fichier ICPE qui ne sont pas présents dans la BDD</p>
                </div>
                <div class="col-md-5">
                <button type="button" class="btn btn-primary btn-lg btn-block" id="submit">Cliquez pour comparer</button>
            </div>
            </div>
            
            
			



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


<table id="tab_entete">
<tr><th class="tab_haut">Ces Centres VHu n\'existent pas dans la BDD Syderep</th></tr>
</table>
<table id="non_Exist">

<tr><th>Société</th> <th>SIREN/SIRET</th> </tr>





</div>


<script src="js/VHU.js"></script>

		';
		return $form;
	}
	
	
}
























