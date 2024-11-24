<?php
include 'accueil.php';

if(isset($_POST['cardadded'])){
	
	if(!empty($_POST['addquestion'] && !empty($_POST['addanswer']))){
			$addquestion = htmlentities(trim($_POST['addquestion']));
			$addanswer = htmlentities(trim($_POST['addanswer']));
			$addniveau = $_POST['addniveau'];

			$insere = $bdd->prepare("INSERT INTO cartes(idTas,question,reponse,niveau) VALUES (?,?,?,?)");
			$insere->execute(array($_GET['idTas'],$addquestion,$addanswer,$addniveau));


			header('Location:pageCarte.php?id='.$_SESSION['id'].'&idUnite='.$_GET['idUnite'].'&idTas='.$_GET['idTas']);
			
		}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ajouter une carte</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../css/creer.css">
</head>
<body>
	<h2>Ajouter une carte</h2>
	<form method="post">
		<h5>Question</h5>
		<textarea id="addquestion" name="addquestion"value="<?php if(isset($addquestion)){echo $addquestion;}?>"></textarea> <br/> <br/>

		<h5>Réponse</h5>
		<textarea id="addanswer" name="addanswer"value="<?php if(isset($addanswer)){echo $addanswer;}?>"></textarea> <br/> <br/>


		<label for="niveau">Niveau de difficulté :</label> <br/><br/>
		<input type="range" name="addniveau" min = "1" max="5" value="<?php if(isset($addniveau)){echo $addniveau;}?>"> <br/><br/>

		<input type="submit" name="cardadded" value="Ajouter" /> <br/> <br/>


	</form>

</body>
</html>