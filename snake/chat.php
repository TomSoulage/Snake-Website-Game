<?php  
 session_start();
if(!empty($_SESSION['pseudo']))
   {include('connecte.php');
   }else 
   {
   header('Location: PageAcceuilJeu.php');
   }?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Le chat des reptiliens</title>
    
  
  </head>
  <body>
    
        <?php  
require('fonction_bdd.php');    

$bdd =connecterBDD('localhost','soulagetom','CH3vw79','2018_p0_cpi02_soulagetom');


if ((isset($_SESSION['pseudo'])) and (isset($_SESSION['password']))){ 
$login = $_SESSION['pseudo'];
$password = $_SESSION['password'];

$req = seConnecter($login,$password);
    
$result = mysqli_query($bdd, $req) or die ('Pb requête : '.$req);

//On récupère l'id de l'utilisateur 
$idUtil = recup_idUtil($login);
$requete_1 = mysqli_query($bdd, $idUtil) or die ('Pb requête : '.$requete_1);  
$id = mysqli_fetch_row($requete_1) ; 
$_SESSION['id'] = $id;

//Envoi d'un message       
if (!empty($_POST['message']))   {
$message = htmlspecialchars($_POST['message']);
$message= mysql_escape_string($_POST['message']);
$requete_2 = ajoute_message($_SESSION['id'][0],$message); 
$result = mysqli_query($bdd, $requete_2) or die ('Pb requête : '.$requete_2); //envoi du message   
} 
    
    
//On affiche les messages
$requete_3 = afficher_message();
$result_2 = mysqli_query($bdd, $requete_3) or die ('Pb requête : '.$requete_3);  
    
    
//On récupère les infos du joueur connecté
$req_inf_joueur_co = " SELECT * FROM `utilisateur` WHERE `pseudo` = '$login' ";     
$result_info = mysqli_query($bdd,  $req_inf_joueur_co) or die ('Pb requête : '.$result_info); 
$infos_joueur_co = mysqli_fetch_assoc($result_info) ;   

$b=0;


echo '   <div class="chatbox">
      <div id="chatlogs"> ';
          
 
      while ($data = mysqli_fetch_row($result_2)){
    
//Affichage des messages du chat :
    
    //- si c'est ceux du joueur connecté          
   
          if ($_SESSION['id'][0]==$data[0]) { 
      
                  
          $b= $b+1 ;  
 

    echo'  <div class="chat self">   '  ;   
              
    echo '<div class="box"> <div class="user-name">'.$login.'  </div>  '; //nom
    echo '  <div class="user-level"> '.$infos_joueur_co['statut'].' </div>  </div>' ;                      
    echo ' <div class="chat-messages">   <div class="chat-date">  '.$data[2].' </div>      '.$data[1].' </div>  '; 
    echo ' ';           
    echo '</div>'        ;  
        //- si c'est ceux des autres joueurs 
              
          }
          else {

          $b= $b+1 ;  
                 
         //on récupère les infos des autres joueurs 
            $req_other_info = " SELECT * FROM `utilisateur` WHERE `id` = '$data[0]' ";     
             $result_other_info = mysqli_query($bdd, $req_other_info ) or die ('Pb requête : '.$result_other_info);    
            $infos_other = mysqli_fetch_assoc($result_other_info) ;   
              
    echo '<div class="chat friend"> ';
    echo  '<div class="box">      <div class="user-name">'.$infos_other['pseudo'].'</div>';
      echo '  <div class="user-level"> '.$infos_other['statut']. '</div> </div>' ;    

              echo '<input hidden id="idJoueurCo" value="'.$_SESSION['id'][0].'"> '; 
              echo '<input hidden id="'.$b.'" value="'.$data[3].'"> '; 
    
     echo ' <div class="chat-messages" > <div class="chat-date">'.$data[2].'<button class="bouton_signalement" id="bouton'.$b.'"
     onclick="signal('.$b.')"> Signaler </button> </div>'.$data[1].' </div>';
        echo '</div>';      
     
              
          }
}

echo'      
     
      </div>

      <div class="chat-form">
    
         <form action="chat.php" method="POST"> 
             <input type="text" class="message" name="message" rows="8" cols="80" placeholder="Envoie ton message aux autres reptiles......................"></input>
        <button type="send message" name="button" type="submit">Envoi!</button>
          </form>
      </div>
    <div id="rep_signalement"></div>  
    </div> ';      
      
    
}
      
?>
       
</body>
</html>


      <script src="chat_js/ajaxGet.js"></script>
      <script src="chat_js/refresh.js"></script>  

 <script type="text/javascript"> 
      
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

  function signal(id_mess){
        
        var id_util_co = document.getElementById('idJoueurCo').value; //id utilisateur ayant signalé le message
  
          var id_message = document.getElementById(id_mess).value; //id du message signalé
    

      
           var btn = document.getElementById('bouton'+id_mess); // affichage manip suppression dans la liste 
      btn.setAttribute("hidden", true); 

        var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);
            document.getElementById("rep_signalement").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET","signal.php?id_util_co="+id_util_co+"&id_mess="+id_message) ; 
        xhttp.send(null); }



</script>
    
