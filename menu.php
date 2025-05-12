<?php
session_start();

if (!isset($_SESSION["reference"]))
	{
	// session_register("reference"); )=> fonction session_register() SUPPRIMÉE à partir de PHP 5.4.0.
	// session_register("quantite");
	$_SESSION["reference"]=array();
	$_SESSION["quantite"]=array();
	}

  $servername = "localhost";
  $dbname = "baselafleur2";
  $username = "lafleur";
  $password = "secret";
  
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
		
					
			h2 {
			margin: 1em;
			color: pink;
			font-family: Open Sans,Arial,Helvetica,sans-serif;
			text-shadow: 0 0 1px transparent,0 1px 2px rgba(0,0,0,.8);
			font-size: 180%;
			}

			ul {
			  list-style-type: none;
			  margin: 0;
			  padding: 0;
			  width: 100%;
			  background-color: none;
			  font-family: "Gill Sans", sans-serif;
			}

			li a {
			  display: block;
			  color: #000;
			  padding: 8px 16px;
			  text-decoration: none;
			}

			li {
			  text-align: center;
			  
			}

			li:last-child {
			  border-bottom: none;
			}

			li a.active {
			  background-color: #04AA6D;
			  color: white;
			}

			li a:hover:not(.active) {
			  background-color: pink;
			  color: white;
			}
			

</style>
		<title>Menu</title>
	</head>
	<body>
				<h2>Sté LaFleur</h2>
				<ul>
					<li><a href="page.html" target="page">Accueil</a></li>
					<li><a href="mailto:commercial@lafleur.com">Nous écrire</a></li>
				</ul>
				<hr>
				<center><table>
					<tr>
						<th><form action="commande.php" target="page" method="get">
							<input class="styled" type="submit" value="Mon panier" />
						</form></th>
						<th><form action="panier.php" target="menu" method="get">
							<input class="styled" type="submit" name="action" value="Vider le panier" />
						</form></th>
					</tr>
				</table></center>
				<hr>
				<ul>
					<li><a class="active" href="#">Nos produits</a></li>
HTML;
		try {
		$dbh = new PDO("mysql:host=localhost;dbname=".$dbname."", $username, $password);
		$requete="select cat_libelle, cat_code from categorie";
		$result=$dbh->query($requete);
		foreach($result as $row) {
			$html.=
			"<li><a href='listePdt.php?cat_code=".$row['cat_code']."' target='page'>".$row['cat_libelle']."</a></li>";
		}	

		$dbh = null;
		} catch (PDOException $e) {
			print "Erreur !: " . $e->getMessage() . "<br/>";
			die();
		}

					
$html.=<<<HTML
				</ul>
	</body>
</html>
HTML;
echo $html;