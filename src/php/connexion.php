<?php 
	session_start();
	require_once('database.php');
	
	if(isset($_POST['formconnect'])){
		$pseudo = htmlentities(trim($_POST['pseudo']));
		$password = md5($_POST['password']);
		 

		if(!empty($pseudo) && !empty($password)){
			//Cherchez si le pseudo et le mot de passe existent et sont corrects
			$requetepseudo = $bdd->prepare("SELECT * FROM users WHERE pseudo = ? && password = ?");
			$requetepseudo->execute(array($pseudo,$password));
			$pseudoexist = $requetepseudo->rowCount();

			if($pseudoexist == 1){
				$pseudoinfo = $requetepseudo->fetch();
				$_SESSION['id'] = $pseudoinfo['id'];
				header("location: pageUnite.php?id=".$_SESSION['id']);
			}
			else {
				$erreur = "Nom d'utilisateur ou mot de passe incorrect";
			}

		}
		else {
			$erreur = "Tous les champs doivent être remplis";
		}
	}

	if(isset($_POST['noform'])){
		header('Location:inscription.php');
	}
	?>
	

<!DOCTYPE html>

<html>
<head>
	<title>Page de connexion</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/connexion.css" />
</head>
<body>
	<h3>Connectez-vous</h3>	

	<form method="post">
		
		<label for="pseudo"> Pseudonyme :</label> 
		<input type="text" name="pseudo" id="pseudo" autofocus 
		value="<?php if(isset($pseudo)){echo $pseudo;}?>"/> 
		<br/> <br/>

		<label for="password">Mot de passe :</label> 
		<input type="password" name="password" id="password"/> <br/> <br/>
		
		<div id="connect">
			<input type="submit" name="formconnect" value="Connexion" /> 
		</div><br/> <br/>

		<a href="mdpoublie.php">Mot de passe oublié ?</a>

		<br/><br/><br/><br/>
		<p>Vous n'avez pas de compte ?
		<div id="register">
			<input type="submit" name="noform" value="Inscrivez-vous !" />
		</div>
		</p>
		
	</form>
	
	<?php 
		if(isset($erreur)){
			echo '<font color = "red" >'.$erreur.'</font>';
		}
	?>


</body>
</html>