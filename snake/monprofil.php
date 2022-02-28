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
    
$donnees = mysqli_fetch_assoc($result)  ; 

// récupération des infos persos 

$nom = $donnees['nom']; 

$prenom =  $donnees['prenom'];

$pseudo =  $donnees['pseudo'];

$email = $donnees['email'] ;
    
$_SESSION['mail']= $email;

//affichage infos joueurs

echo ' <div id="infos"> 
    <div id="titre_mes_infos"> Mes informations persos</div>
    <div id="infos_bis">
    <div id="nom"> Nom : <span class="info_joueur_">'.$donnees['nom']. ' </span> </div> <br/>
     <div id="prenom"> Prénom : <span class="info_joueur_"> '.$donnees['prenom']. ' </span> </div> <br/>
    <div id="mail">  Adresse mail : <span class="info_joueur_"> '.$donnees['email']. '</span>  </div> <br/>
   <div id="sexe">   Sexe : <span class="info_joueur_"> '.$donnees['sexe']. ' </span> </div> <br/>
   <div id="best_score">   Meilleur score: <span class="info_joueur_">' .$donnees['score']. ' </span>  </div> <br/>
        <div id="niveau"> Niveau: <span class="info_joueur_">' .$donnees['niveau']. '</span>  </div> <br/>
  <div id="piece">   Pièce(s): <span class="info_joueur_"> ' .$donnees['pieces']. '</span>  </div> <br/>
    <div id="statut"> Statut: <span class="info_joueur_"> ' .$donnees['statut']. '</span>  </div> </div> <br/>    
    <button id="bouton_modif_infos" type="button" onclick="maj()">  Mettre a jour les données</button> </div> ' ; 
    

//affichage pour modidication infos joueurs 
    
echo   " 
  <div hidden id='ask_infos'>
    <div id='titre_mes_infos_modif'>Modifier vos informations persos</div> 
       <div id='profil_modif_info' >   
       
        Pseudo : <br>
        <input type='text'   id ='input_pseudo'  name='input_prenom' value='".$pseudo."' onkeyup='verifpseudo_modif(this)'><br> 
        <div id='v_pseudo_modif'></div> 
        
        Prenom : <br>
        <input type='text' id ='input_prenom'  name='input_prenom' value='".$prenom."'><br>
        
        Nom : <br>
        <input id ='input_nom' type='text' name='input_nom' value='".$nom."'><br>
        
        Mail : <br>
        <input id ='input_mail' type='email' name='input_mail' value='".$email."'
               onkeyup='verifmail_modif(this)' > <br>
        <div id='v_mail_modif'> </div>
        Sexe : <br>
        <div id='sexe'>          
                        <input type='radio' id='sexe1' name='input_sexe' value='homme' checked /> <label for='homme'> Homme </label>
                                  <input type='radio' name='input_sexe'  id='sexe2' value='femme' required /> <label for='femme'> Femme </label>
                        
        </div>
        Mot de passe actuel: <br>
        <input id ='mdp_actuel' type='password' name='mdp_actuel' placeholder='Saisir votre mot de passe actuel' onkeyup='verifmdp_modif()' ><br>
        Nouveau mot de passe : <br>
        <input id ='mdp' type='password' name='mdp_' placeholder='Saisir votre nouveau mot de passe' onkeyup='verifmdp_modif()' ><br>
        Confirmation nouveau mot de passe : <br>
        <input id ='confmdp' type='password' name='mdp_conf_' placeholder='Confirmer votre nouveau mot de passe' onkeyup='verifmdp_modif()' ><br>  
        <div id='v_mdp_modif'></div>   
           <div id='modif_profil_bouton'> 
           <button name='test' id='bouton_modif_infos_maj' onclick='maj_infos()'> Modifier les informations </button> 
            <button name='test2' id='bouton_modif_infos_term' onclick='retour()'> Terminer </button> <br>
            </div>   
          <div id='reponse_modif'> </div>  
       </div> 
   
</div>        
 </body>
</html>   ";

?>

<!-- MODIFICATION INFO PERSO -->
<script type="text/javascript"> 
    function retour() {
        window.location.replace("monprofil.php");
    }
    function maj(){
        
        var infos_av_modif = document.getElementById('infos');
        var infos_ap_modif = document.getElementById('ask_infos');
        infos_ap_modif.removeAttribute("hidden"); 
        infos_av_modif.setAttribute("hidden", true);
        }    
    
      
    function getXHR() {
        var xhr = null;
        if (window.XMLHttpRequest) // FF & autres
            xhr = new XMLHttpRequest();
        else if (window.ActiveXObject) { // IE < 7
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
       }        catch (e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
       }
        } else { // Objet non supporté par le navigateur
            alert("Votre navigateur ne supporte pas AJAX");
            xhr = false;
        }
  return xhr;
}

  function maj_infos(){
        var m = document.getElementById("input_mail").value ;
        var ps = document.getElementById("input_pseudo").value ;
        var x = document.getElementById("input_prenom").value ;
        var y = document.getElementById("input_nom").value ;
        var o = document.getElementsByName("input_sexe").value ;
        var mdp = document.getElementById("mdp").value ;
        var mdpconf = document.getElementById("confmdp").value ;
        var mdp_actuel = document.getElementById("mdp_actuel").value ;
       
 //on regarde le sexe selectionné par l'utilisateur connecté
var i;
var tab = document.getElementsByName('input_sexe');
for (i=0;i<tab.length;i++)
{
	if(tab[i].checked)
	{
		var o= tab[i].value;
		break;
	}
}   
        var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);
            document.getElementById("reponse_modif").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET", "monprofil_dyn.php?input_prenom="+x+"&input_mail="+m+"&input_pseudo="+ps+"&input_nom="+y+"&input_sexe="+o+"&mdp_actuel="+mdp_actuel+"&mdp="+mdp+"&mdpconf="+mdpconf,true) ; 
        xhttp.send(null); }


function verifpseudo_modif(champ){
      
  var ps = champ.value;
    
      var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);
            document.getElementById("v_pseudo_modif").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET","inscription_dyn.php?pseudo_j="+ps,true) ; 
        xhttp.send(null); }
        

  function verifmail_modif(champ){
        
        var mail_user = champ.value; //mail utilisateur
 
      var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
    
            document.getElementById("v_mail_modif").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET","inscription_dyn.php?mail_j="+mail_user) ; 
        xhttp.send(null); }
    
     function verifmdp_modif(){
       var mdp = document.getElementById('mdp').value; //valeur mot de passe
       var mdp_conf = document.getElementById('confmdp').value; //valeur mot de passe confirmation
      var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            
            document.getElementById("v_mdp_modif").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET","inscription_dyn.php?mdp_="+mdp+"&mdp_conf_="+mdp_conf) ; 
        xhttp.send(null); }
    
</script>
    
    
     
 
 