<?php

class mypdo{
	private $utilisateur='syderep_ro_ademe';
	private $mdp='syderep_ro_ademe';
	private $bdd='syderep_intcont';
	private $hote='10.1.12.95';
	
	private $connexion;

	/**
	 * Permet de créer un nouvel objet PDO
	 * @return string
	 */
	public function __construct(){
		$message="";
		try {
	$this->connexion=new PDO('mysql:host='.$this->hote.';dbname='.$this->bdd.';charset=UTF8',$this->utilisateur,$this->mdp);
	
			
		}
		catch(PDOException $ex){
			echo'NO';
			$message.= $message;
			$message.= $ex->getCode();
			$message.= $ex->getMessage();
		}
		return $message;
	}
	
	/**
	 * 
	 * @param string $prop
	 * @return PDO
	 */
	public function __get($prop){
		switch ($prop){
			case 'connexion': return $this->connexion;
			break;
		}
		
	}
	
	/**
	 * On va chercher le nom des tables et le nom des collones
	 * @param array $tab contient le nom des tables extraites du fichier Excel
	 * @return PDOStatement|NULL
	 */
	public function list_tables($tab)
	{
		
			$requete='SELECT DISTINCT TABLE_NAME, COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME  IN ("'.$tab.'")
    AND TABLE_SCHEMA="syderep_intcont"
GROUP BY TABLE_NAME
	';
			$_SESSION['requete']=$requete;
			/*var_dump($_SESSION['requete']);*/
			$result=$this->connexion->query($requete);
			if($result){
				return $result;
			}
			return null;
	}
	
	/**
	 * On va chercher le nombre de liens et on soustrait 1
	 * $param string $col_name
	 * @return PDOStatement|NULL
	 */
	public function nb_liens($col_name){
		
		$requete='SELECT COUNT(COLUMN_NAME)-1,SUBSTRING(COLUMN_NAME,1,3)
FROM INFORMATION_SCHEMA.COLUMNS
WHERE COLUMN_NAME LIKE "'.$col_name.'"
AND TABLE_SCHEMA="syderep_intcont"';
		
		$result=$this->connexion->query($requete);
		if($result){
			return $result;
		}else {
			return null;
		}
		
	}
	
	/**
	 * Cette fonction récupère seulement le nom des tables
	 * @return PDOStatement|NULL
	 * @return result 
	 */
	public function tables($tab){
		
		$Exos_list=array();
	array_push($Exos_list, 'CHARACTER_SETS','COLLATIONS','COLLATION_CHARACTER_SET_APPLICABILITY',
		'COLUMNS','COLUMN_PRIVILEGES','ENGINES','EVENTS','FILES','GLOBAL_STATUS','GLOBAL_VARIABLES',
		'KEY_COLUMN_USAGE','PARAMETERS','PARTITIONS','PLUGINS','PROCESSLIST','PROFILING','REFERENTIAL_CONSTRAINTS','ROUTINES','SCHEMATA','SCHEMA_PRIVILEGES',
		'SESSION_STATUS','SESSION_VARIABLES','STATISTICS','TABLES','TABLESPACES','TABLE_CONSTRAINTS',
		'TABLE_PRIVILEGES','TRIGGERS','USER_PRIVILEGES','VIEWS','INNODB_BUFFER_PAGE','INNODB_TRX',
		'INNODB_BUFFER_POOL_STATS','INNODB_LOCK_WAITS','INNODB_CMPMEM','INNODB_CMP','INNODB_LOCKS',
		'INNODB_CMPMEM_RESET','INNODB_CMP_RESET','INNODB_BUFFER_PAGE_LRU');
	
		$requete='
				
				SELECT DISTINCT TABLE_NAME
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_NAME NOT IN("'.implode('","', $Exos_list).'") AND TABLE_NAME NOT IN("'.implode('","', $tab).'")
AND TABLE_NAME NOT LIKE "VIEW_%" AND TABLE_NAME NOT LIKE "TMP_%" GROUP BY TABLE_NAME ;
				';
		$_SESSION['requete']=$requete;
		$result=$this->connexion->query($requete);
		
		if($result){
			return $result;
		}else {
			return null;
		}
		
	}

/**
 * Permet de récupérer tous les VHU actifs à ce jour
 * On récupère les centres vhu du fichier ICPE qui n'existent pas dans la BDD
 * [Centres_VHU_Actifs description]
 */
 public function Centres_VHU_Actifs(){
/*AND ACT_RAISON_SOCIALE NOT IN ("BAILLET \"PIECES AUTO OCCASION")*/
$requete='

SELECT DISTINCT
 act.ACT_RAISON_SOCIALE ,
 act.ACT_SIREN_SIRET ,
 act.ACT_REFERENCE ,
 act.ADR_CODE_POSTAL ,
 act.ADR_LOCALITE ,
 ins.FIL_CODE
FROM ACTEUR act
 JOIN INSCRIPTION ins ON ins.ACT_ID = act.ACT_ID
 JOIN FILIERE fil ON fil.FIL_CODE = ins.FIL_CODE
 JOIN STATUT_INSCRIPTION sin ON sin.SIN_CODE = ins.SIN_CODE
 JOIN CATEGORIE_ACTEUR cac ON cac.CAC_ID = ins.CAC_ID
 LEFT JOIN INS_TDN nn ON ins.INS_ID = nn.INS_ID
 LEFT JOIN TYPE_DECLARANT tdn ON tdn.TDN_ID = nn.TDN_ID
        AND tdn.FIL_CODE = ins.FIL_CODE
 JOIN PAYS pay ON pay.PAY_CODE = act.PAY_CODE
 LEFT JOIN CONTACT con_ref_act ON con_ref_act.ACT_ID = act.ACT_ID
         AND con_ref_act.CON_IS_REFERENT = 1
LEFT JOIN CONTACT con ON con.CON_ID = ins.INS_MODIFICATEUR
 LEFT JOIN PROFIL_FILIERE pfi ON pfi.INS_ID = ins.INS_ID
        AND pfi.PFI_IS_REFERENT = 1
  LEFT JOIN  CONTACT con_ref_fil ON con_ref_fil.CON_ID = pfi.CON_ID AND con_ref_fil.ACT_ID = act.ACT_ID

WHERE  sin.SIN_CODE = "INSCR"
AND ins.FIL_CODE = "VHU"
   AND cac.CAC_CODE = "DECIN"
   AND tdn.TDN_CODE = "CENTRE_VHU"

   ORDER BY act.ACT_RAISON_SOCIALE, act.ADR_CODE_POSTAL;';


$result=$this->connexion->query($requete);

if($result){
      return $result;

}   else{
	return null;

   }

}





}




