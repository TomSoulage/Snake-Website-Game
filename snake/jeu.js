/*
Fichier : jeu.js
Contenu : toutes les fonctionnalités du Snake Game
Auteurs : Jesse Dingley & Kilian Peytavy
*/


/* -------------------------------------
Type         : Procedure
Nom          : arreteDefilementPageJeu
Auteur       : Zeta
Date         : Avril 2015
But          : arreter le défilement de la page lorsqu'on joue
Commentaires : source : https://stackoverflow.com/questions/8916620/disable-arrow-key-scrolling-in-users-browser
Pre-cond     :
Post-cond    :
---------------------------------------
*/
function arreteDefilementPageJeu() {
  var keys = {};
  window.addEventListener("keydown",
      function(e){
          keys[e.keyCode] = true;
          switch(e.keyCode){
              case 37: case 39: case 38:  case 40: // Arrow keys
              case 32: e.preventDefault(); break; // Space
              default: break; // do not block other keys
          }
      },
  false);
  window.addEventListener('keyup',
      function(e){
          keys[e.keyCode] = false;
      },
  false);
}


// on recupere l'élément canvas
var canvasSnake = document.getElementById('canvasSnake');

// on définit les dimensions du canvas
canvasSnake.width = 400;
canvasSnake.height = 400;

// on definit le contexte / type du canvas
var contexteCanvasSnake = canvasSnake.getContext('2d');

// on recupere l'image de fond
let imageFond = document.getElementById('fond');

// on recupere l'image démarrer
let imageDemarrePartie = document.getElementById('imageDemarrePartie');

// on recupere l'image fin
let imageFinPartie = document.getElementById('finPartie');

// on recupere l'image de pause
let imagePause = document.getElementById('imagePause');


/* -------------------------------------
Type         : Procedure
Nom          : initCanvasSnake
Auteur       : Jesse Dingley
Date         : 8 Mai
But          : initialiser le canvas
Commentaires :
Pre-cond     :
Post-cond    :
---------------------------------------
*/
function initCanvasSnake() {
  contexteCanvasSnake.drawImage(imageFond,0,0,canvasSnake.width,canvasSnake.height);
}


/* -------------------------------------
Type         : Procedure
Nom          : afficheMessageFinPartie
Auteur       : Jesse Dingley
Date         : 20 Mai
But          : aficher les messages de fin
Commentaires :
Pre-cond     :
Post-cond    :
---------------------------------------
*/
function afficheMessageFinPartie() {

  // on affiche le message
  contexteCanvasSnake.drawImage(imageFinPartie,canvasSnake.width/2-105,canvasSnake.height/2-50,210,100);
  contexteCanvasSnake.strokeStyle = "#666666";
  contexteCanvasSnake.strokeRect(canvasSnake.width/2-105,canvasSnake.height/2-50,210,100);

  // on affiche le score
  contexteCanvasSnake.font = "26px Sans ";
  contexteCanvasSnake.fillStyle = "white";
  contexteCanvasSnake.fillText(score,245,228);

}


/* -------------------------------------
Type         : Procedure
Nom          : afficheMessageJeuEnPause
Auteur       : Jesse Dingley
Date         : 29 Mai
But          : aficher message jeu en pause
Commentaires :
Pre-cond     :
Post-cond    :
---------------------------------------
*/
function afficheMessageJeuEnPause() {

  // on affiche le message
  contexteCanvasSnake.drawImage(imagePause,canvasSnake.width/2-105,canvasSnake.height/2-50,210,120);
  contexteCanvasSnake.strokeStyle = "#666666";
  contexteCanvasSnake.strokeRect(canvasSnake.width/2-105,canvasSnake.height/2-50,210,120);

}


// on initialise le snake comme un tableau de coord
var snake = [
  {x:50, y:250}, // tete
  {x:40, y:250},
  {x:30, y:250}, // queue
];

// couleur initiale du snake
var couleur = '#805500';

// on initialise les deplacements possibles du snake:
// (au debut il ne peut aller qu'à droite)
var avanceX = 10;
var avanceY = 0;

// vitesseDeplacement deplacement
var vitesseDeplacement = 60;

// on definit les touches possibles pour deplacer
let toucheGauche = 37;
let toucheDroite = 39;
let toucheHaut = 38;
let toucheBas = 40;

// on definit les coord d'un Pomme a poser comme une var globale
var coordPomme;

// on definit les coord d'une banane
var coordBanane;

// on definit les coord du diamant
var coordDiamant;

// plusieurs bombes à poser donc on crée un tableau de coord de bombes
var coordBombe = [
  {x:1100, y:1100}
];

// on initialise le score
var score = 0;

// on initialise le compteur du setTimeout
var comptTimeout = 0 ;

// le boucle du jeu
var boucle;

// on définit l'état du jeu i.e. en pause ou en jeu
// au début, le jeu n'est pas en pause
var jeuEnPause = false;

// pour les bananes, diamants et bombes
var multipleDeCent; // bombes
var multipleDeDeuxCent; // bananes
var multipleDeDiams; // diamants


// on recupere l'image de la pomme
let imagePomme = document.getElementById('pomme');

// on recupere l'image de la  banane;
let imageBanane = document.getElementById('banane');

// on recupere l'image de la tete du snake
let imageSnakeTete = document.getElementById('tete');

// on recupere l'image de la bombe
let imageBombe = document.getElementById('bomb');

// on recupere l'image du diamant
let imageDiamant = document.getElementById('diamant');


// détection d'une touche appuyé
document.addEventListener('keydown',modifieDirectionSnakeClavier);
document.addEventListener('keydown',pause);
document.addEventListener('keydown',reprise);



/* -------------------------------------
Type         : Fonction
Nom          : modifieDirectionSnakeClavier
Auteur       : Jesse Dingley
Date         : 8 Mai
But          : definit le deplacement souhaité par l'utilisateur
Commentaires : cest implémenté dans jouerPartie()
Pre-cond     : event (touche appuyé)
Post-cond    : nvx valeurs de avanceX et avanceY
---------------------------------------
*/
function modifieDirectionSnakeClavier(event) {

  // Cas utilisateur a appuyé sur deux flèches en
  // en moins de temps que vitesseDeplcement
  // ( il faut pas qu'on puisse changer de direction dans le lapse de temps)
  if (modifieDirectionSnakeClavier) {
    return;
  }

  modifieDirectionSnakeClavier = true;

  // on recupere les états de déplacement
  var deplacementGauche = avanceX == -10;
  var deplacementDroite = avanceX == 10;
  var deplacementHaut = avanceY == -10;
  var deplacementBas =  avanceY == 10;

  // on recupere la valeur de la touche appuyé
  var toucheAppuye = event.which || event.keyCode;


  // on traite les cas des touches
  switch (toucheAppuye) {
    case toucheGauche:
      if (!deplacementDroite && !deplacementGauche) {
        avanceX = -10;
        avanceY = 0;
      }
    break;
    case toucheDroite:
      if (!deplacementGauche && !deplacementDroite) {
        avanceX = 10;
        avanceY = 0;
      }
    break;
    case toucheHaut:
      if (!deplacementBas && !deplacementHaut) {
        avanceX = 0;
        avanceY = -10;
      }
    break;
    case toucheBas:
      if (!deplacementHaut && !deplacementBas) {
        avanceX = 0;
        avanceY = 10;
      }
    break;
  }
}


/* -------------------------------------
Type         : Fonction
Nom          : changeDeSensDiamant
Auteur       : Kilian Peytavy
Date         : 16 Mai
But          : changer ke sens de deplacement lorsqu'on mange un diamant
Commentaires :
Pre-cond     :
Post-cond    : inverse le sens de deplacement du serpent
---------------------------------------
*/
function changeDeSensDiamant(){

  var taille = snake.length;

  // on regarde l'état de déplacement du snake
  if ((snake[taille-1].x == snake[taille-2].x) && (snake[taille-1].y == snake[taille-2].y + 10)){
      avanceX = 0;
      avanceY = 10;
  }

  if ((snake[taille-1].x == snake[taille-2].x) && (snake[taille-1].y == snake[taille-2].y - 10)){
      avanceX = 0;
      avanceY = -10;
  }

  if ((snake[taille-1].x == snake[taille-2].x + 10) && (snake[taille-1].y == snake[taille-2].y)){
      avanceX = 10;
      avanceY = 0;
  }

  if ((snake[taille-1].x == snake[taille-2].x - 10) && (snake[taille-1].y == snake[taille-2].y)){
      avanceX = -10;
      avanceY = 0;
  }

  // on l'inverse
  snake.reverse();

}

/* -------------------------------------
Type         : Procedure
Nom          : deplaceSnake
Auteur       : Jesse Dingley
Date         : 8 Mai
But          : faire deplacer le snake
Commentaires :
Pre-cond     :
Post-cond    : affiche snake avec un deplacement de 10px
---------------------------------------
*/
function deplaceSnake() {

  // on redifinit les coord de la tete
  var nouveauTete = {x: snake[0].x + avanceX, y: snake[0].y + avanceY};

  // on concatene la tete avec le snake :
  snake.unshift(nouveauTete);

  // on définie les états de bouffe
  var aMangerPomme = snake[0].x == coordPomme[0] && snake[0].y == coordPomme[1];
  var aMangerBanane = comptTimeout >= 201 && snake[0].x == coordBanane[0] && snake[0].y == coordBanane[1] ;
  var aMangerDiamant = comptTimeout >= 501 && snake[0].x == coordDiamant[0] && snake[0].y == coordDiamant[1];

  // cas a mangé une pomme
  if (aMangerPomme) {
    // on incremente le score
    score++;

    // on augmente la vitesse
    vitesseDeplacement = vitesseDeplacement - vitesseDeplacement*0.025;

    // on cree un nv pomme
    creerCoordPomme();

  // cas a mangé une banane
  } else if (aMangerBanane) {
    // on incremente le score
    score++;

    // on reduit la taille du snake
    snake.pop();
    snake.pop();

    // on efface la banane, donc on le met en dehors du terrain
    coordBanane = [1000,1000];

  } else if (aMangerDiamant) {
    // on incremente le score de 3
    score = score + 3;

    // on change le sens du snake
    changeDeSensDiamant();

    snake.pop();

    // effacement
    coordDiamant = [1001,1001];
  } else {
    // on enleve la queue
    snake.pop();
  }

}


/* -------------------------------------
Type         : Procedure
Nom          : changeCouleur
Auteur       : Kilian Peytavy
Date         : 22 Mai
But          : changer la couleur du snake
Commentaires :
Pre-cond     :
Post-cond    : 
---------------------------------------
*/
function changeCouleur() {
  couleur = document.getElementById('couleur').value;
}


/* -------------------------------------
Type         : Fonction
Nom          : dessineUnCarreSnake
Auteur       : Jesse Dingley
Date         : 8 Mai
But          : Dessiner un carré du Snake
Commentaires :
Pre-cond     : coord du carré
Post-cond    : affiche carré
---------------------------------------
*/
function dessineUnCarreSnake (carreSnake) {
  // cas tete
  if (carreSnake == snake[0]) {
    // on dessine la tete
    contexteCanvasSnake.drawImage(imageSnakeTete,carreSnake.x,carreSnake.y,10,10);
  } else {
    // on dessine le reste
    contexteCanvasSnake.fillStyle = couleur;//= "#805500";
    contexteCanvasSnake.fillRect(carreSnake.x, carreSnake.y, 10, 10);
  }
}


/* -------------------------------------
Type         : Procedure
Nom          : dessineSnake
Auteur       : Jesse Dingley
Date         : 8 Mai
But          : Dessiner le snake en entier
Commentaires :
Pre-cond     :
Post-cond    : affiche snake
---------------------------------------
*/
function dessineSnake() {
  // on parcours le tableau snake
  for (var i = 0; i < snake.length; i++) {
    dessineUnCarreSnake(snake[i]);
  }
}


/* -------------------------------------
Type         : Fonction
Nom          : perteMur
Auteur       : Jesse Dingley
Date         : 10 Mai
But          : dire si le joueur perd en touchant un mur
Commentaires :
Pre-cond     :
Post-cond    : bool
---------------------------------------
*/
function perteMur() {

  // 4 cas pour les 4 murs
  var toucheMurGauche = snake[0].x < 0;
  var toucheMurDroit = snake[0].x > canvasSnake.width - 10;
  var toucheMurHaut = snake[0].y < 0;
  var toucheMurBas = snake[0].y > canvasSnake.height - 10;

  return toucheMurGauche || toucheMurDroit || toucheMurHaut || toucheMurBas ;

}


/* -------------------------------------
Type         : Fonction
Nom          : perteSnake
Auteur       : Jesse Dingley
Date         : 10 Mai
But          : dire si le joueur perd en allant sur lui meme
Commentaires :
Pre-cond     :
Post-cond    : bool
---------------------------------------
*/
function perteSnake() {
  var res = false;

  // on parcours le snake à partir de 4 car les trois premiers carrés ne peuvent pas se toucher
  for (var i = 4; i < snake.length; i++) {
    // on regarde s'il y a deux carrés de memes coord
    var touche = snake[i].x == snake[0].x && snake[i].y == snake[0].y;
    if (touche) {
      res = true;
    }
  }
  return res;
}


/* -------------------------------------
Type         : Fonction
Nom          : perteBombe
Auteur       : Jesse Dingley
Date         : 13 Mai
But          : dire si le joueur meurt en toucahnt une bombe
Commentaires :
Pre-cond     :
Post-cond    : bool
---------------------------------------
*/
function perteBombe() {
  var res = false;
  for (var i = 0; i < coordBombe.length; i++) {
    if (snake[0].x == coordBombe[i].x && snake[0].y == coordBombe[i].y) {
      res = true;
    }
  }
  return res;
}


/* -------------------------------------
Type         : Fonction
Nom          : perteBanane
Auteur       : Jesse Dingley
Date         : 13 Mai
But          : dire si le joueur meurt en  mangeant trop de bananes
Commentaires :
Pre-cond     :
Post-cond    : bool
---------------------------------------
*/
function perteBanane() {
  return snake.length == 1;
}


/* -------------------------------------
Type         : Fonction
Nom          : perte
Auteur       : Jesse Dingley
Date         : 10 Mai
But          : dire si le joueur a perdu
Commentaires :
Pre-cond     :
Post-cond    : bool
---------------------------------------
*/
function perte() {
  return perteMur() || perteSnake() || perteBombe() || perteBanane();
}


/* -------------------------------------
Type         : Fonction
Nom          : coordAlea
Auteur       : Jesse Dingley
Date         : 12 Mai
But          : creer des coord aleatoires qui sont des multiples de 10
Commentaires :
Pre-cond     :
Post-cond    : tab coord x y
---------------------------------------
*/
function coordAlea() {
  var x = Math.floor(((Math.random() * canvasSnake.width)/10))*10;
  var y = Math.floor(((Math.random() * canvasSnake.height)/10))*10;
  return [x,y];
}


/* -------------------------------------
Type         : Fonction
Nom          : creerCoordPomme
Auteur       : Jesse Dingley
Date         : 12 Mai
But          : creer les coord d'un Pomme à poser en verifiant que l'on peut le poser
Commentaires :
Pre-cond     :
Post-cond    : coord x y finales
---------------------------------------
*/
function creerCoordPomme() {

  // on propose des coord possibles
  coordPomme = coordAlea();

  // on verfie que les coord sont acceptables

  // verif snake
  var resSnake = false;
  for (var i = 0; i < snake.length; i++) {
    if (snake[i].x == coordPomme[0] && snake[i].y == coordPomme[1]) {
      resSnake = true;
    }
  }

  // verif Banane
  var resBanane = false;
  if (comptTimeout >= 201) {
    if (coordPomme[0] == coordBanane[0] && coordPomme[1] == coordBanane[1]) {
      resBanane = true;
    }
  }

  // verif Diamant
  var resDiamant = false;
  if (comptTimeout >= 501) {
    if (coordPomme[0] == coordDiamant[0] && coordPomme[1] == coordDiamant[1]) {
      resDiamant = true;
    }
  }

  // verif Bombe
  var resBombe = false;
  if (comptTimeout >= 101) {
    for (var i = 0; i < coordBombe.length; i++) {
      if (coordBombe[i].x == coordPomme[0] && coordBombe[i].y == coordPomme[1]) {
        resBombe = true;
      }
    }
  }


  if (resSnake || resBanane || resBombe || resDiamant) {
    creerCoordPomme();
  }
}



/* -------------------------------------
Type         : Fonction
Nom          : creerCoordBanane
Auteur       : Jesse Dingley
Date         :
But          : creer des coord pour une banane qui fait rétrecir le snake
Commentaires :
Pre-cond     :
Post-cond    : coord x y
---------------------------------------
*/
function creerCoordBanane() {

    var cdAlea = coordAlea();
    coordBanane = cdAlea;



    // on le valide
    // on verif si les coord ne superposent pas le snake
    var resSnake = false;
    for (var i = 0; i < snake.length; i++) {
      if (snake[i].x == coordBanane[0] && snake[i].y == coordBanane[1]) {
        resSnake = true;
      }
    }

    // on verif si les coord ne superposent pas la pomme
    // coordBombe[coordBombe.length - 1] car onne s'intéresse à la nouvelle bombe
    var resPomme = false;
    if (coordPomme[0] == coordBanane[0] && coordPomme[1] == coordBanane[1]) {
      resPomme = true;
    }

    // verif Diamant
    var resDiamant = false;
    if (comptTimeout >= 501) {
      if (coordBanane[0] == coordDiamant[0] && coordBanane[1] == coordDiamant[1]) {
        resDiamant = true;
      }
    }


    // on verif pour les bombes aussi
    var resBombe = false;
    if (comptTimeout >= 101) {
      for (var i = 0; i < coordBombe.length; i++) {
        if (coordBombe[i].x == coordBanane[0] && coordBombe[i].y == coordBanane[1]) {
          resBombe = true;
        }
      }
    }

    if (resSnake || resPomme || resBombe || resDiamant) {
      creerCoordBanane();
    }
}


/* -------------------------------------
Type         : Fonction
Nom          : creerCoordDiamant
Auteur       : Kilian Peytavy
Date         : 15 Mai
But          : creer les coord d'une diamant à poser en verifiant que l'on peut le poser
Commentaires :
Pre-cond     :
Post-cond    : coord x y finales
---------------------------------------
*/
function creerCoordDiamant() {
  // on ne pose un diamant que si le compteur du setTimeout est un multiple de cent
    // on propose des coord
     var crdAlea = coordAlea();
      coordDiamant = crdAlea;

    // on le valide
    // on verif si les coord ne superposent pas le snake
    var resSnake = false;
    for (var i = 0; i < snake.length; i++) {
      if (snake[i].x == coordDiamant[0] && snake[i].y == coordDiamant[1]) {
        resSnake = true;
      }
     }

    // on verif si les coord ne superposent pas la pomme
    var resPomme = false;
    if (coordPomme[0] == coordDiamant[0] && coordPomme[1] == coordDiamant[1]) {
      resPomme = true;
    }


    var resBombe = false;
    if (comptTimeout >= 101) {
      for (var i = 0; i < coordBombe.length; i++){
        if (coordBombe[i].x == coordDiamant[0] && coordBombe[i].y == coordDiamant[0]) {
          resBombe = true;
        }
      }
    }

    // verif Banane
    var resBanane = false;
    if (comptTimeout >= 201) {
      if (coordBanane[0] == coordDiamant[0] && coordBanane[1] == coordDiamant[1]) {
        resBanane = true;
      }
    }



    if (resSnake || resPomme || resBombe || resBanane) {
      creerCoordDiamant();
    }
}



/* -------------------------------------
Type         : Fonction
Nom          : creerCoordBombe
Auteur       : Jesse Dingley
Date         : 13 Mai
But          : creer les coord d'une Bombe à poser en verifiant que l'on peut le poser
Commentaires :
Pre-cond     :
Post-cond    : coord x y finales
---------------------------------------
*/
function creerCoordBombe() {

  // on ne pose une bombe que si le compteur du setTimeout est un multiple de cent
    // on propose des coord
    crdAlea = coordAlea();

    // on les rajoute au tableau coordBombe
    coordBombe.push({x:crdAlea[0],y:crdAlea[1]});

    // on le valide
    // on verif si les coord ne superposent pas le snake
    var resSnake = false;
    for (var i = 0; i < snake.length; i++) {
      if (snake[i].x == coordBombe[coordBombe.length - 1].x && snake[i].y == coordBombe[coordBombe.length - 1].y) {
        resSnake = true;
      }
    }

    // on verif si les coord ne superposent pas la pomme
    // coordBombe[coordBombe.length - 1] car onne s'intéresse à la nouvelle bombe
    var resPomme = false;
    if (coordPomme[0] == coordBombe[coordBombe.length - 1].x && coordPomme[1] == coordBombe[coordBombe.length - 1].y) {
      resPomme = true;
    }

    // verif Banane
    var resBanane = false;
    if (comptTimeout >= 201) {
      if (coordBanane[0] == coordBombe[coordBombe.length - 1].x && coordBanane[1] == coordBombe[coordBombe.length - 1].y) {
        resBanane = true;
      }
    }


    // verif Diamant
    var resDiamant = false;
    if (comptTimeout >= 501) {
      if (coordBombe[coordBombe.length - 1].x == coordDiamant[0] && coordBombe[coordBombe.length - 1].y == coordDiamant[1]) {
        resDiamant = true;
      }
    }

    if (resSnake || resPomme || resBanane || resDiamant) {
      coordBombe.pop();
      creerCoordBombe();

    }
}


/* -------------------------------------
Type         : Procedure
Nom          : dessinerPomme
Auteur       : Jesse Dingley
Date         : 12 Mai
But          : poser Une pomme
Commentaires :
Pre-cond     :
Post-cond    : 
---------------------------------------
*/
function dessinerPomme() {
  contexteCanvasSnake.drawImage(imagePomme,coordPomme[0],coordPomme[1],10,10);
}



/* -------------------------------------
Type         : Procedure
Nom          : dessinerBanane
Auteur       : Jesse Dingley
Date         : 15 Mai
But          : poser Une banane
Commentaires :
Pre-cond     :
Post-cond    :
---------------------------------------
*/
function dessinerBanane() {
  if (comptTimeout >= multipleDeDeuxCent) {
      contexteCanvasSnake.drawImage(imageBanane,coordBanane[0],coordBanane[1],10,10);
    }
}


/* -------------------------------------
Type         : Procedure
Nom          : dessinerDiamant
Auteur       : Kilian Peytavy
Date         : 15 Mai
But          : poser un diamant
Commentaires :
Pre-cond     :
Post-cond    :
---------------------------------------
*/
function dessinerDiamant() {
  if (comptTimeout >= multipleDeDiams) {
        contexteCanvasSnake.drawImage(imageDiamant,coordDiamant[0],coordDiamant[1],10,10);
     }
}


/* -------------------------------------
Type         : Fonction
Nom          : dessinerPomme
Auteur       : Jesse Dingley
Date         : 13 Mai
But          : poser Une bombe
Commentaires :
Pre-cond     :
Post-cond    : affichage
---------------------------------------
*/
function dessinerBombe() {
      if (comptTimeout >= multipleDeCent) {
        for (var i = 0; i < coordBombe.length; i++) {
          contexteCanvasSnake.drawImage(imageBombe,coordBombe[i].x,coordBombe[i].y,10,10);
        }
      }

}


/* -------------------------------------
Type         : Fonction
Nom          : casJeuPerdu
Auteur       : Jesse Dingley
Date         : 15 Mai
But          : tout initialiser après avoir perdu
Commentaires :
Pre-cond     : event
Post-cond    :
---------------------------------------
*/
function casJeuPerdu() {

  // on reinitialise tout
  creerCoordPomme();
  vitesseDeplacement = 60;
  comptTimeout = 0;
  coordBombe = [];

  snake = [
    {x:50, y:250}, // tete
    {x:40, y:250},
    {x:30, y:250}, // queue
  ];

  avanceX = 10;
  avanceY = 0;

  // on affiche le message de perte
  afficheMessageFinPartie();

	//on envoie le score
	envoie_score(score);

  // on redemarre le score
  score = 0;

  // on pose le bouton jouer
  document.getElementById('boutons').innerHTML = "<button type='button' name='boutonJouer' id='boutonJouer' onclick='jouerPartie()'>Rejouer</button>";

}


/* -------------------------------------
Type         : Fonction
Nom          : pause
Auteur       : Jesse Dingley
Date         : 29 Mai
But          : pause le jeu
Commentaires :
Pre-cond     : event
Post-cond    :
---------------------------------------
*/
function pause(event) {
  var toucheAppuye = event.keyCode;
  if (toucheAppuye==80) { // 'p'
     afficheMessageJeuEnPause();

     // on arrete tout
     clearTimeout(boucle);
     jeuEnPause = true;
  }
}



/* -------------------------------------
Type         : Fonction
Nom          : pause
Auteur       : Jesse Dingley
Date         : 29 Mai
But          : reprendre le jeu
Commentaires :
Pre-cond     : event
Post-cond    :
---------------------------------------
*/
function reprise(event) {
  // ssi on est en pause
  if (jeuEnPause) { 
  var toucheAppuye = event.keyCode;
    if (toucheAppuye==82) { // 'r'
    	//on ne peu pas appuyer sur 'r' si on est pas en pause
    	jeuEnPause=false;
       // on reprend le jeu
       boucle = setTimeout(function boucler() {
        // il faut pas qu'on puisse changer de direction dans le lapse de temps
        modifieDirectionSnakeClavier = false;

        comptTimeout++;
        initCanvasSnake();
        dessinerPomme();
        dessinerBanane();
        dessinerDiamant();
        dessinerBombe();
        deplaceSnake();
        dessineSnake();
        jouerPartie();
      }, vitesseDeplacement)
    }
  }
}



/* -------------------------------------
Type         : Procedure
Nom          : jouerPartie
Auteur       : Jesse Dingley
Date         : 8 Mai
But          : jouer une partie
Commentaires :
Pre-cond     :
Post-cond    :
---------------------------------------
*/
function jouerPartie() {

  arreteDefilementPageJeu();

  // le bouton "jouer" doit disparaitre dans quand on joue
  document.getElementById('boutons').innerHTML = "";

  // on regarde si le compteur du setTimeout est un multiple de 100
  // pour ensuite créer une nouvelle bombe
  if ((comptTimeout % 100) == 0 && comptTimeout >= 100) {
    multipleDeCent = comptTimeout;
    creerCoordBombe();
  }

  // pour les bananes
  if ((comptTimeout % 200) == 0 && comptTimeout >= 200) {
    multipleDeDeuxCent = comptTimeout;
    creerCoordBanane();
  }

  // on regarde si le compteur du setTimeout est un multiple de 500
  // pour ensuite créer un nouveau Diamant
  if ((comptTimeout % 500) == 0 && comptTimeout >= 500) {
    multipleDeDiams = comptTimeout;
    creerCoordDiamant();
  }

  // affichage score
  document.getElementById('score').innerHTML = "Score : "+score;

  // on verifie si le joueur a perdu
  if (perte()) {

    casJeuPerdu();

  } else {

    // on repete le déplacement du snake toutes les 60 ms
     boucle = setTimeout(function boucler() {
        // il faut pas qu'on puisse changer de direction dans le lapse de temps
        modifieDirectionSnakeClavier = false;

        comptTimeout++;
        initCanvasSnake();
        dessinerPomme();
        dessinerBanane();
        dessinerDiamant();
        dessinerBombe();
        deplaceSnake();
        dessineSnake();
        jouerPartie();
      }, vitesseDeplacement) // la vitesseDeplacement de déplacement

  }
}


// on y va
function initgame(){
creerCoordPomme();
initCanvasSnake();
dessinerPomme();
dessineSnake();
}

// Kilian Peytavy
function getXHR() {
 	var xhr = null;
 	if (window.XMLHttpRequest) // FF & autres
   	xhr = new XMLHttpRequest();
 	else if (window.ActiveXObject) { // Internet Explorer < 7
      try {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
     	}
 	} else { // Objet non supporté par le navigateur
   		alert("Votre navigateur ne supporte pas AJAX");
   		xhr = false;
 	}
	return xhr;
}


// Kilian Peytavy
function envoie_score(score) {
	var xhr = getXHR();
	// On définit que l'on va faire à chaque changement d'état
	xhr.onreadystatechange = function() {
	// On ne fait quelque chose que si on a tout reç̧u
	// et que le serveur est ok
		if (xhr.readyState == 4 && xhr.status == 200){
			// traitement ré́alisé avec la réponse...
		}
	}
	xhr.open("POST","score.php",true) ;
	xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded;charset=utf-8');
  xhr.send("score="+score);
}

