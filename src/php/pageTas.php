<?php 
include 'accueil.php';
	
	$reqtas = $bdd->prepare('SELECT * FROM deck WHERE idUnite = ?');
	$reqtas->execute(array($_GET['idUnite']));
	if(empty($_SESSION['id'])) {
		header('Location:connexion.php');
	}
	if(empty($_GET['idUnite'])) {
	 	header('Location:pageUnite.php?id='.$_SESSION['id']);
	 }
			
?>

<!DOCTYPE html>
<html>
<head>
	<title>Consulter les tas de carte</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/pageTas.css" />
</head>
<body>

	<h2>Sélectionner un tas de carte :</h2>
	<?php 

	//Afficher tous les tas de cartes qui ont été créés avec leur titre et le pseudo du créateur
		while ($affiche = $reqtas->fetch()){ 
			$reqidt = $bdd->prepare("SELECT * FROM deck WHERE titre = ? AND idUnite = ?");		
			$reqidt->execute(array($affiche['titre'],$_GET['idUnite']));
			$val = $reqidt->fetch();

	?>
	<div id="cartes">
		
			<a style="text-decoration:none" href="pageCarte.php?id=<?= $_SESSION['id']; ?>&idUnite=<?= $_GET['idUnite']; ?>&idTas=<?= $val['idTas'];?>"> <?= $val['titre'] ?> de <?= $val['createur']?></a> 

		</div>
	<?php  }
	?>
			
	<br><br>

	<div id="newtas">	
		<a style="text-decoration:none" href="tas.php?id=<?= $_SESSION['id']; ?>&idUnite=<?= $_GET['idUnite']; ?>">Créer un nouveau tas </a>
	</div>


</body>
</html>

