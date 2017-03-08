<?php

class mypdo extends PDO {
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
		 echo 'hote: ' . $hote . ' ' . $_SERVER['DOCUMENT_ROOT'] . '<br />';
            echo 'Erreur : ' . $ex->getMessage() . '<br />';
            echo 'N° : ' . $ex->getCode();
            $this->connexion = false;
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
			case 'connexion': 
                return $this->connexion;
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

	
	
	
	public function verif_Siren_Siret($siren_siret)
	{
		$requete="SELECT ACT_RAISON_SOCIALE,REPLACE(ACT_SIREN_SIRET,' ','') FROM ACTEUR WHERE ACT_SIREN_SIRET=REPLACE('".$siren_siret."',' ','')";
		$result=$this->connexion->query($requete);
		if($result){
			return $result;
		}else{
			return null;
		}
	}
        
        
        /**
         * Cette requête permet de savoir si ce centre VHU existe
         * @param type $siren_siret
         * @return int
         */
        public function exists_vhu($siren_siret){
            $requete="SELECT ACT_RAISON_SOCIALE,REPLACE(ACT_SIREN_SIRET,' ','') FROM ACTEUR WHERE ACT_SIREN_SIRET=REPLACE('".$siren_siret."',' ','')";
            $result=$this->connexion->query($requete);
            if($result){
                return $result->rowCount();
            }else{
                return $result->rowCount();
            }
           
        }



}




