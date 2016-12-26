<?php

session_start();
include_once('../class/mypdo.class.php');
$data=array();

$data['success']=false;
$tab=array();
$data['vhu_Bdd']=array();
$data['vhu_Exist']=array();
$data['vhu_Non_Exist']=array();
$data['fichier_Excel']=array();
$data['result']=array();
$data['live']=array();
$mypdo=new mypdo();


require_once '../class/PHPExcel/IOFactory.php';
	$file='../uploads/Extraction _2712_Base ICPE MEEM.xlsx';

$objPHPExcel = PHPExcel_IOFactory::load($file);

$sheet = $objPHPExcel->getSheet(0);

$i=0;
	$columnA = 'A';
	$columnB='B';
	$columnC='C';
	$columnD='D';
	$columnE='E';
	$columnF='F';
	$columnG='G';
	$columnH='H';
	$columnI='I';
	$columnJ='J';
	
	$lastRow = $sheet->getHighestDataRow();
/**
 * [$row description]
 * @var integer
 */
		for ($row = 2; $row <= $lastRow; $row++) {

$preced=$sheet->getCell($columnA.$row)->getValue();
                   if($sheet->getCell($columnA.$row)->getValue()!=null){

	 			array_push($data['fichier_Excel'],$sheet->getCell($columnA.$row)->getValue()

	 					);//Permet de voir ce qu'on récupère dans un tableau


	 			$requete=$mypdo->Centres_VHU_Actifs($sheet->getCell($columnA.$row)->getValue());

	 			//On envoie l'information en live pour afficher les tables une par une
if($requete==null ) {

	

array_push($data['live'],[$sheet->getCell($columnA.$row)->getValue(),

                     
	 					$sheet->getCell($columnB.$row)->getValue(),
	 					$sheet->getCell($columnC.$row)->getValue(),
	 					$sheet->getCell($columnD.$row)->getValue(),
	 					$sheet->getCell($columnE.$row)->getValue(),
	 					$sheet->getCell($columnF.$row)->getValue(),
	 					$sheet->getCell($columnG.$row)->getValue(),
                        $sheet->getCell($columnH.$row)->getValue(),
                        $sheet->getCell($columnI.$row)->getValue(),
                        $sheet->getCell($columnJ.$row)->getValue(),$requete]);



	}

 			
	 	
/*array_push($data['result'],[$sheet->getCell($columnA.$row)->getValue(),

                     
	 					$sheet->getCell($columnB.$row)->getValue(),
	 					$sheet->getCell($columnC.$row)->getValue(),
	 					$sheet->getCell($columnD.$row)->getValue(),
	 					$sheet->getCell($columnE.$row)->getValue(),
	 					$sheet->getCell($columnF.$row)->getValue(),
	 					$sheet->getCell($columnG.$row)->getValue(),
                        $sheet->getCell($columnH.$row)->getValue(),
                        $sheet->getCell($columnI.$row)->getValue(),
                        $sheet->getCell($columnJ.$row)->getValue(),$requete
]);
	 	*/

$data['success']=true;


	 		}


		}




			//On crée un objet Excel pour écrire dans le fichier
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

echo json_encode($data);

	

/*************************************************************************************************/
	


