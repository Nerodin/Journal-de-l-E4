<?php


			include("connexion.php");
				$email = $_POST['email'];
				$pseudo = $_POST['pseudo'];
				$motdepasse = $_POST['motdepasse'];
				// $motdepasse = password_hash($motdepasse , PASSWORD_DEFAULT);

				$req = "INSERT INTO utilisateur (email,pseudo,motdepasse,role)
						VALUES ('$email','$pseudo','$motdepasse','user')";


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
						<p>Vous vous êtes bien inscrit !</p>
						<p>Vous allez être redirigé dans 5 secondes.</p> ";
						header("refresh:5;url=../index.php");
					}
			?>
