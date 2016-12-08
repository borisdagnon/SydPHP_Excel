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

	

	require_once '../class/PHPExcel/IOFactory.php';
	$file='../uploads/Tables Syderep_V2.xlsx';

	// Chargement du fichier Excel
	$objPHPExcel = PHPExcel_IOFactory::load($file);


	/**
	 * récupération de la première feuille du fichier Excel
	 * @var PHPExcel_Worksheet $sheet
	 */
	$sheet = $objPHPExcel->getSheet(1);


	/**
	 * On parcours la colonne A pour récupérer les libellés des tables
	 * @var string $column
	 */
	$column = 'A';
	$lastRow = $sheet->getHighestRow();
	for ($row = 2; $row <= $lastRow; $row++) {
		$cell = $sheet->getCell($column.$row);
		$cell=$cell->getValue();
		array_push($data['result'], $cell);
		array_push($tab, $cell);
	$data['success']=true;
		
	}
	$requete=$mypdo->list_tables($tab);

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
		
		$row=2;
		foreach ($data['nb'] as $value){
			$sheet->setCellValue(''.$column.$row.'',$value);
				
		}
			
	
		
	}else 
	{
		
	}
	
	
	

echo json_encode($data);

?>
