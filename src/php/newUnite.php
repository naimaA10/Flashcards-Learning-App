<?php
include 'accueil.php';

	if(isset($_POST['nomUniteSend'])){
		$nomUnite = htmlentities(trim($_POST['nomUnite']));
			
		if(!empty($_POST['nomUnite'])){
			$requnite = $bdd->prepare("SELECT * FROM unites WHERE nom = ?");
			$requnite->execute(array($nomUnite));
			$uniteexist = $requnite->rowCount();

			//Unicité de l'unité d'apprentissage
			if($uniteexist == 0){
				$insertunite = $bdd->prepare("INSERT INTO unites(nom) VALUES (?)");
				$insertunite->execute(array($nomUnite));

				$newrequnite = $bdd->prepare("SELECT * FROM unites WHERE nom = ?");
				$newrequnite->execute(array($nomUnite));
				$reqid = $newrequnite->fetch();
				$valeur = $reqid['idUnite'];

				header('Location: tas.php?id='.$_SESSION['id'].'&idUnite='.$valeur);

			}

			else {
				$message = "Cette unité existe déjà";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Créer une unité</title>
	<link rel="stylesheet" type="text/css" href="../css/creer.css">
</head>
<body>

	<h2>Créer une nouvelle unité d'apprentissage</h2>
	<form method="post">
		<label>Nom de l'unité :</label> <br/> <br/>
		<input type="text" name="nomUnite"> <br/> <br/>

		<input type="submit" name="nomUniteSend" value="Créer une unité">
	</form>

	<?php 
	if(isset($message)){
		echo '<font color="red">'.$message.'</font>';
	}
	?>

</body>
</html>