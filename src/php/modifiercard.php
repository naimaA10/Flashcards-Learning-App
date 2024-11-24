<?php
include 'accueil.php';

$idCarte = $_GET['idCarte'];

//Retrouver la carte à modifier
$req = $bdd->prepare("SELECT * FROM cartes WHERE idCarte = ?");
$req->execute(array($idCarte));
$modif = $req->fetch();

if(isset($_POST['cardmodified'])){
		
	if(!empty($_POST['newquestion'] && !empty($_POST['newanswer']))){
			$newquestion = htmlentities(trim($_POST['newquestion']));
			$newanswer = htmlentities(trim($_POST['newanswer']));
			$newniveau = $_POST['newniveau'];

			//Remplacer les anciens éléments par les nouvelles données

			$upquestion = $bdd->prepare("UPDATE cartes SET question = ? WHERE idCarte = ?");
			$upquestion->execute(array($newquestion,$_GET['idCarte']));

			$upanswer = $bdd->prepare("UPDATE cartes SET reponse = ? WHERE idCarte = ?");
			$upanswer->execute(array($newanswer,$_GET['idCarte']));

			$upniveau = $bdd->prepare("UPDATE cartes SET niveau = ? WHERE idCarte = ?");
			$upniveau->execute(array($newniveau,$_GET['idCarte']));

			header('Location:pageCarte.php?id='.$_SESSION['id'].'&idUnite='.$_GET['idUnite'].'&idTas='.$_GET['idTas']);
			
		}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Modifier une carte</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../css/creer.css">
</head>
<body>
	<h2>Modifier une carte</h2>
	<form method="post">
		<h5>Question</h5>
		<textarea id="newquestion" name="newquestion"value="<?php if(isset($newquestion)){echo $newquestion;}?>"></textarea> <br/> <br/>

		<h5>Réponse</h5>
		<textarea id="newanswer" name="newanswer"value="<?php if(isset($newanswer)){echo $newanswer;}?>"></textarea> <br/> <br/>


		<label for="niveau">Niveau de difficulté :</label> <br/><br/>
		<input type="range" name="newniveau" min = "1" max="5" value="<?php if(isset($newniveau)){echo $newniveau;}?>"> <br/><br/>

		<input type="submit" name="cardmodified" value="Modifier" /> <br/> <br/>


	</form>

</body>
</html>