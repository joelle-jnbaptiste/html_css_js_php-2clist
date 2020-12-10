//ETABLIE SI LE USER EST CONNECTE
var session = {
    session : [],
};

//fonction lancee au demarrage de la page
$(document).ready(function()
{
    //appel ajax qui verifie si les variables de session sont actives
     ajaxIsSessionSet();
});

//AJAX_______________________________________________________________________________________________________________
function ajaxIsSessionSet(id)
{
    //verifie si l'user est connecte a l'aide des variables de session
    $.post
    (
        './metier/issession.php',
        {    },
        function(data)
        {
            onConnexionSetSession(data);
        },
        'json'
    );
}

//REPONSE______________________________________________________________________________________________________________
function onConnexionSetSession(data)
{
    //stocke dans une variable globale l'etat de la session
    session.session = (data);
}
