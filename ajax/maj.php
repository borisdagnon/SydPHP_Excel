<?php
session_start();

/*include_once ('../class/autoload.php');*/
include_once('../class/mypdo.class.php');
$errors=array();
$data=array();
$data['result']=array();
$data['success']=false;
$tab=array();
$info=array();
$data['Table_Name']=array();
$data['Column_Name']=array();
$data['nb']=array();
$mypdo=new mypdo();


//On fait appel � la biblioth�que
	require_once '../class/PHPExcel/IOFactory.php';
	$file='../uploads/Tables Syderep_V2.xlsx';

	// Chargement du fichier Excel
	$objPHPExcel = PHPExcel_IOFactory::load($file);


	
	
	
	
	/**
	 * r�cup�ration de la deuxi�me feuille du fichier Excel car l'index part de 0
	 * @var PHPExcel_Worksheet $sheet
	 */
	$sheet = $objPHPExcel->getSheet(1);


	 //On parcours la colonne A pour r�cup�rer les libell�s des tables
	 
	 
	$column = 'A';
	$lastRow = $sheet->getHighestRow();
	for ($row = 2; $row <= $lastRow; $row++) {
		$cell = $sheet->getCell($column.$row);
		$cell=$cell->getValue();//On r�cup�re la valeur de la cellule
		array_push($data['result'], $cell);
		array_push($tab, $cell);
	
		
	}

	//On fait la requ�te dans la BDD pour r�cup�rer les tables et colonnes
	$requete=$mypdo->list_tables($tab);
	
	
	
	/**
	 * @param string $requete Requ�te des liste de tables et colonnes
	 */
	if($requete){
		
		while($r = $requete->fetch()){
		
			array_push($data['Table_Name'], $r[0]);
			array_push($data['Column_Name'], $r[1]);
			 
		}
		
		
		foreach ($data['Column_Name'] as $col_name){
			
			$requete=$mypdo->nb_liens($col_name);
			while ($r = $requete->fetch()){
				array_push($data['nb'], $r[0]);
				
			}
			
		}
		
		$column = 'H';
		$highestRow=$sheet->getHighestRow();
		$row=2;
		foreach ($data['nb'] as $value){
	
			/*$sheet->setCellValue($column.$row,$value);*/
			$objPHPExcel->getActiveSheet()->setCellValue($column.$row,$value);
			$objPHPExcel->getActiveSheet()->getStyle($column.$row)->applyFromArray(
				array('fill'=>
						
						array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => 
             array('rgb' => '92D050') )
				)
				);
				$row++;
		}
		
		
		
		
		
		
/*********************Bordures et Couleur des cellules*************************/
		$styleArray = array(
			
				'borders' => array(
						'outline' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
						),
				)
				
		);
		
/****************************************************************************/
		
	
		
		
		
		
		
		
		
/*******************************************Insertion du nom des tables******************************************************/

		$requete=$mypdo->tables();
		$column='A';
		$highestRow=$sheet->getHighestRow();
		$row=2;
		
		while ($r=$requete->fetch()){
			
			$objPHPExcel->getActiveSheet()->setCellValue($column.$row,$r[0]);
			array_push($data['Table_Name'], $r[0]);//Permet de voir ce qu'on r�cup�re en Ajax
			$row++;
		}
		
/*************************************************************************************************/
		

		
		
		
		
		
/*******************************************�criture dans le fichier et sauvegarde******************************************************/
		
			//On cr�e un objet Excel pour �crire dans le fichier
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('../uploads/Tables Syderep_V2.xlsx');//On sauvegarde dans le m�me emplacement

$data['success']=true;
	}else 
	{
		$data['success']=false;
	}

/*************************************************************************************************/
	

echo json_encode($data);

?>
