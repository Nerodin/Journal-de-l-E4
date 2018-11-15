<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Le journal de l'E4</title>
  <meta name="description" content="Le journal de l'E4">
  <meta name="author" content="Salmas Gualbert">

  <!-- Bootstrap -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="/fonts/font-awesome/web-fonts-with-css/css/fontawesome-all.css">
  <!-- Stylesheet -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>



<body>
  <!-- Preloader -->
  <div id="preloader">
    <div id="loader"></div>
  </div>

<!-- Triple Button -->
  <nav>
    <!-- Visible pour un visiteur -->
    <button type="button" name="connexion" id="button_connexion" onclick="document.getElementById('container_connexion').style.display='block';document.getElementById('container_connexion').style.opacity='1';">Se connecter</button>
<!-- Button deconnexion à intégrer -->
    <!-- <button type="button" action="php/deconnexion.php" name="deconnexion" id="button_connexion">Se deconnecter</button> -->

  </nav>
  <!-- Visible par tous -->
  <button type="button" name="mon_button" id="monButtonToTop" onclick="topFunction()">Revenir en haut</button>
<!-- Visible uniquement pour l'administrateur -->
  <button type="button" name="button_ajouterArticle" id="ajouterUnArticle" onclick="document.getElementById('container_ajouter_un_article').style.display='block';document.getElementById('container_ajouter_un_article').style.opacity='1';">Ajouter un article</button>

<!-- Aside logo -->
  <aside class="icons_aside">
    <div class="container_icons_aside">
      <a href="#" target="_blank" title="Facebook du site"><img src="svg/facebook-logo.svg" /></a>
      <a href="#" target="_blank" title="Twitter du site"><img src="svg/twitter-logo.svg" /></a>
      <a href="#" target="_blank" title="La page Steam du site"><img src="svg/steam.svg" /></a>
      <a href="#" target="_blank" title="Le Pinterest du site"><img src="svg/pinterest.svg" /></a>
    </div>
  </aside>


<!-- Titre du site -->
  <div class="container_titre">
    <h1><a href="index.php">Bienvenue sur le journal de l'E4 </a></h1>

    <h4>Les actualitées du net sur l'E4</h4>
  </div>




<!-- Container des articles -->

  <div class="container_div_article">
    <article class="articleDeBase">
      <div class="auteur_article"><i>FrozenB2e</i><b>13h32</b></div>
      <h2>GitHub racheté par Microsoft</h2>
      <div class="image_article">
        <img src="images/githubmicro.png" alt="image clickbait mwahahhaha">
      </div>
      <p>Ces derniers jour Microsoft, a fais parler de lui et a déclaré lundi qu'il achetait GitHub, une plate-forme logicielle ouverte utilisée par 28 millions de programmeurs,la transaction est éstimé a $7,5 milliards.</p>
          <!-- Ceci est la div pour l'ajout de commentaire -->
          <!-- <div class="container_commentaire">
          <textarea name="commentaire" value="" placeholder="Insérez votre commentaire"></textarea>
          <button type="submit" name="envoyer_un_commentaire">Envoyer le commentaire</button>
          </div> -->
          <div class="commentaire_de_la_BDD">
            <div class="nom_de_lutilisateur">
              <p><i><b>Ici on met le nom de l'utilisateur</b></i></p>
            </div>
            <div class="commentaire_de_lutilisateur">
              <p>Ici on incrémente depuis la base de donnée le commentaire de lutilisateur</p>
              <p>Exemple : </p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
          </div>
    </article>
  </div>

  <div class="container_div_article">
    <article class="articleDeBase">
      <div class="auteur_article"><i>Mettre le nom de l'utilisateur</i><b>Mettre l'heure du poste ici</b></div>
      <h2>Ceci est un titre principale pour un article</h2>
      <div class="image_article">
        <img src="images/test.jpg" alt="image clickbait mwahahhaha">
      </div>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
        dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
<!-- Div pour l'ajout de commentaire -->
        <!-- <div class="container_commentaire">
<textarea name="commentaire" value="" placeholder="Insérez votre commentaire"></textarea>
<button type="submit" name="envoyer_un_commentaire">Envoyer le commentaire</button>
          </div> -->
          <div class="commentaire_de_la_BDD">
            <div class="nom_de_lutilisateur">
              <p><i><b>Ici on met le nom de l'utilisateur</b></i></p>
            </div>
            <div class="commentaire_de_lutilisateur">
              <p>Ici on incrémente depuis la base de donnée le commentaire de lutilisateur</p>
              <p>Exemple : </p>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
          </div>
    </article>

  </div>



  <!-- Container pour se connecter -->
  <div id="container_connexion">


    <link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' type='text/css'>

    <div class="container">
      <div class="row login_box">
        <span class="pull-right clickable" onclick="document.getElementById('container_connexion').style.display='none';document.getElementById('container_connexion').style.opacity='0';"><i class="fa fa-times" ></i></span>
        <div class="col-md-12 col-xs-12" align="center">
          <div class="line">
            <h3><?php echo date('l jS \of F Y'); ?></h3></div>
          <div class="outter"><img src="svg/E4_logo.svg" class="image-circle" /></div>
        </div>
        <div id="button_connexion_connexion" class="col-md-6 col-xs-6 follow line" align="center">
          <h3>
                  <p>Connexion</p>
            </h3>
        </div>
        <div id="button_connexion_inscription" class="col-md-6 col-xs-6 follow line" align="center" onclick="document.getElementById('container_inscription').style.display='block';document.getElementById('container_connexion').style.display='none'">
          <h3>
                 <p>Inscription</p>
            </h3>
        </div>

        <div class="col-md-12 col-xs-12 login_control">
          <form  method="post" action="php/connectionUtilisateur.php">
            <div class="control">
              <div class="label">Votre adresse e-mail</div>
              <input type="text" class="form-control" name="email" placeholder="exemple@gmail.com"required />
            </div>

            <div class="control">
              <div class="label">Votre mot de passe</div>
              <input type="password" class="form-control" name="motdepasse" required/>
            </div>
            <div align="center">
              <button class="btn btn-orange">Se connecter</button>
            </div>
          </form>
        </div>



      </div>
    </div>
  </div>


  <!-- Container pour s'inscrire -->
  <div id="container_inscription">


    <link href='http://fonts.googleapis.com/css?family=Raleway:400,200' rel='stylesheet' type='text/css'>

    <div class="container">
      <div class="row login_box">
        <span class="pull-right clickable" onclick="document.getElementById('container_inscription').style.display='none';document.getElementById('container_inscription').style.opacity='0';"><i class="fa fa-times"></i></span>
        <div class="col-md-12 col-xs-12" align="center">
          <div class="line">
            <h3><?php echo date('l jS \of F Y'); ?></h3></div>
          <div class="outter"><img src="svg/E4_logo.svg" class="image-circle" /></div>
        </div>
        <div class="col-md-6 col-xs-6 follow line" align="center" onclick="document.getElementById('container_connexion').style.display='block';document.getElementById('container_inscription').style.display='none'">
          <h3>
                  <p>Connexion</p>
            </h3>
        </div>
        <div class="col-md-6 col-xs-6 follow line" align="center" onclick="document.getElementById('container_inscription').style.display='block';document.getElementById('container_connexion').style.display='none'">
          <h3>
                 <p>Inscription</p>
            </h3>
        </div>

        <div class="col-md-12 col-xs-12 login_control">
          <form method="post" id="myform" onSubmit="return validate();" action="php\EnregistrementInscription.php">
            <div class="control">
              <div class="label">Votre adresse e-mail</div>
              <input type="email" id="email" class="form-control" name="email" placeholder="exemple@gmail.com" control-label required />
            </div>
            <div class="control">
              <div class="label">Votre Pseudo</div>
              <input type="text" id="pseudo" class="form-control" name="pseudo" placeholder="Palero974" required />
            </div>
            <div class="control">
              <div class="label">Votre mot de passe</div>
              <input type="password" id="mdp" class="form-control" name="motdepasse" required />
            </div>
            <div class="control">
              <div class="label">Répétez votre mot de passe</div>
              <input type="password" id="vmdp" class="form-control" name="motdepasse" required />
            </div>
            <div align="center">
              <button class="btn btn-orange" id="submitButton" >S'inscrire</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">

  // function test() {
  //   var motDePasse = document.getElementById("mdp").value;
  //   var buttonInscription = document.getElementById("submitButton");
  //   if(motDePasse.lenght= 0){
  //     alert("shit");
  //     buttonInscription.disabled;
  //   }
  // };

    function validate() {

            var motDePasse = document.getElementById("mdp").value;
            var confirmationMotDePAsse = document.getElementById("vmdp").value;
            var mail = document.getElementById("email").value;
            var pseudo = document.getElementById("pseudo").value;
            var buttonInscription = document.getElementById("submitButton");

            // while((motDePasse || confirmationMotDePAsse || mail || pseudo).value("")){
            //   buttonInscription = buttonInscription.disabled;
            // }



            if (motDePasse!=confirmationMotDePAsse) {
            	alert("Les mots de passe ne correspondent pas.");
            	return false; }
            else {
            	return true; }
            };
  </script>

<!-- <script type="text/javascript">
// $(document).ready(function(){
//   while((document.getElementById("email")).val().lenght=0){
//     document.getElementById("submitButton").disabled = true;
//   }
// });

// $(document).ready(function(){
//   while(document.getElementById('email').val()=''){
//     document.getElementById('submitButton').disabled = true;
//   }else{
//     document.getElementById('submitButton').disabled = false;
//   }
// });



</script> -->
  <!-- <script type="text/javascript">
  $(document).ready(function() {

    $('input').on('keyup', function() {
        if ($("#myform").valid()) {
            $('#submitButton').prop('disabled', false);
        } else {
            $('#submitButton').prop('disabled', 'disabled');
        }
    });

    $("#myform").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            pseudo:{
              required:true,
              minlength:3
            },
            mdp:{
              required:true,
              minlenght:5
            },
            vmdp:{
              required:true,
              minlenght:5,
            }
        }
    });

});
  </script> -->

<!-- Container pour ajouter un article -->
    <form id="container_ajouter_un_article" method="POST">
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
            <div class="Ajouter_un_article_le_contenu_de_larticle">
              <textarea name="contenu" placeholder="Le contenu de votre article"></textarea>
            </div>
          </div>
          <button type="submit" name="envoyer_larticle" class="ajouter_envoyer_larticle">Envoyer l'article</button>
        </div>
      </div>
    </div>
  </form>

<!-- Include des script Javascript -->
<?php
include("js/js_included.js");
?>


</body>

</html>
