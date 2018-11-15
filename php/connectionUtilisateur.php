<?php
	// cr�ation d'une session permettant de conserver des valeurs de page en page dans des variables de session
	session_start();		// cette instruction est n�cessairement la premi�re de la page

	/* A ADAPTER */
	$email=$_POST['email'];		// r�cup�ration d'un login (� compl�ter avec le nom de contr�le de formulaire associ�)
	$pwd=$_POST['motdepasse'];		// r�cup�ration d'un mot de passe (� compl�ter avec le nom de contr�le de formulaire associ�)

	$email=addslashes($email);	// neutralise les cotes (contre les injections SQL)
	$pwd=addslashes($pwd);		// neutralise les cotes (contre les injections SQL)

	$email = str_replace(' ','',$email);	// supprime les espaces (contre les injections SQL)
	$pwd = str_replace(' ','',$pwd);		// supprime les espaces (contre les injections SQL)

	// appel du fichier de connexion au serveur de donn�es, puis � la base de donn�es
	include("connexion.php");
	// $pwd = password_hash($pwd , PASSWORD_DEFAULT);
	 // print_r($pwd);die();
	// stockage dans une variable d'une cha�ne de caract�res correspondant � une requ�te qui recherche l'utilisateur correspondant au login et au mot de passe fournis
	$reqSQL = "	SELECT *
	 						FROM utilisateur
						  WHERE email = '$email'
							AND motdepasse = '$pwd'";		/* A ADAPTER */


	// ex�cution de la requ�te stock�e dans $reqSQL par le SGBDR mysql et r�cup�ration du jeu d'enregistrements r�sultat dans une variable
	$JeuEnr = mysql_query($reqSQL);

	// test du nombre d'enregistrements du jeu d'enregistrements r�sultat
	// (1 si l'authentification est r�ussie, 0 sinon ; plus de 1 au cas o� une injection SQL aurait renvoy� toute la table)
  if ((mysql_num_rows($JeuEnr)==0)||(mysql_num_rows($JeuEnr)>1))
		{
			// affectation � une variable de session qui pourra �tre r�appel�e dans une autre page
			$_SESSION['authentif']=False;
			header("Location:accueilconnexion.php");
		}
	else
		{
			$variabletest = mysql_fetch_array($JeuEnr);
			$_SESSION['authentif']=True;
			$_SESSION['pseudo']=$variabletest['pseudo'];
			header("Location:accueilconnexion.php");
		}

?>
