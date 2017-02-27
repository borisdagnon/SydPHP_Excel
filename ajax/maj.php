<?php
session_start();

/*include_once ('../class/autoload.php');*/
include_once('../class/mypdo.class.php');
include_once('../class/mypdo_SydPHP_Excel.class.php');
$data=array();

$data['success']=false;
$tab=array();
$data['result']=array();
$data['tables_exist']=array();
$data['tables_result']=array();
$data['result_final']=array();
$mypdo=new mypdo();
$mypdo_SydPHP=new mypdo_SydPHP_Excel();

//On fait appel à la bibliothèque
require_once '../class/PHPExcel/IOFactory.php';


/*********************Procèdure pour récupérer le nom actuel du fichier*********************/
$nom_fichier="";
$nom_final=$mypdo_SydPHP->final_name();
while($n_f = $nom_final->fetch()){
    $nom_fichier=$n_f[0];
}
$file='../uploads/'.$nom_fichier.'.xlsx';
/*********************Procèdure pour récupérer le nom actuel du fichier*********************/


// Chargement du fichier Excel
$objPHPExcel = PHPExcel_IOFactory::load($file);





/*****************************************************************************************/
/**
	 * récupération de la prmère feuille du fichier Excel
	 * @var PHPExcel_Worksheet $sheet
	 */
$sheet = $objPHPExcel->getSheet(0);

/******************************************************************************************/



$BStyle = array(
    'borders' => array(
    'allborders' => array(
    'style' => PHPExcel_Style_Border::BORDER_THIN
)
)
);

//On crée les variables nécessaires
$i=0;
$columnA = 'A';
$columnB='B';
$columnC='C';
$columnD='D';
$columnE='E';
$columnF='F';
$columnG='G';
$columnH='H';

$lastRow = $sheet->getHighestDataRow();//On prends le numéro de ligne le plus élevé




for ($row = 2; $row <= $lastRow; $row++) {
    //On récupère ce qu'il y a dans chaque ligne du fichier Excel

    if($sheet->getCell($columnA.$row)->getValue()!=null){
        //On récupère toutes les tables du fichier Excel
        array_push($data['result'],[$sheet->getCell($columnA.$row)->getValue(),
                                    $sheet->getCell($columnB.$row)->getValue(),
                                    $sheet->getCell($columnC.$row)->getValue(),
                                    $sheet->getCell($columnD.$row)->getValue(),
                                    $sheet->getCell($columnE.$row)->getValue(),
                                    $sheet->getCell($columnF.$row)->getValue(),
                                    $sheet->getCell($columnG.$row)->getValue()]);//Permet de voir ce qu'on récupère dans un tableau


    }





    //On vérifi par cette requête l'existance de la table dans la BDD
    $requete=$mypdo->list_tables($sheet->getCell($columnA.$row)->getValue());


    //On parcours la requête
    while($r = $requete->fetch()){
        $requete=$mypdo->nb_liens($r[1]);/*On récupère le nombre de liens,
	 			c'est à dire le nombre de fois qu'on retrouve la clé de la colonne dans d'autres tables et on soustrait 1
	 			étant donné que ça comptera la table d'origine*/

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

            //On rajoute le nombre de liens à la fin du tableau
            array_push($data['result'][$i],$nb_liens[0]);
            $i++;


        }
    }



}









/*********************Procédure de rajout des tables non existantes dans le fichier Excel*********************/


$i=0;
foreach ($data['result'] as $r){

    array_push($data['tables_exist'], $r[0]);
    array_push($tab, $r[0]);//On insère dans un tableau les tables qui existent déjà
    $i++;


}



$tables=$mypdo->tables($tab);//On procède à la requête pour filtrer les tables déjà existantes

while($t = $tables->fetch()){//On parcours la requête pour récupérer les résultats dans un tableau

    array_push($data['tables_result'], $t[0]);//ce tableau php contient les nouvelles tables
}



/*********************Compter le nombre de lignes non null*********************/

$lignes=1;//On commence à compter à partir de la deuxième ligne
$data['nb_ligne']=array();
for ($row = 2; $row <= $lastRow; $row++) {
    if($sheet->getCell($columnA.$row)->getValue()!=null){
        $lignes++;
    }

}
$row=$lignes+1;//On passe le nombre de ligne plus la ligne suivante non remplie à $row
$data['nb_ligne']=$row;

/*********************Compter le nombre de lignes non null*********************/






/*********************On regarde la position de l'interrupteur et on choisie la couleur*********************/
$couleur="";
$interrupteur=$mypdo_SydPHP->interrupteur();//On appele la requête
while($i = $interrupteur->fetch()){//on parcours les résultats interrupteurs trouvés
    if($i[0]==1){
        $clr=$mypdo_SydPHP->couleur($i[0]);//On appele la requête
        while($c = $clr->fetch()){//on parcours les résultats de couleur trouvés
            $couleur=$c[1];//On prends la couleur verte

        }
        $maj_interrupteur=$mypdo_SydPHP->maj_interrupteur(2);//Si la couleur est verte alors on la passe à orange

    }else{
        $clr=$mypdo_SydPHP->couleur(2);//On appele la requête
        while($c = $clr->fetch()){//on parcours les résultats de couleur trouvés
            $couleur=$c[1];//On prends la couleur orange

        }
        $maj_interrupteur=$mypdo_SydPHP->maj_interrupteur(1);//Si la couleur est orange on la passe à vert
    }
}

/*********************On regarde la position de l'interrupteur*********************/


/***********************************************************************************************/

foreach ($data['tables_result'] as $d){//On parcours le nombre de tables dans le tableau PHP

    $sheet->getCell($columnA.$row)->setValue($d);//On insère une valeur à la cellule

    $objPHPExcel->getActiveSheet()->getStyle($columnH.$row)->applyFromArray($BStyle);

    $objPHPExcel->getActiveSheet()->getStyle($columnA.$row)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle($columnB.$row)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle($columnC.$row)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle($columnD.$row)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle($columnE.$row)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle($columnF.$row)->applyFromArray($BStyle);
    $objPHPExcel->getActiveSheet()->getStyle($columnG.$row)->applyFromArray($BStyle);


    //On donne la couleur qu'on a récupéré plus haut
    $objPHPExcel->getActiveSheet()->getStyle($columnA.$row)->applyFromArray(
        array('fill'=>

              array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                    array('rgb' => $couleur) )
             )
    );

    $row++;//Incrémentation des lignes pour l'ajout


}

/*Nommage du fichier et précision de la version*/
$nom_Fichier="";
$date_Fichier="";
if(!empty($data['tables_result'])){
    $info=$mypdo_SydPHP->maj_info_fichier();
}



$info=$mypdo_SydPHP->info_fichier();
while($i = $info->fetch()){

    $nom_Fichier=$i[1];
    $date_Fichier=$i[3];

}



$data['result_final']=array();


/*******************************************On parcours une dernière fois pour mettre**************************************************/
$row=0;
for ($row = 2; $row <= $lastRow; $row++) {
    //On récupère ce qu'il y a dans chaque ligne du fichier Excel

    if($sheet->getCell($columnA.$row)->getValue()!=null){

        array_push($data['result_final'],[$sheet->getCell($columnA.$row)->getValue(),
                                          $sheet->getCell($columnB.$row)->getValue(),
                                          $sheet->getCell($columnC.$row)->getValue(),
                                          $sheet->getCell($columnD.$row)->getValue(),
                                          $sheet->getCell($columnE.$row)->getValue(),
                                          $sheet->getCell($columnF.$row)->getValue(),
                                          $sheet->getCell($columnG.$row)->getValue()]);//Permet de voir ce qu'on récupère dans un tableau

    }

    $requete=$mypdo->list_tables($sheet->getCell($columnA.$row)->getValue());

    //On parcours la requête
    while($r = $requete->fetch()){
        $requete=$mypdo->nb_liens($r[1]);/*On récupère le nombre de liens,
	 			c'est à dire le nombre de fois qu'on retrouve la clé de la colonne dans d'autres tables et on soustrait 1
	 			étant donné que ça comptera la table d'origine*/

        while($nb_liens = $requete->fetch()){
            $sheet->getCell($columnC.$row)->setValue($nb_liens[1]);
            $sheet->getCell($columnH.$row)->setValue($nb_liens[0]);

        }
    }



}


/*Cette phase permet de préciser la version du fichier et la date de maj en dernière position du fichier*/


$lignes=1;
for ($row = 2; $row <= $lastRow; $row++) {
    if($sheet->getCell($columnA.$row)->getValue()!=null){
        $lignes++;
    }

}
$row=$lignes+1;//On passe le nombre de ligne plus la ligne suivante non remplie à $row


$ver=0;//on initialize à 0
$version=$mypdo_SydPHP->version();//on effectue la requête
while($v = $version->fetch()){
    $ver=$v[1];//on récupère le résultat de la requête
}
$sheet->getCell($columnA.$row)->setValue($nom_Fichier.$ver.'  '.
                                         $date_Fichier
                                        );
$sheet->getCell($columnB.$row)->setValue($nom_Fichier.$ver.'  '.
                                         $date_Fichier
                                        );
$sheet->getCell($columnC.$row)->setValue($nom_Fichier.$ver.'  '.
                                         $date_Fichier
                                        );
$sheet->getCell($columnD.$row)->setValue($nom_Fichier.$ver.'  '.
                                         $date_Fichier
                                        );
$sheet->getCell($columnE.$row)->setValue($nom_Fichier.$ver.'  '.
                                         $date_Fichier
                                        );
$sheet->getCell($columnF.$row)->setValue($nom_Fichier.$ver.'  '.
                                         $date_Fichier
                                        );
$sheet->getCell($columnG.$row)->setValue($nom_Fichier.$ver.'  '.
                                         $date_Fichier
                                        );
$sheet->getCell($columnH.$row)->setValue($nom_Fichier.$ver.'  '.
                                         $date_Fichier
                                        );

//On met en bleu la cellule qui précise la version du fichier et la date de la mise à jour
$objPHPExcel->getActiveSheet()->getStyle($columnA.$row)->applyFromArray(
    array('fill'=>

          array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                array('rgb' => '3498db') )
         )
);
$objPHPExcel->getActiveSheet()->getStyle($columnB.$row)->applyFromArray(
    array('fill'=>

          array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                array('rgb' => '3498db') )
         )
);
$objPHPExcel->getActiveSheet()->getStyle($columnC.$row)->applyFromArray(
    array('fill'=>

          array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                array('rgb' => '3498db') )
         )
);
$objPHPExcel->getActiveSheet()->getStyle($columnD.$row)->applyFromArray(
    array('fill'=>

          array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                array('rgb' => '3498db') )
         )
);
$objPHPExcel->getActiveSheet()->getStyle($columnE.$row)->applyFromArray(
    array('fill'=>

          array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                array('rgb' => '3498db') )
         )
);
$objPHPExcel->getActiveSheet()->getStyle($columnF.$row)->applyFromArray(
    array('fill'=>

          array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                array('rgb' => '3498db') )
         )
);
$objPHPExcel->getActiveSheet()->getStyle($columnG.$row)->applyFromArray(
    array('fill'=>

          array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                array('rgb' => '3498db') )
         )
);
$objPHPExcel->getActiveSheet()->getStyle($columnH.$row)->applyFromArray(
    array('fill'=>

          array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' =>
                array('rgb' => '3498db') )
         )
);




/*******************************************Écriture dans le fichier et sauvegarde******************************************************/

//On crée un objet Excel pour écrire dans le fichier
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('../uploads/'.$nom_Fichier.$ver.'.xlsx');//On sauvegarde dans le même emplacement
$mypdo_SydPHP->maj_final_name($nom_Fichier.$ver);
$data['success']=true;


/*************************************************************************************************/


echo json_encode($data);

?>
