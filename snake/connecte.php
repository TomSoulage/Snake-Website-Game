<!DOCTYPE html>
 <html>
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Snake</title>
    <link rel="stylesheet" type="text/css" href="PageAcceuil.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="icon" type="image/icon type" href="snakes.png">
  </head>
  <body>
<header>
  <div class="logo" > <img src="snake.png" alt="Italian Trulli">  SNAKE</div>
  <nav>
    <ul>
      <li><a href="PageAcceuilJeu.php" target="_self" class="active" ><i class="fas fa-home"></i> Accueil </a></li>
          <li><a href="shop.php"><i class="fas fa-paint-roller"></i> Personnaliser </a></li>
        <li><a href="classement.php"><i class="fas fa-trophy"></i> Classement </a></li>
        <li><a href="chat.php" ><i class="fas fa-comment-dots"></i> Chat </a>
        <?php
if ($_SESSION['statut']=='admin'){
        
 	echo ' <li><a href="liste_utilisateurs.php" target="_self" ><i class="fas fa-users-cog"></i></i> Liste utilisateurs </a></li>' ;
	}
	echo ' <li class="sub-menu"><a href="#" ><i class="fas fa-user"></i> '.$_SESSION['pseudo'].' </a> ';?>
        <ul>
          <li><a href="monprofil.php" target="_self"><i class="far fa-address-card"></i> Mon Profil</a></li>
          <li><a href="deco.php" target="_self"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
        </ul>
      </li>
          <li><a href="help.php"><i class="fas fa-question"></i> Aide </a></li>
    </ul>
  </nav>
  <div class="menu-toggle"><i class="fas fa-bars" aria-hidden="true"></i>

  </div>
</header>




<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.menu-toggle').click(function(){
      $('nav').toggleClass('active')
    })
    $('ul li').hover(function() {
      $(this).siblings().removeClass('active');
      $(this).toggleClass('active');
    })
  })

// fondu de Snake
  var animatedText = $(".animated-text").text().split("");
  $(".animated-text").empty();
  $.each(animatedText, function(i, v) {
      $("p").append($("<span>").text(v));
  });

  var numSpans = $(".animated-text span").length;
  for (i = 0; i <= numSpans; i++) {
    $(".animated-text span:nth-child(" + i + ")").css("animation-delay", i/10 + "s");
  }

// Fin fondu de Snake

</script>
<div class="footer">
  <span>Copyright © 2019 EISTI Inc. All rights reserved. | Projet Informatique | Jessey Dingley | Tom Soulage | Kilian Peytavy | Eliott Zadeo |  </span>
</div>

     </body>      
</html>





