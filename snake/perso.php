<?php
	session_start();

//connexion a la bdd
$bdd = mysqli_connect('localhost', 'soulagetom', 'CH3vw79', '2018_p0_cpi02_soulagetom');

//verification de la connexion 
if (!$bdd) {
	die("Erreur: " . mysqli_connect_error());
}

$pseudo = $_SESSION['pseudo'];
$couleur = $_POST['couleur'];
$map=$_POST['map'];

// on set le meilleur score dans la bdd 
$sql = "UPDATE utilisateur SET couleur = '$couleur' WHERE pseudo = '$pseudo'";

$resultat = mysqli_query($bdd, $sql) or die ('Pb requête : '.$sql);

$sql1 = "UPDATE utilisateur SET map = '$map' WHERE pseudo= '$pseudo'";

$resultat1 = mysqli_query($bdd, $sql1) or die ('Pb requête : '.$sql1);
echo $resultat1;
//deconnexion de la bdd
if (isset($bdd)) {
	mysqli_close($bdd);
}
       
?>
