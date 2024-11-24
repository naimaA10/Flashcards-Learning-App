<?php
session_start();
require_once('database.php');

if(isset($_GET['section'])){
	$section= htmlspecialchars($_GET['section']);
} else {
	$section ="";
}

if (isset($_POST['recup_submit']) AND isset($_POST['recup_email'])) {
	if(!empty($_POST['recup_email'])){
		$email= htmlspecialchars($_POST['recup_email']);
		//Vérifier que l'adresse email est valide (avec un @ et un .fr  ou .com)
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			//Vérifier que l'adresse email existe dans la bdd et récupére le pseudo de l'utilisateur
			$email_exist= $bdd->prepare('SELECT id,pseudo FROM users WHERE email = ?');
			$email_exist->execute(array($email));
			$email_exist_count = $email_exist->rowCount();
			if($email_exist_count == 1){
				$pseudo = $email_exist->fetch();
				$pseudo = $pseudo['pseudo'];
				$_SESSION['recup_mail'] = $email;
				//création d'un nombre aléatoire de récupération à 8 chiffres
				$recup_code="";
				for ($i=0; $i <= 8 ; $i++) { 
					$recup_code .= mt_rand(0,9); 
				}										
				//Vérifier si l'email est déjà dans la table recuperation (donc l'utilisateur a déjà cliquer sur Validez pour son mdp oublier)
				$email_recup_exist= $bdd->prepare('SELECT idRecup FROM recuperation WHERE email= ?');
				$email_recup_exist->execute(array($email));
				$email_recup_exist= $email_recup_exist->rowCount();
				if($email_recup_exist == 1){
					//mettre à jour le code envoyer
					$insert = $bdd->prepare('UPDATE recuperation SET code= ? WHERE email= ?');
					$insert->execute(array($recup_code,$email));

				}
				else {
					//enregistrer dans la bdd
					$insert = $bdd->prepare('INSERT INTO recuperation(email,code) VALUES (?,?)');
					$insert->execute(array($email,$recup_code));
				}
				$header="MIME-Version: 1.0\r\n";
         		$header.='From:"siteweb.com"<flashitio2@gmail.com>'."\n"; //info sur l'expéditeur

        //message envoyer par email à l'utilisateur
        $message= '
        <html>
         <head>
           <title>Récupération de mot de passe - Jeu Carte Memoire</title>
           <meta charset="utf-8" />
         </head>
         <body>
           <font color="#303030";>
             <div align="center">
               <table width="600px">
                 <tr>
                   <td>                   
                     <div align="center">Bonjour <b>'.$pseudo.'</b>,</div>
                     Voici votre code de récupération: <b>'.$recup_code.'</b>
                     A bientôt sur Carte Mémoire !                     
                   </td>
                 </tr>
                 <tr>
                   <td align="center">
                     <font size="2">
                       Ceci est un email automatique, merci de ne pas y répondre
                     </font>
                   </td>
                 </tr>
               </table>
             </div>
           </font>
         </body>
         </html>
         ';
     	mail($email, "Récupération de mot de passe - Carte Memoire", $message, $header);
        header("Location:mdpoublie.php?section=code");	

			}
			else {
				$erreur="Cette adresse email n'est pas enregistrée";
			}
		} 
		else {
			$erreur = "Adresse email invalide";
		}
	}
	else {
		$erreur=  "Veuillez entrer votre adresse email";
	}
}
//Vérifier que le code de récupération est correct
if(isset($_POST['verif_submit']) AND isset($_POST['verif_code'])){
		if(!empty($_POST['verif_code'])){
			$verif_code =htmlspecialchars($_POST['verif_code']);
			$verif_req= $bdd->prepare('SELECT idRecup FROM recuperation WHERE email= ? AND code = ?');
			$verif_req->execute(array($_SESSION['recup_mail'],$verif_code));
			$verif_req = $verif_req->rowCount();
			if($verif_req == 1){
				$del_req= $bdd->prepare('DELETE FROM recuperation WHERE email = ?');
				$del_req->execute(array($_SESSION['recup_mail']));
				header("Location:mdpoublie.php?section=changemdp");
			} else {
				$erreur ="Code invalide";
			}
		}else {
			$erreur ="Veuillez entrer votre code de confirmation ";
		}
}
//Enregistrement du nouveau mot de passe
if(isset($_POST['change_submit'])){
	if(isset($_POST['change_mdp']) AND isset($_POST['change_mdpc'])){
		$mdp=htmlspecialchars($_POST['change_mdp']);
		$mdpc=htmlspecialchars($_POST['change_mdpc']);
		if(!empty($mdp) AND !empty($mdpc)){
			if($mdp == $mdpc){
				$mdp = md5($mdp);
				$insert_mdp= $bdd->prepare('UPDATE users SET password= ? WHERE email =?');
				$insert_mdp->execute(array($mdp,$_SESSION['recup_mail']));
				header("Location: connexion.php");
			}else{
				$erreur ="Vos mots de passe ne sont pas identiques";
			}
		}else{
		 $erreur="Veuillez remplir tous les champs";
		}
	}else {
		$erreur ="Veuillez remplir tous les champs";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Mot de passe oublié</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="../css/inscription.css">
</head>
<body>
<?php if($section == 'code') { ?>
Un code de vérification vous a été envoyé par mail: <?= $_SESSION['recup_mail'] ?>
<form method="post">
	<fieldset>
		<legend>Récupération de mot de passe pour <?= $_SESSION['recup_mail'] ?> </legend>
		<label for="text"> Code de vérification :</label> <br/> <br/>
		<input type="text" name="verif_code" id="code" placeholder="Code de vérification"><br/> <br/>
		<input type="submit" name="verif_submit" value="Valider" /> <br/> <br/>
	</fieldset>
</form>

<?php } else if ($section == "changemdp") { ?>
<form method="post">
	<fieldset>
		<legend>Nouveau mot de passe pour <?= $_SESSION['recup_mail'] ?> </legend>
		<label for="password"> Nouveau mot de passe  :</label> <br/> <br/>
		<input type="password" name="change_mdp" id="mdp" placeholder="Nouveau mot de passe"><br/> <br/>
		<label for="password"> Confirmation du mot de passe :</label> <br/> <br/>
		<input type="password" name="change_mdpc" id="mdpc" placeholder="Confirmer nouveau mot de passe"><br/> <br/>
		<input type="submit" name="change_submit" value="Valider" /> <br/> <br/>
	</fieldset>
</form>


<?php } else { ?>
<form method="post">
	<fieldset>
		<legend>Mot de passe oublié: </legend>
		<label for="email"> E-mail :</label> <br/> <br/>
		<input type="email" name="recup_email" id="email" placeholder="Votre adresse email"value="<?php if(isset($email)){echo $email;}?>"/> <br/> <br/>
		<input type="submit" name="recup_submit" value="Valider" /> <br/> <br/>
	</fieldset>
</form>
<?php } ?>
<?php if(isset($erreur)) { echo $erreur; } ?>
</body>
</html>



