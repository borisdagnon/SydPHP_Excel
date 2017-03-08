<?php

session_start();
ini_set('memory_limit', '1024M');
include_once('../class/mypdo.class.php');
$data=array();

$data['success']=false;
$data['fichier_Excel']=array();
$data['result']=array();
$data['live']=array();
$part1=false;
$part2=false;
$part3=false;
$mypdo=new mypdo();



require_once '../class/PHPExcel/IOFactory.php';
	$file1='../uploads/ICPE.xlsx';
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
	$columnA='A';
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


                   if($sheet->getCell($columnB.$row)->getValue()!="+"){

	 			
	 			$requete=$mypdo->verif_Siren_Siret($sheet->getCell($columnB.$row)->getValue());
                if($requete!=null){
					   while($r = $requete->fetch()){
                                               if($r[0]!=null || $r[0]!=""){
                                                   //On place tous les résultats dans un tableau
array_push($data['result'],[$r[0],$r[1],$sheet->getCell($columnF.$row)->getValue(),
    $sheet->getCell($columnH.$row)->getValue(),
    $sheet->getCell($columnI.$row)->getValue(),
    $sheet->getCell($columnC.$row)->getValue()
    ]);
					   }
                                     }
                                     
                              
	 		}
                        
                        
                        
                        $live=$mypdo->exists_vhu($sheet->getCell($columnB.$row)->getValue());
                                     
                                         if($live==0){
             array_push($data['live'],[$sheet->getCell($columnA.$row)->getValue(),
                 $sheet->getCell($columnB.$row)->getValue()]);                                
                                         }
                   }
$part1=true;

		}
                
                
                
                /*On remplie le fichier VHU_Syderep */

                foreach ($data['result'] as $d){
                    $sheet_VHU_Syderep->getCell($columnA.$i)->setValue($d[0]);
                    $sheet_VHU_Syderep->getCell($columnB.$i)->setValue($d[1]);
                    $sheet_VHU_Syderep->getCell($columnC.$i)->setValue($d[2]);
                    $sheet_VHU_Syderep->getCell($columnD.$i)->setValue($d[3]);
                    $sheet_VHU_Syderep->getCell($columnE.$i)->setValue($d[4]);
                    $sheet_VHU_Syderep->getCell($columnF.$i)->setValue($d[5]);
                    $i++;
                    $part2=true;
                }


$objWriter = new PHPExcel_Writer_Excel2007($VHU_Syderep);

	
		$objWriter->save('../uploads/VHU_Syderep_copie.xlsx');
                     $part3=true;
            
                //Si 
                if($part1==true && $part2==true && $part3==true){
                    $data['success']=true;
                }
                 
              
echo json_encode($data);

	

/*************************************************************************************************/
	


