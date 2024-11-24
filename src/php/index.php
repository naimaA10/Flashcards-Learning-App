<?php
session_start();
require_once('database.php');

if(isset($_POST['inscription'])) { header("Location:inscription.php"); }

if(isset($_POST['connexion'])) { header("Location:connexion.php"); }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Index</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/index.css">
</head>
<body>

	
	<form action="" method="post">
		<input type="submit" name="connexion" value="Se connecter">
		<input type="submit" name="inscription" value="S'inscrire">
	</form>
	

	<h1>Flash it</h1>
	
	<h2>Rapide et efficace<br>
	 	Venez jouer!
	 </h2>
	
</body>
</html>