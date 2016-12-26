<?php
session_start();

/*include_once ('../class/autoload.php');*/
include_once('../class/mypdo.class.php');
$data=array();

$data['success']=false;
$tab=array();
$data['result']=array();
$data['tables_exist']=array();
$data['tables_result']=array();
$mypdo=new mypdo();

//On fait appel � la biblioth�que
	require_once '../class/PHPExcel/IOFactory.php';
	$file='../uploads/Tables Syderep_V2.xlsx';

	// Chargement du fichier Excel
	$objPHPExcel = PHPExcel_IOFactory::load($file);


	
	
	
	/*****************************************************************************************/
	/**
	 * r�cup�ration de la deuxi�me feuille du fichier Excel car l'index part de 0
	 * @var PHPExcel_Worksheet $sheet
	 */
	$sheet = $objPHPExcel->getSheet(0);

	/******************************************************************************************/
	
	
	
	

	 //On parcours la colonne A pour r�cup�rer les libell�s des tables
	 
	$BStyle = array(
			'borders' => array(
					'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
					)
			)
	);

	$i=0;
	$columnA = 'A';
	$columnB='B';
	$columnC='C';
	$columnD='D';
	$columnE='E';
	$columnF='F';
	$columnG='G';
	$columnH='H';
	
	$lastRow = $sheet->getHighestDataRow();

	
	
	
	 	for ($row = 2; $row <= $lastRow; $row++) {
	 		//On r�cup�re ce qu'il y a dans chaque ligne du fichier Excel
	 	
	 		if($sheet->getCell($columnA.$row)->getValue()!=null){
	 	
	 			array_push($data['result'],[$sheet->getCell($columnA.$row)->getValue(),
	 					$sheet->getCell($columnB.$row)->getValue(),
	 					$sheet->getCell($columnC.$row)->getValue(),
	 					$sheet->getCell($columnD.$row)->getValue(),
	 					$sheet->getCell($columnE.$row)->getValue(),
	 					$sheet->getCell($columnF.$row)->getValue(),
	 					$sheet->getCell($columnG.$row)->getValue()]);//Permet de voir ce qu'on r�cup�re dans un tableau
	 	
	 	
	 		}
	 			
	 			
	 	
	 	
	 	
	 		//On r�cup�re la colonne de la table de la ligne du fichier Excel qu'on parcours actuellement
	 		$requete=$mypdo->list_tables($sheet->getCell($columnA.$row)->getValue());
	 	
	 	
	 		//On parcours la requ�te
	 		while($r = $requete->fetch()){
	 			$requete=$mypdo->nb_liens($r[1]);/*On r�cup�re le nombre de liens,
	 			c'est � dire le nombre de fois qu'on retrouve la cl� de la colonne dans d'autres tables et on soustrait 1
	 			�tant donn� que �a comptera la table d'origine*/
	 				
	 			while($nb_liens = $requete->fetch()){
	 	
	 					
	 				$sheet->getCell($columnA.$row)->setValue($sheet->getCell($columnA.$row)->getValue());
	 				$sheet->getCell($columnB.$row)->setValue($sheet->getCell($columnB.$row)->getValue());
	 				$sheet->getCell($columnC.$row)->setValue($sheet->getCell($columnC.$row)->getValue());
	 				$sheet->getCell($columnD.$row)->setValue($sheet->getCell($columnD.$row)->getValue());
	 				$sheet->getCell($columnE.$row)->setValue($sheet->getCell($columnE.$row)->getValue());
	 				$sheet->getCell($columnF.$row)->setValue($sheet->getCell($columnF.$row)->getValue());
	 				$sheet->getCell($columnG.$row)->setValue($sheet->getCell($columnG.$row)->getValue());
	 				$sheet->getCell($columnH.$row)->setValue($nb_liens[0]);
	 					
	 					
	 				$objPHPExcel->getActiveSheet()->getStyle($columnH.$row)->applyFromArray(
	 						array('fill'=>
	 									
	 								array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
	 										array('rgb' => '92D050') )
	 						)
	 						);
	 					
	 					
	 				array_push($data['result'][$i],$nb_liens[0]);
	 				$i++;
	 	
	 	
	 			}
	 		}
	 			
	 			
	 	
	 	}
	

	
/******************************************Proc�dure de rajout des tables non existantes dans le fichier Excel*************************************************/
	
	
	$i=0;
	foreach ($data['result'] as $r){
		
			array_push($data['tables_exist'], $r[0]);
			array_push($tab, $r[0]);//On ins�re dans un tableau les tables qui existent d�j�
		$i++;
		
		
	}
	
	
	
	$tables=$mypdo->tables($tab);//On proc�de � la requ�te pour filtrer les tables d�j� existantes
	
	while($t = $tables->fetch()){//On parcours la requ�te pour r�cup�rer les r�sultats dans un tableau
		array_push($data['tables_result'], $t[0]);
	}
	
	/******************************************Compter le nombre de lignes non null*****************************************************/
	$lignes=0;
	for ($row = 2; $row <= $lastRow; $row++) {
		if($sheet->getCell($columnA.$row)->getValue()!=null){
			$lignes++;//Incr�mentation des lignes
		}
	
	
	}
	$row=$lignes+1;//On passe le nombre de ligne plus la ligne suivante non remplie � $row
	/***********************************************************************************************/
	
		foreach ($data['tables_result'] as $d){//On parcours le nombre de tables dans le tableau PHP
			
			$sheet->getCell($columnA.$row)->setValue($d);//On ins�re une valeur � la cellule
			
			$objPHPExcel->getActiveSheet()->getStyle($columnH.$row)->applyFromArray($BStyle);
			//On donne la couleur verte � la cellule dans laquelle on vient d'ins�rer une valeur
			$objPHPExcel->getActiveSheet()->getStyle($columnA.$row)->applyFromArray(
					array('fill'=>
			
							array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
									array('rgb' => '92D050') )
					)
					);
			
			$row++;//Incr�mentation des lignes pour l'ajout
				
		
		
	}

	
	
	
	
	
	
	
	/*******************************************On parcours � nouveau pour finaliser la couleur et les bordures**************************************************/

	for ($row = 2; $row <= $lastRow; $row++) {
		//On r�cup�re ce qu'il y a dans chaque ligne du fichier Excel
		
		if($sheet->getCell($columnA.$row)->getValue()!=null){
			 
			array_push($data['result'],[$sheet->getCell($columnA.$row)->getValue(),
					$sheet->getCell($columnB.$row)->getValue(),
					$sheet->getCell($columnC.$row)->getValue(),
					$sheet->getCell($columnD.$row)->getValue(),
					$sheet->getCell($columnE.$row)->getValue(),
					$sheet->getCell($columnF.$row)->getValue(),
					$sheet->getCell($columnG.$row)->getValue()]);//Permet de voir ce qu'on r�cup�re dans un tableau
					 
					 
		}
			
			
		 
		 
		 
		//On r�cup�re la colonne de la table de la ligne du fichier Excel qu'on parcours actuellement
		$requete=$mypdo->list_tables($sheet->getCell($columnA.$row)->getValue());
		 
		 
		//On parcours la requ�te
		while($r = $requete->fetch()){
			$requete=$mypdo->nb_liens($r[1]);/*On r�cup�re le nombre de liens,
			c'est � dire le nombre de fois qu'on retrouve la cl� de la colonne dans d'autres tables et on soustrait 1
			�tant donn� que �a comptera la table d'origine*/
	
			while($nb_liens = $requete->fetch()){
				 
		 		
				$sheet->getCell($columnA.$row)->setValue($sheet->getCell($columnA.$row)->getValue());
				$sheet->getCell($columnB.$row)->setValue($sheet->getCell($columnB.$row)->getValue());
				$sheet->getCell($columnC.$row)->setValue($sheet->getCell($columnC.$row)->getValue());
				$sheet->getCell($columnD.$row)->setValue($sheet->getCell($columnD.$row)->getValue());
				$sheet->getCell($columnE.$row)->setValue($sheet->getCell($columnE.$row)->getValue());
				$sheet->getCell($columnF.$row)->setValue($sheet->getCell($columnF.$row)->getValue());
				$sheet->getCell($columnG.$row)->setValue($sheet->getCell($columnG.$row)->getValue());
				$sheet->getCell($columnH.$row)->setValue($nb_liens[0]);
		 		
		 		
				
				$objPHPExcel->getActiveSheet()->getStyle($columnH.$row)->applyFromArray($BStyle);
				
				$objPHPExcel->getActiveSheet()->getStyle($columnH.$row)->applyFromArray(
						array('fill'=>
									
								array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
										array('rgb' => '92D050') )
						)
						);
		 		
		 		
				array_push($data['result'][$i],$nb_liens[0]);
				$i++;
				
				 
				 
				 
				 
			}
		}
			
			
		 
	}
	
	

	
/*******************************************�criture dans le fichier et sauvegarde******************************************************/
		
			//On cr�e un objet Excel pour �crire dans le fichier
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('../uploads/Tables Syderep_V2.xlsx');//On sauvegarde dans le m�me emplacement

$data['success']=true;
	

/*************************************************************************************************/
	

echo json_encode($data);

?>
