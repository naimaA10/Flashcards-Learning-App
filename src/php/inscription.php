<?php 

	require_once('database.php');
	
	if(isset($_POST['formsend'])){

		$pseudo = htmlentities(trim($_POST['pseudo']));
		$email = htmlentities(trim($_POST['email']));
		$password = htmlentities(trim($_POST['password']));
		$confirmpassword = htmlentities(trim($_POST['confirmpassword']));
		$passwordhache = md5($password);
			
		if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmpassword'])){
			//Le pseudo doit être compris entre 3 et 15 caractères
			if(strlen($pseudo)>2 && strlen($pseudo)<16){

				//Vérification de la validité du mail
				if(filter_var($email, FILTER_VALIDATE_EMAIL)){

					$requetemail = $bdd->prepare("SELECT * FROM users WHERE email = ?");
					$requetemail->execute(array($email));
					$emailexist = $requetemail->rowCount();
					
					//Unicité du mail	
					if($emailexist == 0){

						$requetepseudo = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
						$requetepseudo->execute(array($pseudo));
						$pseudoexist = $requetepseudo->rowCount();

						//Unicité du pseudo
						if($pseudoexist == 0){
							
							if($password == $confirmpassword){

								$insertuser = $bdd->prepare("INSERT INTO users(pseudo,email,password,photo) VALUES(?,?,?,?)");
									$insertuser->execute(array($pseudo,$email,$passwordhache,"default.png"));
								header('Location:connexion.php');

							}

							else {
								$erreur = "Vos mots de passe ne sont pas identiques";
							}
						}
						else {
							$erreur = "Ce pseudo existe déjà";
						}
					}

					else {
						$erreur = "Cette adresse mail est utilisée";
					}
				}

				else {
					$erreur = "Votre adresse mail n'est pas valide";
				}
					
			}

			else {
				$erreur = "Le pseudo doit être compris entre 3 et 15 caractères";
			} 
		}
		else {
			$erreur = "Tous les champs doivent être remplis";
		}
	}
	 
?>

<!DOCTYPE html>

<html>
<head>
	<title>Page d'inscription</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="../css/inscription.css" />
</head>
<body>
	<h3>Inscrivez-vous</h3>	

	<form method="post">

		<input type="text" name="pseudo" id="pseudo" placeholder="Pseudonyme" autofocus value="<?php if(isset($pseudo)){echo $pseudo;}?>"/> <br/> <br/>
		
		<input type="email" name="email" id="email" placeholder="Adresse électronique"value="<?php if(isset($email)){echo $email;}?>"/> <br/> <br/>
		
		<input type="password" name="password" id="password" placeholder="Mot de passe" /> <br/> <br/>
		
		<input type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirmer mot de passe" /> <br/> <br/>
		
		<input type="submit" name="formsend" value="S'inscrire" /> <br/> <br/>

		<p>Vous avez déjà un compte ?
		<a style="text-decoration:none" class="stylebouton" href ="connexion.php">Connectez-vous</a>
		</p>
		
	</fieldset>
	</form>
	
	<?php 
		if(isset($erreur)){
			echo '<font color="red"'.$erreur.'</font>';
		} 
	?>


</body>
</html>