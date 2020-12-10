var globalFilm = {
    films : [],
    genre : [],
};

//fonction lancee au demarrage de la page
$(document).ready(function()
{
    //indice qui permet de gerer les informations affichees sous les boutons listes
    globalListe.indice = "1";

    //Ajax qui charge les films sur la page
    ajaxConnexionOnloadFilm();

    //ajax qui charge les genres dans le menu select
    ajaxConnexionOnloadGenre();

    //Ajax qui va charger les films en fonction du tri effectuer
    $("#selectTri").change(function(e)
    {
        ajaxConnexionOnloadFilm();
    });

    //Ajax qui va charger les films en fonction du genre choisit
    $("#selectGenre1").change(function(e)
    {
        ajaxConnexionOnloadFilm();
    });

    //Ajax qui va charger les films en fonction du genre choisit
    $("#selectGenre2").change(function(e)
    {
        ajaxConnexionOnloadFilm();
    });

    //Ajax qui va charger les films en fonction de la recherche
    $("#search").on('input', function()
    {
        ajaxSearch();
    });
});

//AJAX______________________________________________________________________________________________________________
function ajaxSearch()
{
    //appel ajax qui va recuperer les films en fonction de la recherche et trier les resultats selon le tri selectionne
    $.post
    (
        './metier/searchfilm.php',
        {
            tri : $("#selectTri").val(),
            genre1 : "",
            genre2 : "",
            search : $("#search").val(),

        },
        function(data){
            onConnexionFilms(data);
        },
        'json'
    );
}

function ajaxConnexionOnloadFilm()
{
    //recupere les infos des films en fonction du tri et des genres selectionne
    $.post
    (
        './metier/searchfilm.php',
        {
            tri : $("#selectTri").val(),
            genre1 : $("#selectGenre1").val(),
            genre2 : $("#selectGenre2").val(),
            search : "",

        },
        function(data){
            console.log(data);
            onConnexionFilms(data);
        },
        'json'
    );
}

function ajaxConnexionOnloadGenre()
{
    //recupere et charge les genres dans les selects
    $.post
    (
        './metier/searchgenre.php',
        {},
        function(data)
        {
            //charge les genres dans les selects
            onConnexionGenre(data);
        },
        'json'
    );
}
//REPONSE______________________________________________________________________________________________________________
function onConnexionFilms(data)
{
    var tabdata= [];
    globalFilm.films = [];

    //stocke data dans une variable globale
    for(var i=0; i<data.length; i++)
    {
        globalFilm.films = (data);
    }

    //vide le corps html
    $("#film").replaceWith("<div id = 'film'></div>");

    //si il n'y a pas de film dans la variable globale, on affiche un message d'erreur
    if((globalFilm.films).length === 0)
    {
        $("#film").append('<div class="row justify-content-center mt-5 mb-5"><div class="col-10 text-center"><h2>Désolé !</h2><h4>Aucune résultat ne semble correspondre à votre recherche ...</h4></div></div>');
    }
    //sinon on affiche les donnees a l'aide d'une fonction
    else
    {
        page();
    }
}

function onConnexionGenre(data)
{
    var tabdata= [];
    for(var i=0; i<data.length; i++)
    {
        globalFilm.genre = (data);
    }
    selectGenre();
}

//____________________________________________________________________________________________________________________

function page()
{
    //charge les donnees dans la page html
    var row = 3;
    var rowCount = 0;

    for (var i= 0 ; i< (globalFilm.films).length; i++)
    {
        var genre = genres(i);
        var note = notes(i);

        // tous les 3 films on cree une rangee = row
        if(row === 3)
        {
            rowCount++;
            var rowFilm = $("#film").append('<div class="row justify-content-center" id="rowfilm'+rowCount+'"></div>');
            row = 0;
        }

        row ++;

        var rowName = "rowfilm" +rowCount;

        //on genere les films
        var colFilm = $("#" + rowName).append("<div class='col-md-4 pt-3 pb-3 mb-0 mt-0 mb-md-4 mt-md-4   col-12  justify-content-center text-center film'><a href='detail.php?id="+globalFilm.films[i].id+"'  class='link-unstyled' ><div class='row'><div class='col-4 col-md-12 align-self-center pr-0 pl-1'><img src='./images/Affiche/"+globalFilm.films[i].affiche+"' class='img-thumbnail img-film'alt=''></div><div class='col-8 col-md-12 align-self-center'><h3 class='titre-film text-uppercase mt-2 mb-0'>"+globalFilm.films[i].titre+"</h3><div class='' >"+note+"</div><p class='fnt-2 mb-0'><small>"+genre+"</small></p><div class='col-12 mt-3'><button class='btn btn-liste btn-sm btn-avoir m-0' tooltip1='A voir' tooltip-position='bottom' onclick='liste();'  name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-avoir'></span></button><button onclick='liste();' class='btn btn-liste btn-sm btn-fav m-0' tooltip1='Favoris' tooltip-position='bottom'  name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-fav'></span></button><button onclick='liste();' class='btn btn-liste btn-sm btn-vue m-0' tooltip1='Vue' tooltip-position='bottom'  name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-vue'></span></button></div></div></div></a>");
    }
}


function genres(i)
{
    //recupere les genres depuis le tableau pour en faire un seul et meme str
    var genre = "";
    for(var j = 0; j<(globalFilm.films[i].genres).length; j++)
    {
        genre = genre + globalFilm.films[i].genres[j] +" / "
    }
    genre = genre.substr(0, genre.length - 2);

    return genre;
}

function  selectGenre()
{
    //charge les genres pour les mettre dans un select
    for(var j = 0; j<2; j++)
    {
        var select = "selectGenre" + (j+1);
        for (var i = 0; i<(globalFilm.genre).length; i++)
        {
            var genre = globalFilm.genre[i].genre;
            var value = globalFilm.genre[i].id;
            $("#" + select).append("<option value='"+value+"'>"+genre+"</option>");
        }
    }
}

function notes(i)
{
    var html = "";
    //affiche les notes sous formes de series de cercle

    //si la note est nulle, les cercles seront grises
    if(globalFilm.films[i].note === null )
    {
        for (var j= 0; j<5; j++)
        {
            html = html + "<i class='fas fa-circle note transparent' style='color: Gainsboro;'></i>"
        }
    }
    else
    {
        var note= Math.round(globalFilm.films[i].note);
        var conte = 0;
        //on affiche en cercle plein le nombre de cercle = a l'arrondit de la note
        for (var j= 0; j<note; j++)
        {
            html = html + "<i class='fas fa-circle note'></i>"
            conte++;
        }
        //les autres cercles sont vides
        for(var j=conte; j<5; j++)
        {
            html = html + "<i class='far fa-circle note'></i>"
        }
    }
    return html;
}
