<?php
session_start();

if ($_GET['action']=="Vider le panier") {
	$_SESSION['reference'] = array();
	$_SESSION['quantite'] = array();
	header("Location: commande.php?message=Panier vidé !");
	// header("Refresh:0"); pour rafraichir la page, mais rafraichit uniqumement "menu".
}

else {
	$i = count($_SESSION['reference']); // La fonction "count" retourne le nombre d'éléments d'un tableau
	$flag=true;
	
	for ($j=0;$j<=$i;$j++) {
		if ($_SESSION['reference'][$j] == $_GET['refPdt']) {
		$_SESSION['quantite'][$j] += $_GET['quantite'];
		$flag=false;
		}
	}
	if ($flag) {
	$_SESSION['reference'][$i] = $_GET['refPdt'];
	$_SESSION['quantite'][$i] = $_GET['quantite'];

	}
	

}
header("Location: menu.php");