<?php
include 'accueil.php';

if(isset($_SESSION['id'])){
	$requeteuser = $bdd->prepare("SELECT * FROM users WHERE id = ?");
	$requeteuser->execute(array($_SESSION['id']));
	$infosuer = $requeteuser->fetch();

	if(isset($_POST['newpseudo']) && !empty($_POST['newpseudo']) && $_POST['newpseudo'] != $infosuer['pseudo']){
		$newpseudo = htmlentities(trim($_POST['newpseudo']));

		$requetenewpseudo = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
		$requetenewpseudo->execute(array($newpseudo));
		$newpseudoexist = $requetenewpseudo->rowCount();
		
		if($newpseudoexist == 0){

			$insertpseudo = $bdd->prepare("UPDATE users SET pseudo = ? WHERE id = ?");
			$insertpseudo->execute(array($newpseudo,$_SESSION['id']));
			header('Location: profil.php?id='.$_SESSION['id']);
		}
		else {
			$message = "Ce pseudo existe déjà";
		}
	}

	if(isset($_POST['newemail']) && !empty($_POST['newemail']) && $_POST['newemail'] != $infosuer['email']){
		$newemail = htmlentities(trim($_POST['newemail']));
		if(filter_var($newemail, FILTER_VALIDATE_EMAIL)){
			$requetenewemail = $bdd->prepare("SELECT * FROM users WHERE email = ?");
			$requetenewemail->execute(array($newemail));
			$newemailexist = $requetenewemail->rowCount();

			if($newemailexist == 0){
				$insertemail = $bdd->prepare("UPDATE users SET email = ? WHERE id = ?");
				$insertemail->execute(array($newemail,$_SESSION['id']));
				header('Location: profil.php?id='.$_SESSION['id']);
			}

			else {
				$message = "Cette adresse mail est utilisée";
			}
		}

		else {
			$message = "Ce mail n'est pas valide";
		}
	}

	if(isset($_POST['newpassword']) && !empty($_POST['newpassword']) && isset($_POST['newcpassword']) && !empty($_POST['newcpassword'])){
		$newpassword = md5($_POST['newpassword']);
		$newcpassword = md5($_POST['newcpassword']);
		if($newpassword == $newcpassword){
			$insertpassword = $bdd->prepare("UPDATE users SET password = ? WHERE id = ?");
			$insertpassword->execute(array($newpassword,$_SESSION['id']));
			header('Location: profil.php?id='.$_SESSION['id']);
		}

		else {
			$message = "Les deux mots de passe doivent être identiques";
		}
	}

	//Vérifier dans la file si la photoProfil est présente
	if(isset($_FILES['photoProfil']) AND !empty($_FILES['photoProfil']['name'])){
		$taillemax= 2097152; 
		$extensionsValides =array('jpg','jpeg','gif','png');
		//Vérifier la taille du fichier importer
		if ($_FILES['photoProfil']['size'] <= $taillemax) {
			$extensionUpload =strtolower(substr(strrchr($_FILES['photoProfil']['name'], '.'), 1));
			if(in_array($extensionUpload, $extensionsValides)){
				//Déplacement du fichier
				$chemin="membres/photoProfil/".$_SESSION['id'].".".$extensionUpload;
				$resultat= move_uploaded_file($_FILES['photoProfil']['tmp_name'], $chemin);
				if($resultat){
					$insertphoto= $bdd->prepare("UPDATE users SET photo = :photo WHERE id= :id");
					$insertphoto->execute(array(
						'photo' => $_SESSION['id'].".".$extensionUpload,
						'id' => $_SESSION['id']
					));
					header('Location: profil.php?id='.$_SESSION['id']);

				}else {
					$message="Erreur durant l'imporation de votre photo de profil";
				}
			}else{
				$message="Votre photo de profil doit être au format jpg, jpeg, gif ou png";
			}
		}else{
			$message="Votre photo de profil ne doit pas dépasser 2Mo";
		}
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edition de profil</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/edition.css">
</head>
<body>

	<h2>Editer mon profil</h2>
	<form method="POST" action="" enctype="multipart/form-data">
		<label for="newpseudo"> Pseudonyme :</label> <br/> <br/>
		<input type="text" name="newpseudo" id="newpseudo" autofocus 
		value=
		"<?php echo $infosuer['pseudo'] ?>" />
		<br/> <br/>

		<label for="newemail">Email :</label> <br/> <br/>
		<input type="email" name="newemail" id="newemail"value="<?php echo $infosuer['email'] ?>"/> <br/> <br/>

		<label for="newpassword">Mot de passe :</label> <br/> <br/>
		<input type="password" name="newpassword" id="newpassword"/> <br/> <br/>

		<label for="newcpassword">Confirmer votre mot de passe :</label> <br/> <br/>
		<input type="password" name="newcpassword" id="newcpassword"/> <br/> <br/>
		
		<label>Photo de profil :</label>
		<input type="file" name="photoProfil"> <br/> <br/>
		<input class="button" type="submit" value="Editer" /> <br/> <br/>
	</form>

	<?php 
		if(isset($message)){
			echo $message;
		} 
	?>

</body>
</html>