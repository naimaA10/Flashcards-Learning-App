<?php
session_start();
require_once('database.php');
//Récupérer la photo de profil
$photo= $bdd->prepare("SELECT * FROM users WHERE id= ?");
$photo->execute(array($_SESSION['id']));
$AffichePhoto = $photo->fetch();

//Voir si l'utilisateur est administrateur
$admin= $bdd->prepare("SELECT * FROM users WHERE pseudo= ?");
$admin->execute(array($AffichePhoto['pseudo']));
$Afficheadmin = $admin->fetch();

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/accueil.css">
</head>
<body>



	<nav>
	<ul  class="niveau1" >
		<li>
			<span>
			<img src="membres/photoProfil/<?= $AffichePhoto['photo'] ?>" width="40"/>
			</span>
			| <?= $AffichePhoto['pseudo'] ?>
			<ul>
				<li><a href="profil.php?id=<?= $_SESSION['id'] ?>">Profil</a></li>
				<?php if ($Afficheadmin['id'] == 1) : ?>
				<li><a href="admin.php">Administrateur</a></li>
				<?php endif ?>
				<li><a href="pageUnite.php?id=<?= $_SESSION['id'] ?>">Jouer</li>
				<li><a href="deconnexion.php">Déconnexion</a></li>
			</ul>
		</li>
	</ul>
	</nav>

	<footer>Crée par Ammiche Naïma et Vigneswaran Tharsiya</footer>

</body>
</html>