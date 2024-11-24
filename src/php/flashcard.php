<?php 
include 'accueil.php';

	if(isset($_POST['cardsend'])){
		$question = htmlentities(trim($_POST['question']));
		$answer = htmlentities(trim($_POST['answer']));
		$niveau = $_POST['niveau'];
		$idTas = $_GET['idTas'];
	

		if(!empty($_POST['question']) && !empty($_POST['answer'] && !empty($_POST['niveau']))){
			$insertcard = $bdd->prepare("INSERT INTO cartes(idTas, question,reponse,niveau) VALUES (?,?,?,?)");
			$insertcard->execute(array($idTas,$question,$answer,$niveau));
			header('Location:flashcard.php?id='.$_SESSION['id'].'&idUnite='.$_GET['idUnite'].'&idTas='.$idTas);
			
		}
	}

//Traitement quand on crée la dernière carte du tas
	if(isset($_POST['deckfinishsend'])){
		$question = htmlentities(trim($_POST['question']));
		$answer = htmlentities(trim($_POST['answer']));
		$niveau = $_POST['niveau'];
		$tas = $_GET['idTas'];
	

		if(!empty($_POST['question']) && !empty($_POST['answer'] && !empty($_POST['niveau']))){
			$insertcard = $bdd->prepare("INSERT INTO cartes(idTas,question,reponse,niveau) VALUES (?,?,?,?)");
			$insertcard->execute(array($tas,$question,$answer,$niveau));
			header('Location:pageCarte.php?id='.$_SESSION['id'].'&idUnite='.$_GET['idUnite'].'&idTas='.$tas);
			
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Créer une carte</title>
	<link rel="stylesheet" type="text/css" href="../css/creer.css">
</head>
<body>
	<h2>Créer une carte</h2>
	<form method="post">
		<h5>Question</h5>
		<textarea id="question" name="question"value="<?php if(isset($question)){echo $question;}?>"></textarea> <br/> <br/>
		
		<h5>Réponse</h5>
		<textarea id="answer" name="answer"value="<?php if(isset($answer)){echo $answer;}?>"></textarea> <br/> <br/>

		<label for="niveau">Niveau de difficulté :</label> <br/><br/>
		<input type="range" name="niveau" min = "1" max="5" value="<?php if(isset($niveau)){echo $niveau;}?>"> <br/><br/>

		<input type="submit" name="cardsend" value="Créer une carte" /> <br/> <br/>

		<input type="submit" name="deckfinishsend" value="Dernière carte" /> <br/> <br/> <!-- Dernière carte du lot -->

	</form>

</body>
</html>