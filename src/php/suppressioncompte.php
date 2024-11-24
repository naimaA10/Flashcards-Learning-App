<?php
	include 'accueil.php';

	if(isset($_SESSION['id'])){
//Pseudo du détenteur de l'id
		$req = $bdd->prepare("SELECT * FROM users WHERE id = ?");
		$req->execute(array($_GET['id']));
		$info = $req->fetch();

//IdTas du créateur
		$reqbis = $bdd->prepare("SELECT * FROM deck WHERE createur = ?");
		$reqbis->execute(array($info['pseudo']));
		$infobis = $reqbis->fetch();

//Suppression de toutes ses cartes, tas et membre
		$supprcard = $bdd->prepare("DELETE FROM cartes WHERE idTas = ?");
		$supprcard->execute(array($infobis['idTas']));
		$supprdeck = $bdd->prepare("DELETE FROM deck WHERE createur = ?");
		$supprdeck->execute(array($info['pseudo']));
		$suppruser = $bdd->prepare("DELETE FROM users WHERE id = ?");
		$suppruser->execute(array($_GET['id']));
		header('Location:admin.php?id='.$_SESSION['id']);
	}

	else {
		$message = "Le compte n'a pas pu être supprimé";
		echo '<font color = "red">'.$message.'</font>';
	}
?>