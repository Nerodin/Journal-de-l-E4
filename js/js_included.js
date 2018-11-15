<script>
  // Quand l'utilisateur descend la page de 20px, le bouton apparait
  window.onscroll = function() {
    scrollFunction()
  };

  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      document.getElementById("monButtonToTop").style.display = "block";
    } else {
      document.getElementById("monButtonToTop").style.display = "none";
    }
  }

  // Quand l'utilisateur click sur le bouton, le scroll remonte en haut de la page.
  function topFunction() {
    document.body.scrollTop = 0; // Pour Safari
    document.documentElement.scrollTop = 0; // Pour Chrome, Firefox, IE et Opera
  }
</script>
<script type="text/javascript" src="js/jquery.1.11.1.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/jqBootstrapValidation.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
