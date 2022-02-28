<?php 
session_start();
if(!empty($_SESSION['pseudo']))
   {include('connecte.php');
   }else 
   {
   include('PageAcceuil.html');
   }
 ?>
<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0" >
    <title>Snake</title>
    <link rel="icon" type="image/icon type" href="snakes.png">
     <link rel="stylesheet" type="text/css" href="help.css">  
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  </head>
  <body>



<!-- Help -->
<div class="page-wrap">
<div class="helpbox">

<div class="title">Déplacement</div>
<div class='blocHelp'>      
<p align="center"><i class="fas fa-arrow-up" id="arrow"></i> Pour se déplacer vers le haut </p>
<p align="center"><i class="fas fa-arrow-down" id="arrow"></i> Pour se déplacer vers le bas </p>
<p align="center"><i class="fas fa-arrow-left" id="arrow"></i> Pour se déplacer vers la gauche </p>
<p align="center"><i class="fas fa-arrow-right" id="arrow"></i> Pour se déplacer vers la droite </p>
<p align="center"><i class="fab fa-product-hunt" id="arrow"></i> Pour mettre le jeu en pause </p>
</div>    
</div>
<div class="helpbox">

<div class="title2">Item</div>
<div class='blocHelp'>  
<p align="center"><img src="img_jeu/banane.png" class="arrow" id="banane"> Cet item te fait grandir, augmente ton score de 1 </p>
<p align="center"><img src="img_jeu/diamant.png" class="arrow" id="diamant">Cet item te rétrecit, augmente ton score de 1 </p>
<p align="center"><img src="img_jeu/apple.png" class="arrow" id="pomme"> Cet item change ton sens, augmente ton score de 3 </p>
<p align="center"><img src="img_jeu/bombe.png" class="arrow" id="bombe"> Cet item te tue</p>
<!-- End Help -->
 </div>      
</div>
</div>

  </body>
</html>
