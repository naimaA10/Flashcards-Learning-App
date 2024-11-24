<?php 
	include 'accueil.php';

	$requnite = $bdd->query(('SELECT nom FROM unites'));

?>

<!DOCTYPE html>
<html>
<head>
	<title>Consulter les unités</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../css/pageUnite.css" />
</head>
<body>

	<h2>Sélectionner une unité d'apprentissage :</h2>
	<?php 
		//Afficher les noms des unités qui ont été créées
		while($affiche = $requnite->fetch()){
			$reqidu = $bdd->prepare("SELECT * FROM unites WHERE nom = ?");
			$reqidu->execute(array($affiche['nom']));
			$val = $reqidu->fetch();
			?>

			<div id="unit">
				<a style="text-decoration:none" href="pageTas.php?id=<?php echo $_SESSION['id'];?>&idUnite=<?php echo $val['idUnite']; ?>"> <?php echo $affiche['nom']?></a> 
			</div>
		<?php 
		}
		
	?>
	<div id="newunit">
		<a style="text-decoration:none" href="newUnite.php?id=<?php echo $_SESSION['id']; ?>">Créer une nouvelle unité </a> 
	</div>
	
</body>
</html>