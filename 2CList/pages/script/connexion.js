//GERE LES ACTIONS PROPRE AU FORMULAIRE DE CONNEXION
var globalCo = {
    validEmailCo : true,
    validMdpCo : true ,
};

//fonction lancee au demarrage de la page
$(document).ready(function()
{
    //lorsque l'on clique sur le bouton 'se connecter' on lance l'appel Ajax qui declenche la conexion
    $("#conne").click(function(e)
    {
        e.preventDefault();
        ajaxConn();
    });
});

//AJAX_____________________________________________________________________________________________________________________
function ajaxConn()
{
    //envoie l'user et le mdp entre par le user en ajax par la methode post
    $.post
    (
        './metier/connexion.php',
        {
            email : $("#email").val(),
            mdp : $("#mdp").val(),
        },
        function(data){
            //gere l'action qui suit selon la reponse recu de PHP
            onConnexion(data);
        },
        'json'
    );
}

//REPONSE_____________________________________________________________________________________________________________________
function onConnexion(data)
{
    globalCo.validEmailCo = true;
    globalCo.validMdpCo = true;

    var formInscrip = (data);

    //observe les donnees recues du PHP
    for(var i=0; i<formInscrip.length; i++)
    {
        //si le user est invalide
        if(formInscrip[i]==="invalidUser")
        {
            globalCo.validEmailCo = false;
            globalCo.validMdpCo = false;
        }
        //si le mdp est invalide
        if(formInscrip[i]==="invalidPassword")
        {
            globalCo.validMdpCo = false;
        }
        //si la connexion est etablie on charge la page profil.php
        if(formInscrip[i]==="validConnexion")
        {
            window.location.replace("profil.php");
        }
    }
    //modifie le formulaire pour avertir les erreurs de l'utilisateur
    setValidFormCo();
}

//_____________________________________________________________________________________________________________________________
function setValidFormCo()
{
    //on retire les informations d'erreurs precedantes
    $('#userinvalidco').remove();
    $('#mdpinvalidco').remove();


    $( "#email").removeClass( "is-valid is-invalid" ).addClass( "is-valid" );
    $( "#mdp" ).removeClass( "is-valid is-invalid" ).addClass( "is-valid" );

    //on affiche les erreurs en fonction des erreurs retrouvée

    //si le nom d'user fournit n'est pas valide
    if(globalCo.validEmailCo === false)
    {
        $( "#email" ).removeClass( "is-valid" ).addClass( "is-invalid" );
        $('#gpUserCo').append('<div class="invalid-feedback" id="userinvalidco">Nom d\'utilisateur invalide!</div>');
    }
    //si le mdp ne correspond pas
    if(globalCo.validMdpCo === false)
    {
        $( "#mdp" ).removeClass( "is-valid" ).addClass( "is-invalid" );

        $('#gpMdpCo').append('<div class="invalid-feedback" id="mdpinvalidco">Mot de passe incorrect</div>');
    }
}
