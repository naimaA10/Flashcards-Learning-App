<?php
	include 'accueil.php';
	
	if(!empty($_SESSION['id'])) {

		$supprtas = $bdd->prepare("DELETE FROM deck WHERE idTas = ?");
		$supprtas->execute(array($_GET['idTas']));

		$supprcartes = $bdd->prepare("DELETE FROM cartes WHERE idTas = ?");
		$supprcartes->execute(array($_GET['idTas']));
		header('Location:admin.php?id='.$_SESSION['id']);
	}

	else {
	 	echo "Le compte n'a pas pu être supprimé";
	}
?>