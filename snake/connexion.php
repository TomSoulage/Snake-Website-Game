<?php 
session_start();  
include('PageAcceuil.html');
require'fonction_bdd.php';
$bdd =connecterBDD('localhost','soulagetom','CH3vw79','2018_p0_cpi02_soulagetom');
if (isset($_POST['pseudo'])and(isset($_POST['password']))) { 
    
$login = htmlspecialchars($_POST['pseudo']);                  //securité
$password= sha1($_POST['password']); //securité : personne ne peut rentrer du code php afin d'accéder à la bdd
$_SESSION["pseudo"]= $login ; 
$_SESSION["password"]= $password ; 
$req = seConnecter($login,$password);
$result = mysqli_query($bdd, $req) or die ('Pb requête : '.$req);
$donnees = mysqli_fetch_assoc($result)  ; 
 if ((empty($donnees)))  {    //verification que l'utilisateur existe
     session_destroy() ; }     
else {     
$_SESSION["statut"]=$donnees["statut"];    
header("Location: monprofil.php");
exit;    
}
 }
?>
<!DOCTYPE html>
<html> 
<head lang="fr">
    <meta charset="UTF-8">
    <title>Se connecter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
</head>    
<body>
<div id="formulaire_connexion" > 
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="titre_formulaire">Connexion</h1>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" action="connexion.php" method="POST">
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="pseudo" class="control-label"> Pseudo </label>
                        </div>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Pseudo">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2">
                            <label for="password" class="control-label">Mot de passe</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" id="boutonconnexion">Me Connecter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div> 
</div> 
    </div>
</body>
</html>

   

    
