<?php
      
class mypdo_SydPHP_Excel extends PDO{
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
			case 'connexion': return $this->connexion;
			break;
		}
		
	}
    
    
    public function interrupteur()
    {
        $requete='SELECT * FROM interrupteur';
        $result=$this->connexion->query($requete);
        if($result){
            return $result;
        }else
        {
            return null;
        }
    }
    
    public function maj_interrupteur($num)
    {
        $requete='UPDATE interrupteur SET I_ID="'.$num.'"';
        $result=$this->connexion->query($requete);
        if($result){
            return $result;
        }else
        {
            return null;
        }
    }
    
     public function couleur($num)
    {
        $requete='SELECT * FROM couleur WHERE C_ID="'.$num.'"';
        $result=$this->connexion->query($requete);
        if($result){
            return $result;
        }else
        {
            return null;
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
    
     public function maj_info_fichier()
    {
        date_default_timezone_set('Europe/Paris');
        $date = new Datetime();
        $date=$date->format('Y-m-d H:i:s');
        
        $requete='INSERT INTO historique SET HIS_DATETIME="'.$date.'", F_ID="1" ';
        $result=$this->connexion->query($requete);
        if($result){
            return $result;
        }else
        {
            return null;
        }
    }
    
    public function version()
    {
        $requete='SELECT * FROM version';
        $result=$this->connexion->query($requete);
        if($result){
            return $result;
        }else
        {
            return null;
        }
    }
    
     public function final_name()
    {
        $requete='SELECT * FROM nom_Final';
        $result=$this->connexion->query($requete);
        if($result){
            return $result;
        }else
        {
            return null;
        }
    }
    
    public function maj_final_name($name)
    {
        $requete='UPDATE table nom_Final SET nom="'.$name.'"';
        $result=$this->connexion->query($requete);
        if($result){
            return $result;
        }else
        {
            return null;
        }
    }
    
    
}