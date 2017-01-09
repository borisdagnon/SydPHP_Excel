<?php

session_start();
include_once('../class/mypdo.class.php');
$data=array();

$data['success']=false;
$tab=array();
$data['vhu_Bdd']=array();
$data['vhu_Exist_BDD']=array();//récupère les centres VHU du fichier ICPE qui existent dans la BDD
$data['fichier_Excel']=array();
$data['result']=array();
$data['live']=array();
$mypdo=new mypdo();



require_once '../class/PHPExcel/IOFactory.php';
	$file1='../uploads/Extraction _2712_Base ICPE MEEM.xlsx';
    $file2='../uploads/VHU_Syderep.xlsx';



$BStyle = array(
			'borders' => array(
					'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
					)
			)
	);




$objPHPExcel = PHPExcel_IOFactory::load($file1);//On charge le fichier ICPE
$VHU_Syderep= PHPExcel_IOFactory::load($file2);//On charge le fichier VHU_Syderep

$sheet = $objPHPExcel->getSheet(0);//On veut la feuille 1
$sheet_VHU_Syderep= $VHU_Syderep->getSheet(0);//On veut la feuille 1
$i=2;
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


                   if($sheet->getCell($columnA.$row)->getValue()!=null){

	 			array_push($data['fichier_Excel'],$sheet->getCell($columnA.$row)->getValue()


	 					);//Permet de voir ce qu'on récupère dans un tableau

	 			


	 			$requete=$mypdo->Centres_VHU_Actifs($sheet->getCell($columnB.$row)->getValue());


	 	
if($requete==null ) {

	
//On récupère les tables du fichier ICPE qui ne sont pas dans la BDD Syderep	
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



	}else
	{
		//On récupère les centres VHU du fichier ICPE qui existent dans la BDD pour les mettres dans un nouveau fichier Excel
		$sheet_VHU_Syderep->getCell($columnA.$i)->setValue($sheet->getCell($columnA.$row)->getValue());
	 				
	 	$sheet_VHU_Syderep->getCell($columnB.$i)->setValue($sheet->getCell($columnE.$row)->getValue());
	 	
	 	$sheet_VHU_Syderep->getCell($columnC.$i)->setValue($sheet->getCell($columnG.$row)->getValue());
	 	
	 	$sheet_VHU_Syderep->getCell($columnD.$i)->setValue($sheet->getCell($columnH.$row)->getValue());

	 	$sheet_VHU_Syderep->getCell($columnE.$i)->setValue($sheet->getCell($columnB.$row)->getValue());

        $VHU_Syderep->getActiveSheet()->getStyle($columnA.$i)->applyFromArray($BStyle);



	 				$VHU_Syderep->getActiveSheet()->getStyle($columnA.$i)->applyFromArray(
	 						array('fill'=>
	 									
	 								array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
	 										array('rgb' => '92D050') )
	 						)
	 						);

	 				$i++;

	 			
	}


$data['success']=true;


	 		}


		}


			//On crée un objet Excel pour écrire dans le fichier
		

$objWriter = new PHPExcel_Writer_Excel2007($VHU_Syderep);

	
		$objWriter->save('../uploads/VHU_Syderep_copie.xlsx');



echo json_encode($data);

	

/*************************************************************************************************/
	


