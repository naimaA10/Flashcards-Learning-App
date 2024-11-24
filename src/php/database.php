<?php 
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=siteweb','root','');
	}

	catch(PDOException $e){
		print "Erreur de connexion à la base de donnée : ".$e->getMessage();
		die();
	}
 ?>