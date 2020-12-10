//CHARGE LA PAGE DETAILLE D UN FILM CHOISIT DE MANIERE ALEATOIRE
//fonction lancee au demarrage de la page
$(document).ready(function()
{
    //Ajax qui va charger un film aleatoirement
    $("#random").click( function()
    {
        ajaxRandom();
    });
});
//AJAX______________________________________________________________________________________________________________
function ajaxRandom()
{
    //appel ajax qui va recuperer l'id d'un film au hasard
    $.post
    (
        './metier/filmrandom.php',
        {
        },
        function(data){
            onRandomFilm(data);
        },
        'text'
    );
}

//REPONSE________________________________________________________________________________________________________________
function onRandomFilm(data)
{
    //cree un url pour affiche rles details du film choisit au hasard
    var url = "detail.php?id="+data;
    window.location.replace(url);

}
