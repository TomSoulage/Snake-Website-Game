  <?php session_start();
require('fonction_bdd.php');  
if(!empty($_SESSION['pseudo']))
   {include('connecte.php');
   }else 
   {
   header('Location: PageAcceuilJeu.php');
   } ?>
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Modification informations profil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>

  
<?php 
    

            
$bdd = connecterBDD('localhost','soulagetom','CH3vw79','2018_p0_cpi02_soulagetom');    

    
$req = seConnecter($_SESSION["pseudo"],$_SESSION["password"]);     
$result = mysqli_query($bdd, $req) or die ('Pb requête : '.$req);        


//recupère les données de l'utilisateur connecté

$pseudo = $_SESSION['pseudo'];   
$mail = $_SESSION['mail'];

//Récupération des valeurs des champ modifiés par l'utilisateur:  


$nv_pseudo = htmlspecialchars($_GET['input_pseudo']) ;  
$nv_prenom = htmlspecialchars($_GET['input_prenom']) ;   
$nv_nom = htmlspecialchars($_GET['input_nom']) ;   
$nv_email = htmlspecialchars($_GET['input_mail']) ;   
$nv_sexe = htmlspecialchars($_GET['input_sexe']) ; 



//Champ à modifier
$ch_pseudo= 'pseudo';
$ch_prenom= 'prenom';
$ch_nom= 'nom';
$ch_email= 'email';
$ch_sexe= 'sexe';   
$ch_mdp = 'mdp' ;
    
//On vérifie quels champs ont été modifé par l'utilisateur: 

//pseudo : 

if ($nv_pseudo !== ''){ 

//verifie l'existence du pseudo    
$requete_nvpseudo= verif($ch_pseudo,$nv_pseudo);  
$modifier_nvpseudo = mysqli_query($bdd, $requete_nvpseudo) or die ('Pb requête : '.$requete_nvpseudo);
$donnees = mysqli_fetch_row($modifier_nvpseudo) ;
    
if ((!empty($donnees['0'])) and ($nv_pseudo !== $pseudo)) {       //cas où le pseudo est déjà utilisé
   echo 'Pas de modification du pseudo!' ;
} else    {
   
$requete_ps=  modifier_info($ch_pseudo,$pseudo,$nv_pseudo) ;
$modifier_ps = mysqli_query($bdd, $requete_ps) or die ('Pb requête : '.$requete_ps);
$_SESSION['pseudo'] = $nv_pseudo;   
    
}
}

//prenom : 
if ($nv_prenom !== ''){ 
$requete_p=  modifier_info($ch_prenom,$pseudo,$nv_prenom) ;
$modifier_p = mysqli_query($bdd, $requete_p) or die ('Pb requête : '.$requete_p);
}

if ($nv_nom !== ''){ 
$requete_n=  modifier_info($ch_nom,$pseudo,$nv_nom) ;
$modifier_n = mysqli_query($bdd, $requete_n) or die ('Pb requête : '.$requete_n);
}
    
//modification adresse mail  

if ($nv_email !== ''){ 
$requete_m= verif($ch_email,$nv_email);   //verifie l'existence de l'adresse mail
$modifier_m = mysqli_query($bdd, $requete_m) or die ('Pb requête : '.$requete_m);
$donnees_m = mysqli_fetch_row($modifier_m) ;
    
if ((!empty($donnees_m['0'])) and ($nv_email !== $mail)) {       //cas où l'adresse mail est 
   echo 'Pas de modification du pseudo!' ;
} else { 
$requete_mail=  modifier_info($ch_email,$pseudo,$nv_email) ;
$modifier_mail = mysqli_query($bdd, $requete_mail) or die ('Pb requête : '.$requete_mail);
$nv_email = $_SESSION['mail'];

}
}

//modification sexe    
if ($nv_sexe !== ''){ 
$requete_s=  modifier_info($ch_sexe,$pseudo,$nv_sexe) ;
$modifier_s = mysqli_query($bdd, $requete_s) or die ('Pb requête : '.$requete_s);
}    

//Changement nouveau mot de passe


//si l'utilisateur a choisi de changer son mot de passe
if (!empty($_GET['mdp_actuel'])){
      
//on vérfie que le mot de passe  actuel saisie correspond à celui de la session 
    if (sha1($_GET['mdp_actuel'])==$_SESSION["password"]){    
  
//on vérifie si l'utilisateur a saisie son nouveau mot de passe ( deux fois)
        if ( (!empty($_GET['mdp'])) and (!empty($_GET['mdpconf'])) ) { 
  
$nv_mdp = htmlspecialchars($_GET['mdp']) ;
$nv_mdpconf = htmlspecialchars($_GET['mdpconf']) ;
    
            if (($nv_mdp)==($nv_mdpconf)) {  //si les nouveaux mdp sont les mêmes 
        
        $nv_mdp= sha1($nv_mdp) ; //sha1 : hachage du mot de passe (securité) 
                
        $requete_mdp=  modifier_info($ch_mdp,$pseudo,$nv_mdp) ; //changement mot de passe
        $modifier_mdp = mysqli_query($bdd, $requete_mdp) or die ('Pb requête : '.$requete_mdp);
        $_SESSION['password']= $nv_mdp ;
    } 


}
}
}





?>
   
</body>

</html>    
    
