<?php     

//ce fichier regroupe différentes fonctions utilisants des requêtes SQL.


//fonction qui permet de se connecter à la bdd
function connecterBDD($server, $user, $pass, $basedd) {

        $DBconn = mysqli_connect($server, $user, $pass,$basedd);
        if (!$DBconn) {
            die("Erreur: " . mysqli_connect_error());
        }

        return $DBconn;
    }

//fonction qui permet de se déconnecter de la bdd
    function deconnecterBDD($DBconn) {
        if (isset($DBconn)) {
            mysqli_close($DBconn);
        }
    }

//fonction qui permet d'inscrire un joueur
function insertUser($pseudo,$nom,$prenom,$email,$mdp,$sexe) 
{
   $requete = "INSERT INTO `utilisateur` (`pseudo`,`nom`, `prenom`,`email`,`mdp`,`sexe`,`niveau`,`statut`) VALUES ('$pseudo','$nom','$prenom','$email','$mdp','$sexe','serpenteau','joueur')";  
    return $requete;
}

//fonction qui permet de se connecter

function seConnecter($pseudo,$mdp){
    $requete =  "SELECT * FROM `utilisateur` WHERE `pseudo` = '$pseudo' and `mdp` = '$mdp' ";
    return $requete;
}

//fonction qui permet de modifier son pseudo
function modifierPseudo($pseudo,$nouveauPseudo) {
    $requete= "UPDATE `utilisateur` SET `pseudo`= '$nouveaupseudo' WHERE `pseudo`= '$pseudo'";
    
    return $requete;
}

//fonction qui affiche le classement des joueurs en fonction de leur score dans l'ordre décroissant
 
function classement(){
    $requete = "SELECT `pseudo`, `score` FROM `utilisateur` ORDER BY `score` DESC" ; 
    return $requete;
}

//fonctions permettant de bannir un utilisateur
function recup_adresse_mail($pseudo){
    $requete= "SELECT `email` FROM `utilisateur` WHERE `pseudo`='$pseudo'";
    return $requete ;
}

//fontion qui ajoute les adresses mails au compte à bannir
function ban_compte($mail){
    $requete = "INSERT INTO `ban`(`adressemail`) VALUES ('$mail')";
        return $requete ;
}

function supprimer_compte($pseudo){
    $requete = "DELETE FROM `utilisateur` WHERE `pseudo`='$pseudo'" ;
    return $requete; 
    }


//fonction qui permet de remplacer la valeur d'un champ 

function modifier_info($champ,$pseudo,$new_info){
  $requete = "UPDATE `utilisateur` SET `$champ` = '$new_info' WHERE `pseudo`='$pseudo' ";

    return $requete ;
}

//fonction qui récupère l'id d'un utilisateur 

function recup_idUtil($pseudo) {
        $requete = "SELECT `id` FROM `utilisateur` WHERE `pseudo` = '$pseudo'";
    return $requete ;
    
}

//fonction qui ajoute un message dans le chat

function ajoute_message($id_util, $message){
    
   $date = date("Y-m-d H:i:s") ; // new DateTime();
    $requete_send_message = "INSERT INTO `chat`(`idMessage`, `idMembre`, `message`, `date`) VALUES ('','$id_util','$message','$date')" ;
    return $requete_send_message; 
    }

//fonction qui affiche les messsages dans le chat 

function afficher_message(){ 
$requete = 'SELECT `idMembre`, `message`,`date`, `idMessage` FROM chat ORDER BY `date` DESC LIMIT 0, 10' ; 
return $requete ;
}


//fonction qui cherche l'auteur d'un message 
function auteur_message($message){
    $requete_auteur = "SELECT `idMembre` FROM `chat` WHERE `idMessage`='$message'" ;
    return $requete_auteur; 
    }

//fonction qui signale des messages du chat
function signal_message($id_util, $message,$id_util_signal){
    $requete_signal = "INSERT INTO `signalement`(`idMessage`, `idJoueurAyantSignale`, `idJoueurSignale`) VALUES ('$message','$id_util','$id_util_signal')" ;
    return $requete_signal; 
    }

//fonction qui récupère le nombre de signalement d'un joueur
function nb_signal($idJoueurSignale){
    $requete_nb_signal =  "SELECT `nbsignalement` FROM `utilisateur` WHERE `id`='$idJoueurSignale'";
    return $requete_nb_signal; 
}


//fonction qui ajoute un signalement à un utilisateur signalé
function ajoute_signal($idJoueurSignale,$valeur){
    $requete_ajout_signal =  "UPDATE `utilisateur` SET `nbsignalement` = '$valeur' WHERE `id`='$idJoueurSignale' ";
    return $requete_ajout_signal; 
}



function verif_pseudo($pseudo){
    $requete =  "SELECT * FROM `utilisateur` WHERE `pseudo` = '$pseudo' ";
    return $requete;
}

//fonction qui vérifie si un champ (pseudo ou email par exemple) est déjà utilisé par un utilisateur ou pas 

function verif($champ,$valeur){
    $requete =  "SELECT * FROM `utilisateur` WHERE `$champ` = '$valeur' ";
    return $requete;
}

function ajouterImg($image,$pseudo){
    $requete= "UPDATE `utilisateur` SET `image` = '$image./' WHERE `pseudo` ='$pseudo'' ";
    return $requete ;
}





