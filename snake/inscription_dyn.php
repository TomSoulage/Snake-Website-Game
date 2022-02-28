  <?php session_start() ; ?> 
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">



</head>
<body>


    
 <?php 
require('fonction_bdd.php');  
            
$bdd = connecterBDD('localhost','soulagetom','CH3vw79','2018_p0_cpi02_soulagetom');    
//$bdd = connecterBDD('localhost','root','','projet');  
    
//$req = seConnecter($_SESSION["pseudo"],$_SESSION["password"]);     
//$result = mysqli_query($bdd, $req) or die ('Pb requête : '.$req);        
       

//partie vérification du pseudo   
if (isset($_GET["pseudo_j"])){    
$pseudo_s = ($_GET["pseudo_j"]);   //on recupere le pseudo de l'utilisateur 
$ch_p  = 'pseudo';  //champ : pseudo

    
$requete_s= verif($ch_p,$pseudo_s);   //verifie l'existence du pseudo
$modifier_s = mysqli_query($bdd, $requete_s) or die ('Pb requête : '.$requete_s);
$donnees = mysqli_fetch_row($modifier_s) ;
    
if (!empty($donnees['0'])) {       //cas où le pseudo est déjà utilisé
   echo 'ce pseudo est déjà utilisée' ;
}
}
 
//partie vérification de l'adresse mail
if (isset($_GET["mail_j"])){      
$mail_s = $_GET["mail_j"];
$ch_m = 'email';    
    
$requete_m= verif($ch_m,$mail_s);   //verifie l'existence de l'adresse mail
$modifier_m = mysqli_query($bdd, $requete_m) or die ('Pb requête : '.$req);
$donnees_m = mysqli_fetch_row($modifier_m) ;
    
if (!empty($donnees_m['0'])) {       //cas où l'adresse mail est déjà utilisée
   echo 'cette adresse mail est déjà utilisée' ;
}
}    

//partie vérification des mdp 
if ((!empty($_GET["mdp_"]))&&(!empty($_GET["mdp_conf_"]))){      

if (($_GET["mdp_"])!==($_GET["mdp_conf_"])){
   echo 'Les mots de passe sont différents' ;
}
}


?>
   
</body>

</html>    
