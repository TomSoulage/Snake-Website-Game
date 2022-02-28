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
       

$pseudo_s = $_GET["pseudo_ban"];   //on recupere le pseudo de l'utilisateur à bannir

//on récupère l'adresse mail à bannir 
$requete_mail= recup_adresse_mail($pseudo_s)  ;
$recup_mail = mysqli_query($bdd, $requete_mail) or die ('Pb requête : '.$requete_mail);

$mail = mysqli_fetch_row($recup_mail); 
echo $mail[0];    
$requ_ban =ban_compte($mail[0]);  
    
$ban_mail = mysqli_query($bdd, $requ_ban) or die ('Pb requête : '.$requ_ban);
    
    
    
    
//on bannit le joueur 
$requete_s= supprimer_compte($pseudo_s)  ;
$modifier_s = mysqli_query($bdd, $requete_s) or die ('Pb requête : '.$requete_s);
 


?>
   
</body>

</html>    