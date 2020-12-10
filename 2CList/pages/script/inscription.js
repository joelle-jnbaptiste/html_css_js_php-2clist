//GERE LES ACTIONS QUI SUIVENT LA TENTATIVE D INSCRIPTION D UN USER
var global = {
    validEmail : true,
    validMdp : true ,
    validMdpLength : true,
};

//fonction lancee au demarrage de la page
$(document).ready(function()
{
    //lorsque l'on clique sur le bouton 'inscription' une requete ajax se declenche pour verifier les informations
    $("#inscription").click(function(e)
    {
        e.preventDefault();
        ajaxInscription();
    });
});

//AJAX______________________________________________________________________________________________________________________
function ajaxInscription()
{
    //envoie les donnees necessaires a l'inscription et effectue un traitement en fonction du retour
    $.post
    (
        './metier/inscription.php',
        {
            email2 : $("#email2").val(),
            mdp2 : $("#mdp2").val(),
            verifmdp : $("#verifmdp").val(),
        },
        function(data)
        {
            onInscription(data);
        },
        'json'
    );
}//REPONSE_______________________________________________________________________________________________________________
function onInscription(data)
{
    //stocke dans une variable globale les informations qui permettront de modifier le formulaire ou de charger la page user
    global.validEmail = true;
    global.validMdp = true;
    global.validMdpLength = true;


    var formInscrip = (data);
    //si l'inscription n'est pas valide on reste sur la page et on observe les elements qui seront sujettes a changer
    for(var i=0; i<formInscrip.length; i++)
    {

        if(formInscrip[i]==="invalidEmail")
        {
            global.validEmail = false;
        }

        if(formInscrip[i]==="invalidPassword")
        {
            global.validMdp = false;
        }

        if(formInscrip[i]==="invalidPasswordLength")
        {
            global.validMdpLength = false;
        }

        //si l'inscription est valide on charge la page du profil
        if(formInscrip[i]==="validInscription")
        {
            window.location.replace("profil.php");
        }
    }

    //modifie le formulaire selon les cas de figures reperer precedemment
    setValidForm();
}

//____________________________________________________________________________________________________________________________

function setValidForm()
{
    // remet le formulaire a son etat de base
    $('#userinvalid').remove();
    $('#mdpinvalid').remove();
    $('#mdpinvalidLength').remove();


    $( "#email2" ).removeClass( "is-valid is-invalid" ).addClass( "is-valid" );
    $( "#mdp2" ).removeClass( "is-valid is-invalid" ).addClass( "is-valid" );
    $( "#verifmdp" ).removeClass( "is-valid is-invalid" ).addClass( "is-valid" );

    //si l'email n'est pas valide on notifie l'user
    if(global.validEmail === false)
    {
        $( "#email2" ).removeClass( "is-valid" ).addClass( "is-invalid" );
        $('#gpUser').append('<div class="invalid-feedback" id="userinvalid">Ce nom d\'utilisateur existe déjà !</div>');


    }
    //si les mdps ne correspondent pas entre eux
    if(global.validMdp === false)
    {
        $( "#mdp2" ).removeClass( "is-valid" ).addClass( "is-invalid" );
        $( "#verifmdp" ).removeClass( "is-valid" ).addClass( "is-invalid" );

        $('#gpMdp').append('<div class="invalid-feedback" id="mdpinvalid">Vos mot de passe ne correspondent pas !</div>');
    }
    //si le mdp n'a pas une bonne longueur
    if(global.validMdpLength === false)
    {
        $( "#mdp2" ).removeClass( "is-valid" ).addClass( "is-invalid" );
        $( "#verifmdp" ).removeClass( "is-valid" ).addClass( "is-invalid" );
        $('#gpMdp').append('<div class="invalid-feedback" id="mdpinvalidLength">Votre mot de passe doit avoir au moins 8 caractères !</div>');
    }
}
