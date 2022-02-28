  <?php  session_start();
if(!empty($_SESSION['pseudo']))
   {include('connecte.php');
   }else 
   {
   header('Location: PageAcceuilJeu.php');
   }
?>
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    


</head>
<body>

<?php 
require('fonction_bdd.php');    
$bdd = connecterBDD('localhost','soulagetom','CH3vw79','2018_p0_cpi02_soulagetom');  

$req = seConnecter($_SESSION["pseudo"],$_SESSION["password"]); 
    
$result = mysqli_query($bdd, $req) or die ('Pb requête : '.$req);
    
$utilisateur = $_GET['pseudo_joueur'];
    
$req_other_info = " SELECT * FROM `utilisateur` WHERE `pseudo` = '$utilisateur' ";     
$result_other_info = mysqli_query($bdd, $req_other_info ) or die ('Pb requête : '.$result_other_info);    
$donnees = mysqli_fetch_assoc($result_other_info) ;  


//affichage infos joueurs

echo ' <div id="infos"> 
    <div id="titre_mes_infos">'.$donnees['pseudo'].'</div>
    <div id="infos_bis">
    <div id="nom"> Nom : <span class="info_joueur_">'.$donnees['nom']. ' </span> </div> <br/>
     <div id="prenom"> Prénom : <span class="info_joueur_"> '.$donnees['prenom']. ' </span> </div> <br/>
    <div id="mail">  Adresse mail : <span class="info_joueur_"> '.$donnees['email']. '</span>  </div> <br/>
   <div id="sexe">   Sexe : <span class="info_joueur_"> '.$donnees['sexe']. ' </span> </div> <br/>
   <div id="best_score">   Meilleur score: <span class="info_joueur_">' .$donnees['score']. ' </span>  </div> <br/>
        <div id="niveau"> Niveau: <span class="info_joueur_">' .$donnees['niveau']. '</span>  </div> <br/>
  <div id="piece">   Pièce(s): <span class="info_joueur_"> ' .$donnees['pieces']. '</span>  </div> <br/>
    <div id="statut"> Statut: <span class="info_joueur_"> ' .$donnees['statut']. '</span>  </div> </div> <br/>    
    </div> ' ; 
?>    
    