<?php 
session_start();
if(isset($_SESSION['pseudo'])) { 
include('connecte.php');
} else {
include('PageAcceuil.html'); } ?>
<!DOCTYPE html>
<html> 
<head lang="fr">
    <meta charset="UTF-8">
    <title> Classement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" type="text/css" href="design_tableau.css" />


</head>    
<body>


   
    <?php  
require('fonction_bdd.php');    

$bdd =connecterBDD('localhost','soulagetom','CH3vw79','2018_p0_cpi02_soulagetom');


$req = classement();
$result = mysqli_query($bdd, $req) or die ('Pb requête : '.$req);    
//on affiche le tableau
$position = 1 ; 
$j= 0;    
echo '
<div id="classement">
    <table border>
    <thead>
        <tr>
            <th colspan="3" id="entete" > TOP 10 SCORE </th>
        </tr>
    </thead>
    <tbody>
   <TH class="entete_bis"> POSITION</TH>    <TH class="entete_bis"> PSEUDO </TH>    <TH class="entete_bis"> SCORE </TH>
    ' ;   
    
while (($data = mysqli_fetch_row($result)) and ( $position < 11 )){
    echo '     <tr class="ligne_class"> <td>'.$position.' </td>  '; //position
    echo '      <td> <span onclick="profil_joueur('.$j.')">'.$data[0].'</span> </td>  '; //pseudo
     echo '<input hidden id="'.$j.'" value="'.$data[0].'"> '; 
    echo '<td> '.$data[1].' </td> </tr>'; //score
    $position = $position + 1 ;
    $j = $j + 1;
}

echo '  </tbody>
</table>
</div>' ;
echo '<div id="aff_profil"> </div>' ;  
 
//on libere la memoire
mysqli_free_result($result);

?>
   
</body>
</html>


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

  function profil_joueur(util){
        
        var utilisateur = document.getElementById(util).value;
       var classement = document.getElementById('classement');
        var rep = document.getElementById('aff_profil');
        rep.removeAttribute("hidden"); 
        classement.setAttribute("hidden", true);

        var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);
            
             document.getElementById("aff_profil").innerHTML = xhttp.responseText ;
          
               
        }
        }
        xhttp.open("GET","afficherProfil.php?pseudo_joueur="+utilisateur) ; 
        xhttp.send(null);
     
  }



</script>
    