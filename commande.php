<?php
session_start();

  $servername = "localhost";
  $dbname = "baselafleur2";
  $username = "lafleur";
  $password = "secret";
  $total=0;
  


$html=<<<HTML
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset ="UTF-8"/>
		<style>

		.styled {
		  border: 0;
		  line-height: 2;
		  padding: 0 10px;
		  font-size: 1rem;
		  text-align: center;
		  color: #fff;
		  text-shadow: 1px 1px 1px #000;
		  border-radius: 10px;
		  background-color: rgb(255, 115, 187);
		  background-image: linear-gradient(
			to top left,
			rgb(0 0 0 / 20%),
			rgb(0 0 0 / 20%) 30%,
			rgb(0 0 0 / 0%)
		  );
		  box-shadow:
			inset 2px 2px 3px rgb(255 255 255 / 60%),
			inset -2px -2px 3px rgb(0 0 0 / 60%);
		}

		.styled:hover {
		  background-color: rgb(255, 170, 180);
		  cursor: pointer;
		}

		.styled:active {
		  box-shadow:
			inset -2px -2px 3px rgb(255 255 255 / 60%),
			inset 2px 2px 3px rgb(0 0 0 / 60%);
		}


		#customers {
		  font-family: Arial, Helvetica, sans-serif;
		  border-collapse: collapse;
		  width: 100%;
		}

		#customers td, #customers th {
		  border: 1px solid #ddd;
		  padding: 8px;
		}

		#customers tr:nth-child(even){background-color: #f2f2f2;}

		<!-- #customers tr:hover {background-color: #ddd;} --!>
		#customers tr:hover {background-color: #ddd;}

		#customers th {
		  padding-top: 12px;
		  padding-bottom: 12px;
		  text-align: left;
		  background-color: #04AA6D;
		  color: white;
		}
		
		</style>
		<title>Mon panier</title>
	</head>
	<body>
		<table id="customers">
			<tr>
				<th>
					<center><b>Récapitulatif des articles commandés</b></center>
				</th>
			</tr>
		</table>
		<table id="customers">
			<tr>
				<th>Ref</th>
				<th>Désignation</th>
				<th>Px Unit.</th>
				<th>Qté</th>
				<th>Montant</th>
			</tr>
HTML;

	
for ($i=0;$i<count($_SESSION["reference"]);$i++)  {
	try {
		$dbh = new PDO("mysql:host=localhost;dbname=".$dbname."", $username, $password);
		$requete="SELECT * FROM produit WHERE pdt_ref='".$_SESSION['reference'][$i]."' ; ";
		$result=$dbh->query($requete);
		foreach($result as $row) {
			$total+=$_SESSION['quantite'][$i]*$row['pdt_prix'];
			
			$html.= "<tr>"
			."<td>".$row['pdt_ref']."</td>"
			."<td>".$row['pdt_designation']."</td>"
			."<td>".$row['pdt_prix']." €</td>"
			."<td>".$_SESSION['quantite'][$i]."</td>"
			."<td>".$_SESSION['quantite'][$i]*$row['pdt_prix']." €</td></tr>";
		}	

		$dbh = null;
		}
		
		catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage() . "<br/>";
			die();
		}
}
	


$html.=<<<HTML
			<tr>
				<td colspan="4"><b>Total</b></td>
HTML;
				$html.="<td><b>".$total." €</b></td>";
$html.=<<<HTML
			</tr>
		</table>
		<form action="envoyer.php" target="page" method="get">
			<table id="customers">
				<tr>
					<th>
						<center>
							<input type="text" placeholder="nom" name="clt_nom" required>
							<input type="password" placeholder="mot de passe" name="clt_motPasse" required>
							<input class="styled" type="submit" name="" value="Envoyer la commande">
						</center>
					</th>
				</tr>
			</table>
		</form>
HTML;
		if (isset($_GET['message']) & !empty($_GET['message']))
	{
		if ($_GET['message']=="Commande envoyée !") {
		$html.= "<p><font color='green'>".$_GET['message']."</font></p>";	
		}
		else {
		$html.= "<p><font color='red'>".$_GET['message']."</font></p>";	
		}
	}
$html.=<<<HTML
	</body>
</html>
HTML;
echo $html;

// pour vérifier le tableau : print_r($_SESSION['reference']);