  <?php session_start();
if(!empty($_SESSION['pseudo']))
   {include('connecte.php');
   }else 
   {
   include('PageAcceuil.html');
   }?> 
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
       
$id_util_co = $_GET['id_util_co'];
$id_mess = $_GET['id_mess'];
 
//on cherche l'auteur du message 
$aut = auteur_message($id_mess);
$req_auteur_message = mysqli_query($bdd, $aut) or die ('Pb requête : '.$req_auteur_message); 

$auteurMessage = mysqli_fetch_row($req_auteur_message);     
    
//on signale le message
$requete_signaler= signal_message($id_util_co,$id_mess,$auteurMessage[0])  ;
$signalement = mysqli_query($bdd, $requete_signaler) or die ('Pb requête : '.$requete_signaler);
    
//on récupère le nombre de signalement d'un joueur

$nb_s = nb_signal($auteurMessage[0]);
$req_nb_signal = mysqli_query($bdd, $nb_s) or die ('Pb requête : '.$req_nb_signal); 
$nb = mysqli_fetch_row($req_nb_signal);     
echo $nb[0];
        
$nouveau_signalement = $nb[0] + 1 ;    
    

//on ajoute un nombre de signalement au joueur signalé ;
$requete_ajout_signalement =  ajoute_signal($auteurMessage[0],$nouveau_signalement); 
$aj_sign = mysqli_query($bdd, $requete_ajout_signalement) or die ('Pb requête : '.$requete_ajout_signalement);
    
echo'message signalé!' ;

?>
   
</body>

</html>    