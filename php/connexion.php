<?php
	// PARAMETRES DE CONNEXION A ADAPTER AU CONTEXTE
	// adresse IP ou nom de domaine du serveur mysql de bases de données
		$serveur ="localhost";
	// nom de la base de données
		$base = "bdd_e4";
	// TODO changer le compte pour un utilisateur avec moins de droit
	// nom d'un utilisateur de la base ayant les droits adéquats
		$utilisateur = "po";
	// mot de passe de cette utilisateur
		$mot_passe = "popo";

	// l'arobase empêche l'éventuel message d'erreur par défaut de s'afficher
	$cx_serv = @mysql_connect($serveur,$utilisateur,$mot_passe);

	if(!$cx_serv)
		{
			print '<!doctype html>
					<html lang="fr">
						<head>
							<title>Erreur</title>
							<meta charset="utf-8">
							<style>
								body
									{
									width: 900px; /* largeur du body */
									margin: auto; /* cette marge permet de centrer le body */
									background-color: #464646; /* couleur de fond  */
									}

								p
									{
									margin-top: 100px;
									margin-bottom: 15px;
									margin-left: 175px;
									margin-right: 175px;
									line-height:36px;
									color:#c3c3c3;
									font-family:League Spartan;
									text-align:center;
									font-size:18px;
									text-transform:uppercase;
									}
							</style>

					</head>
					<body>
						<br />
					<p>Erreur de connexion au serveur !</p>
					</body>
				</html>
			';
			exit;
		}
	else
		{
			$cx_base = @mysql_select_db($base,$cx_serv);
			if(!$cx_base)
				{
					print '<!doctype html>
					<html lang="fr">
						<head>
							<title>Erreur</title>
							<meta charset="utf-8">
							<style>
								body
									{
									width: 900px; /* largeur du body */
									margin: auto; /* cette marge permet de centrer le body */
									background-color: #464646; /* couleur de fond  */
									}

								p
									{
									margin-top: 100px;
									margin-bottom: 15px;
									margin-left: 175px;
									margin-right: 175px;
									line-height:36px;
									color:#c3c3c3;
									font-family:League Spartan;
									text-align:center;
									font-size:18px;
									text-transform:uppercase;
									}
							</style>

					</head>
					<body>
						<br />
					<p>La connexion au serveur a bien eu lieu mais il y a une erreur de connexion de la base !</p>
					</body>
				</html>
			';

				@mysql_close($cx_srv) ;
				exit;
				}
		}

	mysql_query("SET NAMES 'utf8'");
