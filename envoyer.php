<?php
session_start ();

  $servername = "localhost";
  $dbname = "baselafleur2";
  $username = "lafleur";
  $password = "secret";


	try {
    $dbh = new PDO("mysql:host=localhost;dbname=".$dbname."", $username, $password);
	$notExist = true;
	$requete="SELECT clt_nom, clt_motPasse, clt_code FROM clientconnu WHERE clt_nom='".$_GET['clt_nom']."' AND clt_motPasse='".$_GET['clt_motPasse']."'; ";
	$result=$dbh->query($requete);

		
		foreach($result as $row) {
		$notExist = false;
		$date=date("Y-m-d");
		$dbh->query("INSERT INTO commande (cde_date, cde_client, cde_moment ) VALUES ('".$date."', '".$row['clt_code']."', '".time()."');");
			for ($i=0;$i<count($_SESSION["reference"]);$i++){
				$dbh->query("INSERT INTO contenir (cde_client, cde_moment, produit, quantite ) VALUES ('".$row['clt_code']."', '".time()."', '".$_SESSION['reference'][$i]."', '".$_SESSION['quantite'][$i]."');");
			}
		$_SESSION['reference'] = array();
		$_SESSION['quantite'] = array();
		header('Location: commande.php?message=Commande envoyée !');

		}
		if ($notExist) {
		header("Location: commande.php?message=Erreur d'identification : vérifiez votre identifiant et/ou votre mot de passe.");	
		}
		
    $dbh = null;
	}
	
	catch (PDOException $e) {
		print "Erreur !: " . $e->getMessage() . "<br/>";
		die();
	}

