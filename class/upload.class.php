<?php
class upload extends controleur{
	private $vpdo;
	private $db;
	
	public function __construct(){
		$db=new mypdo();
		$vpdo=$db->__get('connexion');
	}
	
	
	
	
	public function upload()
	{
		$file_destination;
		
		$resp="NO";
		$form="";
		// Chargement du fichier Excel

		$form.='
	
				
				<form id="upload_form" action="#" method="POST" enctype="multipart/form-data">
			    <input type="file" name="file" >
				<div id="upload_upload">
				
				<input type="submit" value="upload">
				</div>
				</form>
				
				
				<script src="js/upload.js"></script>';
				
				
		
		if(isset($_FILES['file']))
		{
			$post=array();
			
				$file=$_FILES['file'];
				var_dump($file);
				// Propriétés du fichier
				$file_name=$file['name'];
				$file_tmp=$file['tmp_name'];
				$file_size=$file['size'];
				$file_error = $file['error'];
				// Gestion de l'extension du fichier
				
				$file_ext=explode('.', $file_name);/* cette opération coupe la chaine de caractère à partir du point*/
				
				$nom_comparant='Tables Syderep_V2';
				$nom_compare=$file_ext[0];
				 
				$file_ext=strtolower(end($file_ext));/*on prend la chaine qui est à la fin du tableau et on la met en minuscule*/
				
				 
				$allowed = array('xlsx');/*On défini les extensions autorisées dans un tableau*/
				 
				if($nom_comparant==$nom_compare)
				{
				
					
					if(in_array($file_ext, $allowed)){/*On vérifi si on a autorisé l'extension*/
				
						if ($file_error===0)/* S'il n'y a pas d'erreur*/
						{
							if($file_size<=2097152){ /*On vérifi si le fichier est inférieur à 2MB*/
				
								/* $file_name_new=uniqid('',true).'.'.$file_ext;/*On donne un nouveau nom unique au fichier*/
								$file_name_new='Tables Syderep_V2'.'.'.$file_ext;
								$file_destination='uploads/'.$file_name_new;/*On fait une concaténation avec le nom du nouveau fichier*/
								array_push($file,$file_destination);
		
								if (count(glob("uploads/*")) === 0 )/* Permet de savoir s'il y a déjà un fichier Excel dans le dossier uploads*/
								 
								{
				
									if(move_uploaded_file($file_tmp, $file_destination)){
										$form.='<div class="row" id="upload_message"><p>Le fichier a &eacute;t&eacute; import&eacute; avec succ&egrave;s</p><div>';
									}
									else
									{
										$form.='<div class="row" id="upload_message"><p>Erreur d\'import</p><div>';
									}
									
								}
								else
								{
									
										
									
									$form.='
		   	
		   	
		   						<div class="row" id="upload_message">
											<div class="col-md-6">
											<p>Il existe d&eacute;j&agrave; un fichier, vous pouvez le remplacer dans <a href="replace.php">Remplacer Fichier</a></p>
											
											
											</div>
												</div>
											
						                		
											
											';
								
									 
								}
				
							}
				
				
						}
				
					}
				}
				else
				{
					$form.='<div class="row" id="upload_message"><p>Vous devez renommer le fichier "Tables Syderep_V2"</p><div>';
				}
				
		
				
		
		
	}
	return $form;
	
	}
	
	
	public function replace(){
		$form="";
		
		
			
			$form.='
		
		
		   						<div class="row" id="upload_message">
											<div class="col-md-6">
											<p>Veuillez s&eacutelectionner un fichier</p>
						<form id="upload_form" action="#" method="POST" enctype="multipart/form-data">
			    <input type="file" name="file" >
					<button type="submit" class="btn btn-danger" value="Remplacer" type="submit">Remplacer</button>
			
				
				</form>
						
						
											</div>
												</div>
						
		
						
											';
			
		
			

			if(isset($_FILES['file']))
			{
			
					
				$file=$_FILES['file'];
				var_dump($file);
				// Propriétés du fichier
				$file_name=$file['name'];
				$file_tmp=$file['tmp_name'];
				$file_size=$file['size'];
				$file_error = $file['error'];
				// Gestion de l'extension du fichier
				
				$file_ext=explode('.', $file_name);/* cette opération coupe la chaine de caractère à partir du point*/
				
				$nom_comparant='Tables Syderep_V2';
				$nom_compare=$file_ext[0];
					
				$file_ext=strtolower(end($file_ext));/*on prend la chaine qui est à la fin du tableau et on la met en minuscule*/
				
					
				$allowed = array('xlsx');/*On défini les extensions autorisées dans un tableau*/
					
				if($nom_comparant==$nom_compare)
				{
				
						
					if(in_array($file_ext, $allowed)){/*On vérifi si on a autorisé l'extension*/
				
						if ($file_error===0)/* S'il n'y a pas d'erreur*/
						{
							if($file_size<=2097152){ /*On vérifi si le fichier est inférieur à 2MB*/
				
								/* $file_name_new=uniqid('',true).'.'.$file_ext;/*On donne un nouveau nom unique au fichier*/
								$file_name_new='Tables Syderep_V2'.'.'.$file_ext;
								$file_destination='uploads/'.$file_name_new;/*On fait une concaténation avec le nom du nouveau fichier*/
								array_push($file,$file_destination);
				
								if (count(glob("uploads/*")) == 1 )/* Permet de savoir s'il y a déjà un fichier Excel dans le dossier uploads*/
									
								{
				
									if(move_uploaded_file($file_tmp, $file_destination)){
										$form.='<div class="row" id="upload_message"><p>Le fichier a &eacute;t&eacute; remplac&eacute; avec succ&egrave;s</p><div>';
									}
									else
									{
										$form.='<div class="row" id="upload_message"><p>Erreur d\'import</p><div>';
									}
										
								}
								
				
							}
				
				
						}
				
					}
				}
				else
				{
					$form.='<div class="row" id="upload_message"><p>Vous devez renommer le fichier "Tables Syderep_V2"</p><div>';
				}
				
				
			
			
			}
			return $form;
	
	}
	
	
	
	public function export(){
		$form="";
		
		
		$file="uploads/Tables Syderep_V2.xlsx";
		if(file_exists($file)){
			header('Content-Description: File Transfert');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		}
		
	}
	
	
	
}