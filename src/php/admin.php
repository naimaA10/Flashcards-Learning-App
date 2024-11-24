<?php 
include 'accueil.php';

	if($_SESSION['id'] == 1){
		$membre = $bdd->query('SELECT * FROM users ORDER BY id DESC');

		$tas = $bdd->query('SELECT * FROM deck ORDER BY idTas DESC');

	}

	else {
		exit();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/admin.css" />
	<title>Page d'administration</title>
</head>
<body>
	<h3>Liste des membres</h3>
	
		<table>
			<tr>
				<th>Identifiant</th>
				<th>Pseudonyme</th>
				<th>Adresse électronique</th>
				<th></th>
			</tr>
			<tr>
		<?php while($affiche = $membre->fetch()) { 
			$reqinfo = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
			$reqinfo->execute(array($affiche['pseudo']));
			$val = $reqinfo->fetch(); ?>
			<td><?=$affiche['id']?></td>
			<td><?=$affiche['pseudo']?></td>
			<td><?=$affiche['email']?></td>
		
		<td>
		 <a href="suppressioncompte.php?id=<?= $affiche['id'] ?>">Supprimer </a></td> </tr>
		 <?php } ?> 
		</table>
		<br/>
	
	
		<h3>Liste des tas</h3>
		<table>
			<tr>
				<th>Identifiant</th>
				<th>Titre du tas</th>
				<th>Créateur</th>
				<th></th>
			</tr>
			<tr>
		<?php while($tasaffiche = $tas->fetch()) { 
			$req = $bdd->prepare("SELECT * FROM deck WHERE idTas = ?");
			$req->execute(array($tasaffiche['idTas']));
			$valeur = $req->fetch(); ?>
			<td><?=$tasaffiche['idTas']?></td>
			<td><?=$tasaffiche['titre']?></td>
			<td><?=$tasaffiche['createur']?></td>
		
		<td>
		<a href="deltas.php?idTas=<?=$tasaffiche['idTas']?>">Supprimer </a> </td></tr>
		 <?php } ?>
		</table>
		<br/>

</body>
</html>
