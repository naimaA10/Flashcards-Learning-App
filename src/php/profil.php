<?php
session_start();
require_once('database.php');


if(isset($_GET['id'])){
	$getId = intval($_GET['id']);
	$requeteuser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
	$requeteuser->execute(array($getId));
	$infouser = $requeteuser->fetch();
}

else {
	header("Location:connexion.php");
}

//Affichage tas

$reqtas= $bdd->prepare('SELECT * FROM deck WHERE createur = ?');
$reqtas->execute(array($infouser['pseudo']));

//Affichage tas consultés
$reqconsult = $bdd->prepare("SELECT * FROM historique WHERE idUser = ? ORDER BY date_cliquee DESC");
$reqconsult->execute(array($_SESSION['id']));

?>

<html>
<head>
	<title>Profil</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../css/profil.css"/>
</head>
<body>

	<span class="jeu"><a style="text-decoration:none" href="pageUnite.php?id=<?= $_SESSION['id'] ?>">Jouer</a></span>
	<h2>Profil</h2>	

	<br/>
	<div id="profil">
		<div class="container"> 
		<?php if(!empty($infouser['photo'])) : ?>
		<img src="membres/photoProfil/<?= $infouser['photo'] ?>" width="150"/> 
		<?php endif ?> </div> <br/> <br/>
		<?php echo $infouser['pseudo'];?>  <br/> <br/>
		<?php echo $infouser['email'];?> <br/><br/>
	</div>


	<?php
	if($infouser['id'] == $_SESSION['id']){
	?>

	<h3>Vos tas :</h3>
	<div id="tasperso">
		<ul>
	<?php while ($affichetas= $reqtas->fetch()) : ?>
			<li class="inline"><a style="text-decoration:none" href="pageCarte.php?id=<?= $_SESSION['id'] ?>&idTas=<?= $affichetas['idTas']; ?>"> <?= $affichetas['titre']?></a></li><br/>
	<?php endwhile ?> </ul> </div> 
	<br/><br/>

	<h3>Tas consultés recémment :</h3>
	<div id="tasrecent">
		<ul>
	<?php 
		while ($afficheconsult = $reqconsult->fetch()): 
			$reqconsulttitre = $bdd->prepare("SELECT * FROM deck WHERE idTas = ?");
			$reqconsulttitre->execute(array($afficheconsult['idTas']));
			$affichetitre = $reqconsulttitre->fetch();

			?>
			<li class="inlines"><a style="text-decoration:none" href="pageCarte.php?id=<?= $_SESSION['id'] ?>&idUnite=<?=$affichetitre['idUnite']?>&idTas=<?= $afficheconsult['idTas']; ?>"> <?= $affichetitre['titre'].' ('.$afficheconsult['date_cliquee'].')'?></a></li><br/>
	<?php endwhile ?></ul></div>
	<br/><br/>

<div id="liens">
	<p><a href="edition.php?id=<?=$_SESSION['id'];?>">Modifier mon profil</a> -
	<a href="deconnexion.php">Se déconnecter</a> </p></div> <br/><br/>
	<?php
	}
	?>

</body>
</html>