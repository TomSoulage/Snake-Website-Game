<?php session_start();
if(!empty($_SESSION['pseudo']))
   {include('connecte.php');
   }else 
   {
 header('Location: PageAcceuilJeu.php');
   }?>

<!DOCTYPE html>
<html>
<head lang="fr">
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" type="text/css" href="design_inscription" />


</head>
<body>

    

<h1> Liste joueurs </h1>
<?php 
require("fonction_bdd.php");

$bdd =connecterBDD('localhost','soulagetom','CH3vw79','2018_p0_cpi02_soulagetom');
//$bdd =connecterBDD('localhost','root','','projet');
        
$req = "SELECT * FROM utilisateur" ;

$result = mysqli_query($bdd, $req) or die ('Pb requête : '.$req);    
//on affiche le tableau des joueurs
$i=0;
echo '
<div id="tableau_util">
<table border >
    <thead>
        <tr>
            <th colspan="4"> Liste utilisateurs</th>
        </tr>
    </thead>
    <tbody>
    <TH id="entete_level"> NIVEAU </TH>    <TH class="entete_bis"> PSEUDO </TH>    <TH class="entete_bis"> ACTION </TH>
     <TH class="entete_bis">  NOMBRE SIGNALEMENTS </TH>
   
    ' ;   
    
while ($data = mysqli_fetch_assoc($result)){
    if ($data["statut"]<>'admin'){
    echo '     <tr id="t'.$i.'"> <td class="tab_level">'.$data["niveau"].' </td>  '; //niveau
    echo '<td class="tab_pseudo" > '.$data["pseudo"].' </td>'; //pseudo
    echo '<input hidden id="'.$i.'" value="'.$data["pseudo"].'"> ';      
    echo '<td class="tab_action"> <button type="button" onclick="ban('.$i.')" > Bannir </button> </td> '; //bouton pour ban
    echo '<td class="tab_action" > '.$data["nbsignalement"].' </td>'; //pseudo</tr>'; /
    $i= $i +1 ;
    }
}

echo '  </tbody>
</table> 
</div>
<div id="idrep"> </div>' ;    

//on libere la memoire
mysqli_free_result($result);
   
?>

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

  function ban(pseudo){
        
        var x = document.getElementById(pseudo).value; //pseudo utilisateur à ban
       var util = document.getElementById('t'+pseudo); // affichage manip suppression dans la liste 
      util.setAttribute("hidden", true); 
 
        var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);
            document.getElementById("idrep").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET","action_admin.php?pseudo_ban="+x) ; 
        xhttp.send(null); }



</script>
    

 

</body>

</html>

    
