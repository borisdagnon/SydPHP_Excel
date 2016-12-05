<?php

class controleur{
	
	private $vpdo;
	private $db;
	
	public function __construct(){
		$db=new mypdo();
		$vpdo=$db->__get('connexion');
	}
	
	public function connexion()
	{
		$form="";
		
		$form.='
				
<div class="login-page">
      <div class="form">
          <form class="register-form">
              <input type="text" placeholder="name"/>
                  <input type="password" placeholder="password"/>
                      <input type="text" placeholder="email address"/>
                          <button>create</button>
                        <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>
				
    <form class="login-form">
          <input type="text" placeholder="username"/>
             <input type="password" placeholder="password"/>
                 <button>login</button>
              <p class="message">Not registered? <a href="#">Create an account</a></p>
         </form>
     </div>
</div>
				<script type="text/javascript" src="./js/js_perso.js"> </script>
				';
		return $form;
	}
	
	
	public function acceuil()
	{
		$form="";
		
		$form.='
				<h1>Bienvenu sur le site de mise à jour Excel<h1>
				
				<p>Ici vous pouvez mettre votre fichier Tables Sysderep_V2 à jour <p>
				
				';
		
		return $form;
	}
	
	
}
