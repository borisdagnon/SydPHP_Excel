<?php

class mypdo{
private $utilisateur='root';
	private $mdp='';
	private $bdd='sydphp_excel';
	private $hote='localhost';


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
    
    
    
    public function info_fichier()
    {
        $requete='SELECT * FROM fichier f INNER JOIN historique h ON f.F_ID=h.F_ID';
        $result=$this->connexion->query($requete);
        if($result){
            return $result;
        }else
        {
            return null;
        }
    }
    
}