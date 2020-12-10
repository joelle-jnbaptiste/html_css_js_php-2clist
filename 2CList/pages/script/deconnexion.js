//EFFECTUE L'ACTION QUI SUIT LA DECONNEXION D'UN USER

//fonction lancee au demarrage de la page
$(document).ready(function()
{
//execute la fonction Ajax lorsque l'utilisateur clique sur le bouton deconnexion
    $("#deco").click(function(e)
    {
        e.preventDefault();
        ajaxDeconnexion();
    });
});

//AJAX________________________________________________________________________________________________________________
function ajaxDeconnexion()
{
    //communique avec php pour lui dire de vider les variables de session si l'user choisit de se deconnecter
    $.post
    (
        './metier/deconnexion.php',
        {
        },
        function(data)
        {
            //effectue cette fonction apres le retour Ajax
            onDeconnexion(data);
        },
        'json'
    );
}

//REPONSE___________________________________________________________________________________________________________
function onDeconnexion(data)
{
    //si data indique deconnexion, on charge la page qui indique a l'user qu'il est bien deconnecte
    if(data==="deconnexion")
    {
        window.location.replace("deconnected.php");
    }
}
