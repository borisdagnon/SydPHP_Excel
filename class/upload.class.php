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
		$form="";
		// Chargement du fichier Excel
	
		$form.='
	
				<form action="#" method="post" enctype="multipart/form-data">
			<input type="file" name="file">
				<input type="submit" value="upload">
	
				</form>';
		
		
		if(isset($_FILES['file']))
		{
			$file=$_FILES['file'];
			
			// Propriétés du fichier
			$file_name=$file['name'];
			$file_tmp=$file['tmp_name'];
			$file_size=$file['size'];
			$file_error = $file['error'];
			// Gestion de l'extension du fichier
			
		   $file_ext=explode('.', $file_name);
		   $file_ext=strtolower(end($file_ext));
		   
		   $allowed = array('xlsx');
		   
		   
		   if(in_array($file_ext, $allowed)){
		  
		   	if ($file_error===0)
		   	{
		   		if($file_size<=2097152){
		   			echo 'lala';
		   			$file_name_new=uniqid('',true).'.'.$file_ext;
		   			$file_destination='uploads/'.$file_name_new;
		   			
		   			if(move_uploaded_file($file_tmp, $file_destination)){
		   				$form.='<div class="row" id="upload_message">Le fichier a été importé avec succès<div>';
		   			}
		   			else 
		   			{
		   				$form.='<div class="row" id="upload_message">Erreur d\'import<div>';
		   			}
		   		}
		   	
		   	
		   }
		
			
		}
		
		
	}
	return $form;
	
	}	
	
}