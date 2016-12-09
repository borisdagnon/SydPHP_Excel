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
		
		$resp="NO";
		$form="";
		// Chargement du fichier Excel

		$form.='
	
				<form action="#" method="POST" enctype="multipart/form-data">
			<input type="file" name="file">
				<input type="submit" value="upload">
	
				</form>';
		
		
		if(isset($_FILES['file']))
		{
			$post=array();
			
				$file=$_FILES['file'];
				
				// Propriétés du fichier
				$file_name=$file['name'];
				$file_tmp=$file['tmp_name'];
				array_push($post,$file['tmp_name']);
				$file_size=$file['size'];
				array_push($post, $file_size);
				$file_error = $file['error'];
				// Gestion de l'extension du fichier
				
				$file_ext=explode('.', $file_name);/* cette opération coupe la chaine de caractère à partir du point*/
				var_dump($file_ext[0]);
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
				array_push($post, $file_destination='uploads/'.$file_name_new);
			var_dump($post);
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
									$post=implode(",", $post);
									$form.='
		   	
		   	
		   						<div class="row" id="upload_message">
											<div class="col-md-6">
											<p>Il existe d&eacute;j&agrave; un fichier </p>
											
											
											<button type="button" class="btn btn-success" type="submit" id="submit" value="'.$post.'">Remplacer</button>
											
											
											</div>
												</div>
											
						                 <script src="js/upload.js"></script>
											
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
	

	
}