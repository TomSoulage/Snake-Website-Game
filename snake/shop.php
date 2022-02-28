<?php session_start();
if(!empty($_SESSION['pseudo']))
   {include('connecte.php');
   }else 
   {
   include('PageAcceuil.html');
   }
?> 
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Customiser</title>
    <link rel="icon" type="image/icon type" href="snakes.png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  </head>
  <body>

<!-- Customize -->
<div id="shopping-cart">

  <div id="titre_shop">
   Customiser Mon Snake
  </div>
	
<div id="shopping-cart-bis">  
	<!-- personnalisation du serpent (PARTIE NON FINIT)-->
	<?php
	//$fic = "/pau/homee/p/peytavykil/public_html/DevWebSnake/couleur.txt";
	//	$f = fopen($fic,"r");
	?>
		<select id="couleur" onchange="">
		<!-- la couleur de base est 805500 (brun) on peut reprendre cette valeur avec la fonction de base -->
			<option value="#805500"> Sélectionnez une couleur (bientôt disponible...)
			</option>  
			<?php
			//on cherche dans le fichier puis on affiche les couleur celon le niveau du joueur
				while (($couleur = fgets($f))!== false){
					$choix = explode(",",$couleur);
					$lvl = $choix[0];
					$couleur=$choix[1];
					$nom=$choix[2];
					if($lvl <= 5/*$_SESSION['niveau']*/){
						echo "<option value=".$couleur.">".$nom."</option>";
					};
			};
			fclose($fic);
			?>
</select>

<select id="map" onchange="">
	<option value="fond/background.jpeg"> Fond de base </option>
	<option value="fond/firstimage.jpg"> Fond nuance de vert </option>
	<option value="fond/background2.jpg"> Fond gris </option>
	<option value="fond/background3.jpeg"> Fond doré </option>
</select>

 <div id="boutons">
    <button type="button" name="boutonperso" id="boutonperso" onclick="perso()">Sauvegarder Personnalisation</button>
 </div>

</div>   
</div>
<!-- End Customize -->


</body>
 <script>
 
 
// Kilian Peytavy
function getXHR() {
 	var xhr = null;
 	if (window.XMLHttpRequest) // FF & autres
   	xhr = new XMLHttpRequest();
 	else if (window.ActiveXObject) { // Internet Explorer < 7
      try {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     	}
 	} else { // Objet non supporté par le navigateur
   		alert("Votre navigateur ne supporte pas AJAX");
   		xhr = false;
 	}
	return xhr;
}

// Changement map/couleur
function perso() {
	couleur=document.getElementById('couleur').value;
	map =document.getElementById('map').value;
	var xhr = getXHR();
	// On définit que l'on va faire à chaque changement d'état
	xhr.onreadystatechange = function() {
	// On ne fait quelque chose que si on a tout reç̧u
	// et que le serveur est ok
		if (xhr.readyState == 4 && xhr.status == 200){
			// traitement ré́alisé avec la réponse...		
		}
	}
	xhr.open("POST","perso.php",true) ;
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("couleur="+couleur+"&map="+map);
}
</script>
</html>
