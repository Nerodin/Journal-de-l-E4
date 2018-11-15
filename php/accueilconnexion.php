<?php
// section de code à recopier au début de chaque page à accès restreint (c'est-à-dire ayant nécessité une authentification préalable dont le résultat a été stocké dans une variable de session)
// chaque page vérifie l'authentification ainsi si l'utilisateur saisit directement l'URL dans la page sans passer par la page d'authentification l'accès lui sera refusé
session_start();

// l'accès est refusé si la variable de session d'authentification est vide ou fausse
if (isset($_SESSION['authentif'])==False || ($_SESSION['authentif']==False))
	{
		header("Location:../index.php");
		exit();
	}
include("connexion.php");

// exécution de la requête (d'ajout, de mise à jour ou de suppression / affichage)

$reqUtilisateur = "SELECT pseudo FROM utilisateur = ".$_SESSION['pseudo'];
$JeuEnr = mysql_query($reqUtilisateur);
$enr = mysql_fetch_array($JeuEnr);
?>

<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Le journal de l'E4</title>
  <meta name="description" content="Le journal de l'E4">
  <meta name="author" content="Salmas Gualbert">

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="../fonts/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../fonts/font-awesome/web-fonts-with-css/css/fontawesome-all.css">
  <!-- Stylesheet -->
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>



<body>
  <!-- Preloader -->
  <div id="preloader">
    <div id="loader"></div>
  </div>

<!-- Triple Button -->
  <nav>
    <!-- Visible pour un visiteur -->
    <!-- <button type="button" name="connexion" id="button_connexion" onclick="document.getElementById('container_connexion').style.display='block';document.getElementById('container_connexion').style.opacity='1';">Se connecter</button> -->
<!-- Button deconnexion à intégrer -->
    <a type="button" href="deconnexion.php" name="deconnexion" id="button_connexion">Se deconnecter<br /> <?php echo $_SESSION['pseudo']; ?></a>

  </nav>
  <!-- Visible par tous -->
  <button type="button" name="mon_button" id="monButtonToTop" onclick="topFunction()">Revenir en haut</button>
<!-- Visible uniquement pour l'administrateur -->
  <button type="button" name="button_ajouterArticle" id="ajouterUnArticle" onclick="document.getElementById('container_ajouter_un_article').style.display='block';document.getElementById('container_ajouter_un_article').style.opacity='1';">Ajouter un article</button>

<!-- Aside logo -->
  <aside class="icons_aside">
    <div class="container_icons_aside">
      <a href="#" target="_blank" title="Facebook du site"><img src="../svg/facebook-logo.svg" /></a>
      <a href="#" target="_blank" title="Twitter du site"><img src="../svg/twitter-logo.svg" /></a>
      <a href="#" target="_blank" title="La page Steam du site"><img src="../svg/steam.svg" /></a>
      <a href="#" target="_blank" title="Le Pinterest du site"><img src="../svg/pinterest.svg" /></a>
    </div>

  </aside>


<!-- Titre du site -->
  <div class="container_titre">
    <h1><a href="accueilconnexion.php">Bienvenue sur le journal de l'E4 </a></h1>

    <h4>Les actualitées du net sur l'E4</h4>
  </div>

<!-- Container des articles -->

<?php

$article_titre = "SELECT titre FROM article";
$article_contenu = "SELECT contenu FROM article";
$id_article = "SELECT ID FROM article";


$requete_titre = mysql_query($article_titre);
$data_titre = mysql_fetch_array($requete_titre);
$requete_contenu = mysql_query($article_contenu);
$data_contenu = mysql_fetch_array($requete_contenu);
$recuperation_id_article = mysql_query($id_article);

$article_lien_titre_contenue_pseudo_date = "SELECT titre,contenu,lien,lien_video,pseudo,current_datetime,ID From article ORDER BY current_datetime DESC";

$requete_lien_titre_contenue_pseudo_date = mysql_query($article_lien_titre_contenue_pseudo_date);

$commentaire_contenu = "SELECT contenu,pseudo,current_datetime_comment FROM commentaire ORDER BY ID DESC";

$requete_commentaire = mysql_query($commentaire_contenu);


$pseudo = $_SESSION['pseudo'];


$role_utilisateur = "SELECT pseudo,role FROM utilisateur Where pseudo = '$pseudo'";

$requete_role_utilisateur = mysql_query($role_utilisateur);
$data_role_utilisateur = mysql_fetch_array($requete_role_utilisateur);

// print_r($data_role_utilisateur);

// if ($data_role_utilisateur['role'] == "admin") {
// 	echo "Vous êtes connecté en tant qu'admin, Bravo !";
// }else {
// 	echo "Vous êtes un utilisateur lambda";
// }

 ?>
<!-- Mise en place de variable pour l'image par défaut -->
<?php
// $image_par_defaut = fopen('../images/images_par_defaut.png');
// $balise_html_image_par_defaut = '<img src="'$image_par_defaut'" alt="Image par defaut" title="Waaaat?"/>';

 ?>

<?php

while ($requete_article = mysql_fetch_array($requete_lien_titre_contenue_pseudo_date)) {
echo '<div class="container_div_article">
	<article class="articleDeBase">
		<div class="auteur_article"><i> '; echo  $requete_article['pseudo']; echo '</i><b class="date_time_css">'; echo $requete_article['current_datetime'];echo ' '; echo $requete_article['ID']; echo '</b></div>
		<h2>';  echo $requete_article['titre']; echo '</h2>
		<div class="image_article">';
		// if(isset($requete_article['lien'])){
		// 	<img src="'; echo $requete_article['lien'] ; echo '" alt="image clickbait mwahahhaha"/>
		// }else{
		// 	$balise_html_image_par_defaut;
		// }

		//condition pour image par date_default
		if(strlen($requete_article['lien']) == 0){
			echo '<img src="../images/images_par_defaut.png" title="defaut image" alt="oof" />';
		}else {
			echo '<img src="'; echo $requete_article['lien'] ; echo '" alt="image clickbait mwahahhaha"/>';
		}

		//Condition pour l'affichage de la video
		if(strlen($requete_article['lien_video']) !== 0){
			echo '<iframe width="100%" height="50%" src="'; echo $requete_article['lien_video']; echo'" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<p>';
	}
	if((strlen($requete_article['lien']) == 0) && (strlen($requete_article['lien_video'])!== 0)){
			print '<style type="text/css">
			.image_article img{
				display: none;
			}
			</style>'
			;
		}elseif((strlen($requete_article['lien']) !== 0) && (strlen($requete_article['lien_video'])== 0)){
				print '<style type="text/css">
				.image_article iframe{
					display: none;
				}
				</style>'
				;
			}

		echo $requete_article['contenu'];  echo '</p>';
		$titre = $requete_article['titre'];
		$ID_commentaire = "SELECT ID,titre FROM article WHERE titre = '$titre'";
		$requete_ID_commentaire = mysql_query($ID_commentaire);
		// print_r($ID_commentaire);
		$data_ID_commentaire = mysql_fetch_array($requete_ID_commentaire);
// $requete_commentaire = addslashes($requete_commentaire);
		// print_r($data_ID_commentaire);


		?>
		<!-- Pour envoyer un commentaire dans la basse de donnée -->
			<form action="insertCommentaire.php" method="post" class="container_commentaire">
				<textarea name="commentaire" value="" placeholder="Insérez votre commentaire"></textarea>
				<button type="submit" name="envoyer_un_commentaire">Envoyer le commentaire</button>
			</form>


			<?php
				while (($donnees = mysql_fetch_array($requete_commentaire))) {

						echo '<div class="commentaire_de_la_BDD">
							<div class="nom_de_lutilisateur">
								<p><i><b class="pseudo_in_comment"> ';	echo  $donnees['pseudo']; echo'</b></i></p>'; echo $donnees['current_datetime_comment']; echo'
							</div>
							<div class="commentaire_de_lutilisateur">
							<p>';


									// while ($donnees = mysql_fetch_array($requete_commentaire)) {
										echo $donnees['contenu'] ;
										echo "<br />";
									// }


							echo '</p>
							</div>
						</div>'
							;
						}
						echo '
	</article>
</div>'

		;
	}
?>



<!-- Container pour ajouter un article -->
<?php

// if(empty($requete_article['lien_video'])){
// 	print'<style type="text/css">
// 	.container_div_article .articleDeBase .image_article iframe{
// 		display: none;
// 	}
// 	</style>';
// }


if ($data_role_utilisateur['role'] == "admin") {
	print '<style type="text/css">
	#ajouterUnArticle{
		position: fixed;
		bottom: 2rem;
		left: 2rem;
		border: none;
		padding: 1rem;
		background-color: #464646;
		color: #c3c3c3;
		letter-spacing: 0.25rem;
		text-transform: uppercase;
		display: block;
	}
	</style>'
	;
}else {
	print '<style type="text/css">
  #ajouterUnArticle{
    position: fixed;
    bottom: 2rem;
    left: 2rem;
    border: none;
    padding: 1rem;
    background-color: #464646;
    color: #c3c3c3;
    letter-spacing: 0.1rem;
    text-transform: uppercase;
    display: none;
  }
  </style>'
	;
}

 ?>

 </style>
    <form method="post" action="insertArticle.php" id="container_ajouter_un_article">
      <div class="container_ajouter_un_article_interne">
        <div class="row login_box">
          <span class="pull-right clickable" onclick="document.getElementById('container_ajouter_un_article').style.display='none';document.getElementById('container_ajouter_un_article').style.opacity='0';"><i class="fa fa-times"></i></span>
          <div class="col-md-12 col-xs-12" align="center">
            <div class="line_container_ajouter_un_article">
            <h2>Ajouter un article</h2>
            <hr>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="Ajouter_un_article_le_titre_de_larticle">
              <input type="text" name="titre" value="" placeholder="Le titre de votre article">
            </div>
						<div class="Ajouter_un_lien_pour_une_photo_de_larticle">
							<!-- <input type="file" data-edit="insertImage" /> -->
							<!-- <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
     					<a class="btn btn-large" data-edit="bold"><i class="icon-bold">Bold</i></a>
							</div> -->
							<!-- <textarea class="btn-toolbar" data-role="editor-toolbar" data-target="#editor" name="lien" placeholder="Le lien de l'image de votre article"></textarea> -->
							<textarea  name="lien" placeholder="Le lien de l'image de votre article"></textarea>
							<textarea  name="lien_video" placeholder="Le lien de la video de votre article"></textarea>
							<!-- <input type="file" name="upload" accept="image/*"> -->
            </div>
            <div class="Ajouter_un_article_le_contenu_de_larticle">
              <textarea id="contenu_article" name="contenu" placeholder="Le contenu de votre article"></textarea>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<br />'" type="button" name="sautbr" class="button_option_article" value="Saut de ligne" title="Sauter une Ligne"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<b></b>'" type="button" name="bold" class="button_option_article" value="Gras" title="Met le contenu en gras"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<i></i>'" type="button" name="italic" class="button_option_article" value="Italic" title="Met le contenu en Italic"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<u></u>'" type="button" name="underline" class="button_option_article" value="Souligner" title="Vous soulignez le contenu"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<cite></cite>'" type="button" name="cite" class="button_option_article" value="Cite" title="Vous faites une citation"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<code></code>'" type="button" name="code" class="button_option_article" value="Code" title="Vous insérez un morceau de code"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<mark></mark>'" type="button" name="mark" class="button_option_article" value="Surligner" title="Vous surlignez le contenu"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<blockquote></blockquote>'" type="button" name="blockquote" class="button_option_article" value="blockquote" title="Vous quotez une personne"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<h2></h2>'" type="button" name="h2" class="button_option_article" value="Grand Titre" title="Vous insérez un gros titre"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<h3></h3>'" type="button" name="h3" class="button_option_article" value="Moyen Titre" title="Vous insérez un moyen titre"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<h4></h4>'" type="button" name="h4" class="button_option_article" value="Petit Titre" title="Vous insérez un petit titre"/>
							<input onclick="document.getElementById('contenu_article').value=document.getElementById('contenu_article').value+'<h5></h5>'" type="button" name="h5" class="button_option_article" value="Très petit Titre" title="Vous insérez un très petit titre"/>





              </div>
          </div>
          <button type="submit" name="Envoyer larticle" class="ajouter_envoyer_larticle">Envoyer l'article</button>
        </div>
      </div>
    </div>
	</form>

<!-- Include des script Javascript -->
<?php
include("../js/js_included.js");
// include("../js/editor.js");
?>
<!-- <script type="text/javascript">
$('#editor').wysiwyg();
 $('#editor').cleanHtml()
</script> -->
</body>

</html>
