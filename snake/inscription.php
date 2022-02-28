<?php include ('PageAcceuil.html') ; ?>

<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   


</head>
<body>

<div id="formulaire_inscription" >     
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="titre_formulaire">Inscription</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form id="myForm" role="form" action="inscription.php" method="POST" onmouseover="verifForm()">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="testest" class="control-label">Pseudo</label>
                        </div>
                        <div class="col-sm-10">
                          
                            <input class="form-control" name="pseudo" id="pseudo" placeholder="Pseudo" onkeyup="verifpseudo(this)"
                                    required>
                            
                              <div id='v_pseudo'></div>
                        </div>
                      
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="nom" class="control-label">Nom</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="prenom" class="control-label">Prénom</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="tel" class="control-label">Sexe</label>
                        </div>
                        <div class="col-sm-10">
                        <input type="radio" name="sexe" value="homme" id="sexe1" checked /> <label for="homme"> Homme </label>
                                  <input type="radio" name="sexe" value="femme" id="sexe2" required /> <label for="femme"> Femme </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="email" class="control-label">Email</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" onkeyup="verifmail(this)" required>
                            <div id="v_mail"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Mot de passe</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" onkeyup="verifmdp()"  required>
                        </div>
                    </div>
         
                                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="conf_password" class="control-label">Confirmer Mot de passe</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password_conf" name="password_conf" placeholder="Confirmer mot de passe" onkeyup="verifmdp()"   required>
                                 <div id="v_mdp"></div>
                        </div>
                    </div>    
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" id="boutonvalidation" hidden >Créer mon compte</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>    
<?php 
require("fonction_bdd.php");

$bdd =connecterBDD('localhost','soulagetom','CH3vw79','2018_p0_cpi02_soulagetom');


    

    
    
//on vérifie que tous les champs
    if ((!empty($_POST['nom'])) and (!empty($_POST['prenom'])) and (!empty($_POST['pseudo'])) and (!empty($_POST['email'])) and (!empty($_POST['sexe'])) and (!empty($_POST['password_conf'])) and (!empty($_POST['password'])))
    {
        
//on revérifie que le mdp rentré et le même que celui que le mdp dans la confirmation
        
if($_POST['password']==$_POST['password_conf'] ) { 

$pseudo_inscrit = htmlspecialchars($_POST['pseudo']);  
    
    
$nom_inscrit = htmlspecialchars($_POST['nom']);    

$prenom_inscrit = htmlspecialchars($_POST['prenom']);  

$email_inscrit = htmlspecialchars($_POST['email']);  
    
$sexe_inscrit = htmlspecialchars($_POST['sexe']);      

    

$password_inscrit = sha1($_POST['password']); //sha1 : hachage du mot de passe (securité)
header('Location: monprofil.php');      
$req = insertUser($pseudo_inscrit,$nom_inscrit,$prenom_inscrit,$email_inscrit,$password_inscrit,$sexe_inscrit) ;   
$result = mysqli_query($bdd, $req) or die ('Pb requête : '.$req);  
  
} 
        else { echo 'Les mots de passes sont différents veuillez réssayer !'  ; }
    } 

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
    
    
  function verifpseudo(champ){
      

       var pseudo_user = champ.value; //pseudo utilisateur
      var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            console.log(this);
            document.getElementById("v_pseudo").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET","inscription_dyn.php?pseudo_j="+pseudo_user) ; 
        xhttp.send(null); }
    
  function verifmail(champ){
        
        var mail_user = champ.value; //pseudo utilisateur
      //var pseudo_user = "Tom";  
      var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
    
            document.getElementById("v_mail").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET","inscription_dyn.php?mail_j="+mail_user) ; 
        xhttp.send(null); }

      function verifmdp(){
       var mdp = document.getElementById('password').value; //valeur mot de passe
       var mdp_conf = document.getElementById('password_conf').value; //valeur mot de passe confirmation
      var xhttp = getXHR();
      
             xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && xhttp.status == 200){
            
            document.getElementById("v_mdp").innerHTML = xhttp.responseText ;
            
        }
        }
        xhttp.open("GET","inscription_dyn.php?mdp_="+mdp+"&mdp_conf_="+mdp_conf) ; 
        xhttp.send(null); }
//a="+x+"&b="+y
    
    function verifForm(){

     document.getElementById('boutonvalidation').removeAttribute("hidden",false);
        
    var str_pseudo = document.getElementById('v_pseudo').textContent; //contenu du div contenant la réponse 'ce pseudo est déjà utilisé'
        
    var str_mail = document.getElementById('v_mail').textContent ;
    //contenu du div contenant la réponse 'ce mail est déjà utilisé'
    var str_mdp =  document.getElementById('v_mdp').textContent ;
    //contenu du div contenant la réponse 'les mot de passe sont différents'
    
    var regex = RegExp('e');      
        
    //vérification que tous les champs sont remplies/ou bon
    if(
         (regex.test(str_mdp)) || //verifie que les mdp sont différents 
        (regex.test(str_pseudo)) || //verifie que le pseudo n'est pas déjà utilisé 
        (regex.test(str_mail)) || //verifie que le mail n'est pas déjà utilisé
        (document.getElementById('nom').value=='') || (document.getElementById('prenom').value=='') ||  (document.getElementById('pseudo').value=='') ||
        (document.getElementById('password').value=='') ||   (document.getElementById('password_conf').value=='') ||
        ((document.getElementById('sexe1').value=='') && (document.getElementById('sexe2').value=='')))
    {
    document.getElementById('boutonvalidation').innerHTML='Remplir tous les champs  correctement pour créer votre compte';  document.getElementById('boutonvalidation').setAttribute("disabled",false);
     
        //si un des champs est vide on désactive le bouton d'envoi
    } 
    else {
                //si tous les champs sont valides alors on peut envoyé le formulaire
          document.getElementById('boutonvalidation').removeAttribute("disabled");
              document.getElementById('boutonvalidation').innerHTML='Créer votre compte';  


    }
}

</script>    
</body>

</html>

    
