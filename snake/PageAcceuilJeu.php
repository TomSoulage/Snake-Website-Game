
<?php 
session_start();
if (isset($_SESSION['pseudo'])){
	include('connecte.php');
}else{
	include('PageAcceuil.html');
};
?>

<!DOCTYPE html>
<html> 
<head lang="fr">
    <meta charset="UTF-8">
    <title>Jeu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>    
<body onload= 'initgame()'>
<!-- NOTE: on definit les images necessaires pour le jeu -->
		<img src="img_jeu/imagePause.png" alt="imagePause" id="imagePause" style="display:none">
    <img src="img_jeu/imageDemarrePartie.png" alt="imageDemarrePartie" id="imageDemarrePartie" style="display:none">
    <img src="img_jeu/imageFinPartie.png" alt="FinPartie" id="finPartie" style="display:none">
    <img src="img_jeu/banane.png" alt="banane" id="banane" style="display:none">
    <img src="img_jeu/diamant.png" alt="diamant" id="diamant" style="display:none">
    <img src="img_jeu/bombe.png" alt="bomb" id="bomb" style="display:none">
    <img src="img_jeu/apple.png" alt="apple" id="pomme" style="display:none">
			<?php 
			//connexion a la bdd
			$bdd = mysqli_connect('localhost', 'soulagetom', 'CH3vw79', '2018_p0_cpi02_soulagetom');

			//verification de la connexion 
			if (!$bdd) {
				die("Erreur: " . mysqli_connect_error());
			}
			if(isset($_SESSION['pseudo'])){
				$pseudo=$_SESSION['pseudo'];
				$sql = "SELECT `map` FROM `utilisateur` WHERE `pseudo`='$pseudo'";
				$resultat = mysqli_query($bdd, $sql) or die ('Pb requête : '.$sql);
				$data = mysqli_fetch_row($resultat);
				echo "<img src= ".$data[0]." alt='grass' id='fond' style='display:none; filter: contrast(5%);'>";
			}
			else{
				echo "<img src='fond/background.jpeg' alt='grass' id='fond' style='display:none; filter: contrast(5%);'>";
			}
			//deconnexion de la bdd
				if (isset($bdd)) {
					mysqli_close($bdd);
				}
			?>
    <img src="img_jeu/snakeHead.png" alt="tete" id="tete" style="display:none">
    <?php
    //connexion a la bdd
$bdd = mysqli_connect('localhost', 'root', 'CH3vw79', '2018_p0_cpi02_soulagetom');

//verification de la connexion 
if (!$bdd) {
	die("Erreur: " . mysqli_connect_error());
}
    $sql = "SELECT MAX(`score`) FROM `utilisateur`";
		$resultat = $bdd->query($sql)->fetch_assoc();
?>
			  <!-- score -->
    <div id="score">Score : </div>
    <div id="meilleurScore"> Meilleur Score : <?php 
    foreach ($resultat as $tab => $key){
    	echo $key;
    };
    ?>
    </div>
        <!-- NOTE: on crée le terrain de jeu -->
    <canvas id="canvasSnake" ></canvas>

    <div id="boutons">
    <button type="button" name="boutonJouer" id="boutonJouer" onclick="jouerPartie()">Jouer</button>
  	</div>

    <br>

    <!-- NOTE: le jeu -->
    <script src="jeu.js"></script>

  </body>
</html>
