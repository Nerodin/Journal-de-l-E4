<?php
		session_start();

		// l'accès est refusé si la variable de session d'authentification est vide ou fausse
		if (isset($_SESSION['authentif'])==False || ($_SESSION['authentif']==False))
			{
				header("Location:../index.php");
				exit();
			}

		include("connexion.php");
			$commentaire = $_POST['commentaire'];
			$pseudo = $_SESSION['pseudo'];
			$commentaire = addslashes($commentaire);
			$pseudo = addslashes($pseudo);

			$article_id_pour_commentaire = "SELECT ID From article WHERE ID = 23";
			$requete_article_id_pour_commentaire = mysql_query($article_id_pour_commentaire);
			$id_article_commentaire = mysql_fetch_array($requete_article_id_pour_commentaire);

			$req = "INSERT INTO commentaire(id_article_commentaire,contenu,pseudo) VALUES ('$id_article_commentaire','$commentaire','$pseudo')";


			// exécution de la requête (d'ajout, de mise à jour ou de suppression)
			$result = mysql_query($req);

			// test du résultat de la requête
			if($result==False)
				{
					echo "<p>Echec lors de la requête suivante :<br />".$req."</p>
					";
				}
			else
				{
					echo "
					<p>Vous vous avez bien ajouté votre commentaire !</p>
					<p>Vous allez être redirigé dans 3 secondes.</p> ";
					header("refresh:3;url=accueilconnexion.php");
				}
		?>
