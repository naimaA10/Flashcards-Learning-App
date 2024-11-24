<?php
include 'accueil.php';
		
	if(isset($_POST['decksend'])){
		$tasTitre = htmlentities(trim($_POST['titre']));


		if(!empty($_POST['titre'])){
				//Récupérer données utiles pour inserer dans base de données
			$id = $_GET['idUnite'];
			$requser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
			$requser->execute(array($_SESSION['id']));
			$pseudo = $requser->fetch();
			$nomCreateur = $pseudo['pseudo'];

			$insertdeck = $bdd->prepare("INSERT INTO deck(idUnite,titre,createur) VALUES (?,?,?)");
			$insertdeck->execute(array($id,$tasTitre,$nomCreateur));

			$reqtas = $bdd->prepare("SELECT * FROM deck WHERE titre = ?");
			$reqtas->execute(array($tasTitre));
			$reqid = $reqtas->fetch();
			$idTas = $reqid['idTas'];

			header('Location: flashcard.php?id='.$_SESSION['id'].'&idUnite='.$_GET['idUnite'].'&idTas='.$idTas);
		}

		else {
			$message = "Veuillez remplir le champ";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Créer un tas</title>
	<link rel="stylesheet" type="text/css" href="../css/creer.css">
</head>
<body>

	<h2>Créer un tas</h2>
	<form method="post">

		<label for="titre">Titre :</label> <br/><br/>
		
		<input type="text" name="titre" value="<?php if(isset($titre)){echo $titre;}?>"> <br/><br/>

		<input type="submit" name="decksend" value="Créer un tas" /> <br/> <br/>

	</form>

	<?php 
		if(isset($message)){
			echo '<font color = "red">'.$message.'</font>';
		}
	?>

</body>
</html>