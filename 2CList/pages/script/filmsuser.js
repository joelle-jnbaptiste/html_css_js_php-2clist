//charge les films sur la page de l'user et gere les differends traitements

var globalFilm = {
    films : [],
    genre : [],
    username : "",
};

var globalDelete = {
    id : "",
    list : "",
    titre :"",
};

//fonction lancee au demarrage de la page
$(document).ready(function()
{
    //indice qui permet de gerer les informations affichees sous les boutons listes
    globalListe.indice = 1;

    //recupere le nom de l'user
    ajaxGetNameUser();

    //charge les films sur la page
    ajaxConnexionOnloadFilm();

    //charge les genres dans le select
    ajaxConnexionOnloadGenre();

    //recharge la page quand on effectue une action de tri
    $("#selectTri").change(function(e)
    {
        ajaxConnexionOnloadFilm();
    });

    //recharge la page quand on change le genre
    $("#selectGenre1").change(function(e)
    {
        ajaxConnexionOnloadFilm();
    });

    //recharge la page quand on change le genre
    $("#selectGenre2").change(function(e)
    {
        ajaxConnexionOnloadFilm();
    });

    //charge la liste de film correspondante a la liste choist par l'user
    $(".liste").click(function(e)
    {
        //on desactive le bouton precedemment actif
        $(".btn-liste-selected").removeClass('btn-liste-selected');

        //si l'element clique est un bouton on le selectionne
        if($( this ).hasClass("btn-liste")=== true)
        {
            $( this ).addClass("btn-liste-selected ");
        }
        //sinon on remonte dans ses parents pour chercher le bouton et le selectionne
        else
        {
            $( this ).parentsUntil('button').addClass("btn-liste-selected ");
        }
        //on recharge la page avec les nouvelles infos
        ajaxConnexionOnloadFilm();
    });

    //supprime un film de la liste active
    $('#delete').click(function(e)
    {
        ajaxSupprElem();
    });
});

//AJAX_______________________________________________________________________________________________________________________

function ajaxGetNameUser()
{
    //recupere le nom de l'user via la variable de session et l'affiche dans la page html
    $.post
    (
        './metier/getNameUser.php',
        {

        },
        function(data){
            globalFilm.username = data;
            setUserName();
        },
        'text'
    );
}

function ajaxSupprElem()
{
    //supprime un film selon la liste actuellement selectionnee
    $.post
    (
        './metier/deletefilmuser.php',
        {
            id : globalDelete.id,
            list : globalDelete.list,
        },
        function(data)
        {
            //fait disparaitre la fenetre de validation
            $('#exampleModalCenter').modal('hide');
            //recharge les films
            ajaxConnexionOnloadFilm();
        },
        'text'
    );
}
function ajaxConnexionOnloadFilm()
{
    //recupere les films, les stockes dans une variable gloable et les affiches dans la page html
    $.post
    (
        './metier/searchfilmuser.php',
        {
            tri : $("#selectTri").val(),
            genre1 : $("#selectGenre1").val(),
            genre2 : $("#selectGenre2").val(),
            list : $(".btn-liste-selected").attr('name'),
        },
        function(data)
        {
            onConnexionFilms(data);
        },
        'json'
    );
}

function ajaxConnexionOnloadGenre()
{
    //recupere les genres et les charges dans les selects
    $.post
    (
        './metier/searchgenre.php',
        {},
        function(data){
            onConnexionGenre(data);
        },
        'json'
    );
}

//REPONSES______________________________________________________________________________________________________________
function setUserName()
{
    //affiche le nom recupere dans la page html
    $("#setName").html("Bienvenue "+globalFilm.username+" !");
}

function onConnexionFilms(data)
{
    //stocke dans une variable globale les films recuperes
    var tabdata= [];
    globalFilm.films = [];
    for(var i=0; i<data.length; i++)
    {
        globalFilm.films = (data);
    }
    //charge dans la page html les infos recuperes
    page();
}

function onConnexionGenre(data)
{
    //charge dans une variable globale les genres recuperes
    var tabdata= [];
    for(var i=0; i<data.length; i++)
    {
        globalFilm.genre = (data);
    }

    //remplace dans la page html les informations dans les selects
    selectGenre();
}

//____________________________________________________________________________________________________________________________________________
function page()
{
    //vide le corps du tableau
    $("#film").replaceWith("<tbody id='film'></tbody>");

    //pour chaque film present dans la liste on charge une rangee dans le tableau
    for (var i= 0 ; i< (globalFilm.films).length; i++)
    {
        var buttons = button(i);
        var genres = genre(i);
        var date = dates(i);
        var note = notes(i);
        $("#film").append("<tr><td class='text-center'>"+buttons+"</td><td >"+globalFilm.films[i].titre+"</td><td class='text-center d-none d-sm-none d-md-table-cell'>"+genres+"</td><td class='text-center d-none d-sm-none d-md-table-cell'>"+date+"</td><td class='text-center d-none d-sm-none d-md-table-cell'>"+note+"</td></tr>");
    }
}

function notes(i)
{
    var note = "";
    //si la note est nulle on l'affiche sous forme de -
    if (globalFilm.films[i].note === null)
    {
        note = "- /5";
    }
    else
    {
        //sinon on enleve des decimales a la note
        if((globalFilm.films[i].note).length>4)
        {
            globalFilm.films[i].note = (globalFilm.films[i].note).substring(0,3);
            if(globalFilm.films[i].note[2]===0)
            {
                globalFilm.films[i].note=(globalFilm.films[i].note).substring(0);
            }
        }
        note = globalFilm.films[i].note+"/5";
    }

    return note;
}

function dates(i)
{
    //stocke la date dans un nouveau format
    var date = "";
    var tabdate = (globalFilm.films[i].date).split("-");
    date = tabdate[1] + " / " + tabdate[0];

    return date;
}

function button(i)
{
    //genere des boutons pour chaque film en fonction de la liste active
    var list=$(".btn-liste-selected").attr('name');
    var btn = "";

    if(list === "vue")
    {
        btn = "<button class='m-0 btn btn-liste btn-avoir btn-sm'type='button' onclick='liste();' tooltip-position='bottom' tooltip1='A voir' name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-avoir'></span></button>";
        btn += "<button class='m-0 btn btn-liste btn-fav btn-sm'type='button' onclick='liste();' tooltip-position='bottom' tooltip1='Favoris' name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-fav'></span></button>";
    }
    else if(list === "avoir")
    {
        btn = "<button class='m-0 btn btn-liste btn-vue btn-sm'type='button' onclick='liste();' tooltip-position='bottom' tooltip1='Vue' name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-vue'></span></button>";
        btn += "<button class='m-0 btn btn-liste btn-fav btn-sm'type='button' onclick='liste();' tooltip-position='bottom' tooltip1='Favoris' name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-fav'></span></button>";
    }
    else if(list === "fav")
    {
        btn = "<button class='m-0 btn btn-liste btn-avoir btn-sm'type='button' onclick='liste();' tooltip-position='bottom' tooltip1='A voir' name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-avoir'></span></button>";
        btn += "<button class='m-0 btn btn-liste btn-vue btn-sm'type='button' onclick='liste();' tooltip-position='bottom' tooltip1='Vue' name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-vue'></span></button>";
    }

    btn += "<button  onclick='suprList(this);'class='m-0 btn btn-liste supr btn-sm'type='button' tooltip-position='bottom' tooltip1='Supprimer' name='"+globalFilm.films[i].id+"'><span name='"+globalFilm.films[i].id+"' class='icon-supr supr'></span></button>";
    return btn;
}


function suprList(event)
{
    //recupere l'id du film selectionne et la liste active
    globalDelete.id = $(event).attr('name');
    globalDelete.list = $(".btn-liste-selected").attr('name');

    var titre = "";

    //recupere le titre du film
    for (var i=0; i<(globalFilm.films).length;i++)
    {
        if(globalFilm.films[i].id == globalDelete.id)
        {
            globalDelete.titre = globalFilm.films[i].titre;
        }
    }

    //genere le nom de la liste active
    var list=$(".btn-liste-selected").attr('name');
    if(list === "vue")
    {
        list = "vue";
    }
    else if(list === "avoir")
    {
        list = "à voir";
    }
    else if(list === "fav")
    {
        list = "favoris";
    }

    //affiche un texte personnalise selon le film et la liste en cours, lorsque l'user souhaite supprimer
    var text = "Êtes vous sur de vouloir supprimer le film <br> <h3><strong>"+globalDelete.titre+"</strong></h3> <br> de votre liste de films <strong>"+list+"</strong> ?"
    $("#modalText").html(text);
    $('#exampleModalCenter').modal('show');
}


function genre(i)
{
    //a partir d'un tableau contenant les genres d'un film, genere un str qui sera place dans l'html
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
    //charge les genres dans les selects
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
