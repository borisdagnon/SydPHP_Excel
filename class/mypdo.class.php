<?php

class mypdo{
	private $utilisateur='syderep_ro_ademe';
	private $mdp='syderep_ro_ademe';
	private $bdd='syderep_intcont';
	private $hote='10.1.12.95';
	
	private $connexion;

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
	
	public function __get($prop){
		switch ($prop){
			case 'connexion': return $this->connexion;
			break;
		}
		
	}
	
	public function list_tables($tab)
	{
		
			$requete='SELECT DISTINCT TABLE_NAME, COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME  IN ("'.implode('", "', $tab).'")
    AND TABLE_SCHEMA="syderep_intcont"
GROUP BY TABLE_NAME ORDER BY TABLE_NAME ASC
	';
			$_SESSION['requete']=$requete;
			/*var_dump($_SESSION['requete']);*/
			$result=$this->connexion->query($requete);
			if($result){
				return $result;
			}
			return null;
	}
	
	
	public function nb_liens($col_name){
		
		$requete='SELECT COUNT(COLUMN_NAME)-1
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
}




