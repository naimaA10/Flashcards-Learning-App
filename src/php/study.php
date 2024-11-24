<?php
include 'accueil.php';

//Vérification qu'on est bien dans le bon lien
if(!empty($_SESSION['id']) && !empty($_GET['idUnite']) && !empty($_GET['idTas'])){ 

	//Chercher les cartes du tas sélectionné
	
	$req = $bdd->prepare("SELECT * FROM cartes WHERE idTas = ? ORDER BY niveau ASC");
	$req->execute(array($_GET['idTas']));

	echo '<h2>Etudier les cartes</h2>';

	//Afficher les réponses afin que l'utilisateur vérifie lui-même
	
	while($val = $req->fetch()){ 
		
		if(isset($_POST['reponse']) AND isset($_POST['showreponse'])){
			$rep = $val['reponse'];
}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Tester</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/study.css">
</head>
<body>

	<div class="recto">
		<p>Question : <?= $val['question']; ?></p>
	</div>
	<form method="post">
		<textarea id="reponse" name="reponse" placeholder="Entrer votre réponse" value="<?php if(isset($_POST['reponse'])){echo $_POST['reponse'];}?>"></textarea></br>

		<?php if(isset($rep)){ echo $rep; }  } }?>

	<br/><br/>
		<input class="button" type="submit" name="showreponse" value="Voir réponses"><br/>
	
	</form>

</body>
</html>