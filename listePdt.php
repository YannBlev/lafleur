<?php
  $servername = "localhost";
  $dbname = "baselafleur2";
  $username = "lafleur";
  $password = "secret";
$html = <<< HTML
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
		  <!-- border: 1px solid #ddd; --!>
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
		<title>Liste des produits</title>
	</head>
	<body>
		<div>
		<table id="customers">
			<tr>
HTML;

try {
    $dbh = new PDO("mysql:host=localhost;dbname=".$dbname."", $username, $password);
	$requete="SELECT * FROM categorie WHERE cat_code = '".$_GET['cat_code']."';";
	$result=$dbh->query($requete);
    foreach($result as $row) {
		$html.="<th colspan='4'><center><b><u>Nos ".$row['cat_libelle']."</u></b></center></th>";
    }	

    $dbh = null;
	} catch (PDOException $e) {
		print "Erreur !: " . $e->getMessage() . "<br/>";
		die();
	}


$html.= <<< HTML
			</tr>
		</table>
		<table id="customers">
			<tr>
				<th>Photo</th>
				<th>Référence</th>
				<th>Désignation</th>
				<th>Prix</th>
			</tr>
			
HTML;
	try {
    $dbh = new PDO("mysql:host=localhost;dbname=".$dbname."", $username, $password);
	$requete="SELECT pdt_designation, pdt_categorie, pdt_prix, pdt_image, pdt_ref FROM produit WHERE pdt_categorie = '".$_GET['cat_code']."';";
	$result=$dbh->query($requete);
    foreach($result as $row) {
		$html.="<tr>"
		."<td><img src='../images/".$row['pdt_image'].".jpg' alt='image'></td>"
		."<td>".$row['pdt_ref']."</td>"
		."<td>".$row['pdt_designation']."</td>"
		."<td>".$row['pdt_prix']." €</td></tr>";
    }	

    $dbh = null;
	} catch (PDOException $e) {
		print "Erreur !: " . $e->getMessage() . "<br/>";
		die();
	}
$html.= <<< HTML
			</tr>
		</table>
		</div>
			<table id="customers">
				<tr>
					<th><center>
						<label><form action="panier.php" target="menu" method="get">
							<select name="refPdt" size="1">
HTML;
			try {
			$dbh = new PDO("mysql:host=localhost;dbname=".$dbname."", $username, $password);
			$requete="SELECT pdt_designation, pdt_ref FROM produit WHERE pdt_categorie = '".$_GET['cat_code']."';";
			$result=$dbh->query($requete);
			foreach($result as $row) {
				$html.="<option value='".$row['pdt_ref']."'>".$row['pdt_designation']."</option>\n";
			}	

			$dbh = null;
			} catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
$html.= <<< HTML
							</select>			
						Quantité : <input type="number" name="quantite" min="1" max="100" size="3" value="1" />     <input class="styled" type="submit" name="action" value="Ajouter au panier" /></label>
					</center></th>
				</tr>
			</table>
		</form>
	</body>
</html>
HTML;
echo $html;