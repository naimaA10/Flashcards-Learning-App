<?php
	include 'accueil.php';
	
	if(isset($_SESSION['id']) AND !empty($_GET['idUnite'] AND !empty($_GET['idTas'] AND !empty($_GET['idCarte'])))){
		
		$supprcard = $bdd->prepare("DELETE FROM cartes WHERE idCarte = ?");
		$supprcard->execute(array($_GET['idCarte']));

		header('Location: pageCarte.php?id='.$_SESSION['id'].'&idUnite='.$_GET['idUnite'].'&idTas='.$_GET['idTas']);
	}

	else {
		$erreur = "Erreur dans la suppression";
		echo '<font color ="red">'.$erreur.'</font>';
	}
?>