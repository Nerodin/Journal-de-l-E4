<?php

			session_start();
			// l'accès est refusé si la variable de session d'authentification est vide ou fausse
			if (isset($_SESSION['authentif'])==False || ($_SESSION['authentif']==False))
				{
					header("Location:../index.php");
					exit();
				}

			include("connexion.php");
				$titre = $_POST["titre"];
				$lien = $_POST["lien"];
				$lien_video = $_POST["lien_video"];
				$contenu = $_POST["contenu"];
				$pseudo = $_SESSION["pseudo"];

				$titre = addslashes($titre);
				$lien = addslashes($lien);
				$lien_video = addslashes($lien_video);
				$contenu = addslashes($contenu);
				$pseudo = addslashes($pseudo);

				$req = "insert into article (titre,contenu,lien,lien_video,pseudo)
                values ('$titre','$contenu','$lien','$lien_video','$pseudo')";

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
						<p>Vous vous avez bien ajouté votre article !</p>
						<p>Vous allez être redirigé dans 3 secondes.</p> ";
						header("refresh:3;url=accueilconnexion.php");
					}
			?>
