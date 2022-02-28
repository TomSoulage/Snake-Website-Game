//div de la liste de message
var messagesElt = document.getElementById("chatlogs");

//appelle la fonction de callback toutes les x secondes
setInterval(function(){
    
    //charge le fichier passer en premier argument
    //response est le contenu du fichier
    ajaxGet("chat_message.php", function(response){
        console.log(response);
      
        let html = "";
        
        //parcours des messages
       
            html += response ;
    
        
        messagesElt.innerHTML = html;

    })
    
}, 5000); //en milliseconde donc ici, toutes les 5 secondes



