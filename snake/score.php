<?php

session_start();

//connexion a la bdd
$bdd = mysqli_connect('localhost', 'soulagetom', 'CH3vw79', '2018_p0_cpi02_soulagetom');

//verification de la connexion 
if (!$bdd) {
	die("Erreur: " . mysqli_connect_error());
}

$pseudo = $_SESSION['pseudo'];
$score = $_POST['score'];

// on set le meilleur score dans la bdd 
$sql1 = "UPDATE `utilisateur` SET `score` = '$score' WHERE `pseudo`= '$pseudo' AND '$score' > `score` ";

$resultat1 = mysqli_query($bdd, $sql1) or die ('Pb requête : '.$sql1);

//on ajoute le score effectuer a son nombre de pièce
$sql2 = "UPDATE `utilisateur` SET `pieces` = `pieces`+'$score' WHERE `pseudo`= '$pseudo'";

$resultat2 = mysqli_query($bdd, $sql2) or die ('Pb requête : '.$sql2);

//on actualise le niveau par rapport a son meilleur score qui a pu changer 
$sql3 = "UPDATE `utilisateur` SET `niveau` = (`score` - (`score`%10 ))/10  WHERE `pseudo`= '$pseudo'";

$resultat3 = mysqli_query($bdd, $sql3) or die ('Pb requête : '.$sql3);

//deconnexion de la bdd
if (isset($bdd)) {
	mysqli_close($bdd);
}
       
?>
