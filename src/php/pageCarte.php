<?php 
include 'accueil.php';
	
	//Insertion dans historique, pour les tas consultés
	$time = $bdd->prepare("SELECT * FROM historique WHERE idUser = ? AND idTas = ?");
	$time->execute(array($_SESSION['id'],$_GET['idTas']));
	$exist = $time->rowCount();

	if(!empty($_GET['id']) AND !empty($_GET['idUnite']) AND !empty($_GET['idTas'])){
		$idUnite = $_GET['idUnite'];
		$idTas = $_GET['idTas']; 
		$id = $_GET['id'];

		if($exist == 0){
		$insere = $bdd->prepare("INSERT INTO historique(idUser,idTas,date_cliquee) VALUES(?,?,?)");
		$insere->execute(array($_SESSION['id'],$_GET['idTas'],date('Y-m-d H:i:s')));

		}
		else {
			$update = $bdd->prepare("UPDATE historique SET date_cliquee = ? WHERE idTas = ? AND idUser = ?");
			$update->execute(array(date('Y-m-d H:i:s'),$_GET['idTas'],$_SESSION['id']));
		}

	} 

	else if(empty($_GET['idTas'])){
		header('Location:pageTas.php?id='.$_SESSION['id'].'&idUnite='.$_GET['idUnite']);
	}

	else if(empty($_GET['idUnite'])) {
		header('Location:pageUnite.php?id='.$_SESSION['id']);	

	}

	else {
		header('Location:connexion.php');
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Consulter les cartes</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/pageCarte.css" />
</head>
<body>

	<h2>Consulter les cartes </h2>
	<?php
	$reqidc = $bdd->prepare("SELECT * FROM cartes WHERE idTas = ?");
	 $reqidc->execute(array($idTas));
	 while($val = $reqidc->fetch()){ ?>
	
	
	<div class="recto">
		<p>Question : <br/> <br/> <?= $val['question']; ?></p>
	</div> <br/><br/>
	<div class="verso">
		<p>Réponse : <br/><br/> <?= $val['reponse']; ?></p> 
	</div> <br/><br/>

	<?php 
//Chercher createur du tas
		$req = $bdd->prepare("SELECT * FROM deck WHERE idTas = ?");
		$req->execute(array($_GET['idTas']));
		$nom = $req->fetch();


//Chercher id du créateur
		$reqbis = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
		$reqbis->execute(array($nom['createur']));
		$valeur = $reqbis->fetch();

//Seul celui qui a créé le tas peut modifier, ajouter ou supprimer les cartes
		if($_SESSION['id'] == $valeur['id']){
			?>
			 <p><a href="modifiercard.php?id=<?=$_SESSION['id'];?>&idUnite=<?=$_GET['idUnite'];?>&idTas=<?=$_GET['idTas']?>&idCarte=<?=$val['idCarte'];?>">Modifier carte </a> -

			 <a href="addcard.php?id=<?=$_SESSION['id'];?>&idUnite=<?=$_GET['idUnite'];?>&idTas=<?=$_GET['idTas']?>">Ajouter carte </a> -

			 <a href="delcard.php?id=<?=$_SESSION['id'];?>&idUnite=<?=$_GET['idUnite'];?>&idTas=<?=$_GET['idTas']?>&idCarte=<?=$val['idCarte'];?>">Supprimer carte </a></p>


			<br/><br/>
		<?php
		}
	}

	?>
<div id="etudier">
	<a style="text-decoration:none" href="study.php?id=<?=$_SESSION['id'];?>&idUnite=<?=$_GET['idUnite'];?>&idTas=<?=$_GET['idTas'];?>">Tester</a> 
</div> <br/><br/>
</body>
</html>