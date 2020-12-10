//AFFICHE UN FILM RECUPERER GRACE A UN APPEL AJAX

var globalDetail = {
    films : [],
    id :"",
}

//fonction lancee au demarrage de la page
$(document).ready(function()
{
    //indice qui permet de gerer les informations affichees sous les boutons listes
    globalListe.indice = "2";

    //on recupere dans l'url à l'aid ede get l'id du film que l'on devra afficher
    globalDetail.id = $_GET('id'),

    //appel Ajax qui va chercher les informations du film
    ajaxConnexionOnloadFilm();

    //execute la fonction qui va modifier la note lorsque l'on appuie sur le bouton de la fleche du haut
    $("#upArrow").click(function(e)
    {
        e.preventDefault();
        //change la note
        changeNoteUp();
    });

    //execute la fonction qui va modifier la note lorsque l'on appuie sur le bouton de la fleche du haut
    $("#downArrow").click(function(e)
    {
        e.preventDefault();
        //change la note
        changeNoteDown();
    });
});

//AJAX____________________________________________________________________________________________________________
function ajaxConnexionOnloadFilm()
{
    //appel Ajax qui va recupèrer par methode get l'id du film pour charger les infos du films correspondant
    $.get
    (
        './metier/detailfilm.php',
        {
            id : globalDetail.id,
        },
        function(data){
            //fonction qui va stocker les datas dans une variable globale
            onConnexionDetail(data);
        },
        'json'
    );
}
function ajaxChangeNote(note)
{
    //envoie la nouvelle note entrée par l'user au PHP pour modifier la BDD
    $.post
    (
        './metier/changenote.php',
        {
            id : globalDetail.films.id,
            note : note,
        },
        function(data){
            //action qui suit le retour Ajax
            onChangeNote(data);
        },
        'json'
    );
}

//REPONSE_________________________________________________________________________________________________________
function onChangeNote(data)
{
    var changeNote = (data);
    //si la note a ete modifier on recharge les donnees de la page
    for(var i=0; i<changeNote.length; i++)
    {
        if(changeNote[i]==="updateNote")
        {
            ajaxConnexionOnloadFilm();
        }
    }
}
function onConnexionDetail(data)
{
    //stocke les informations recuperer par ajax dans une variable globale
    globalDetail.films = (data);

    //si l'id n'existe pas dans la bdd on affiche un message d'erreur
    if(globalDetail.films.id === null)
    {
        $("#film").html('<div class="row justify-content-center mt-5 mb-5"><div class="col-10 text-center"><h2>Désolé !</h2><h4>Aucune résultat ne semble correspondre à votre recherche ...</h4></div></div>');
    }
    else
    {
        //va utiliser les informations de la variable globale precedante pour charger les infos
        pageDetail();
    }
}
//________________________________________________________________________________________________________________________________
function changeNoteUp()
{
    //lorsque l'on clique sur la fleche du haut, on recupere la note dans la page html
    var note = parseFloat($("#noteuserset").html(),10);

    // on verifie qu'elle n'est pas superieure a 5
    if(note<5)
    {
        //si c'est inferieur a 5 on l'augmante de 0.5
        note = note+0.5;
        //on lance l'appel Ajax pour voir si la note de l'user doit etre modifier si il est connecte
        ajaxChangeNote(note);
    }
}

function changeNoteDown()
{
    //lorsque l'on clique sur la fleche du bas, on recupere la note dans la page html
    var note = parseFloat($("#noteuserset").html(),10);

    // on verifie qu'elle est superieure a 0
    if(note>0)
    {
        //on lui retire 0.5
        note = note-0.5;
        //on lance l'appel Ajax pour voir si la note de l'user doit etre modifier si il est connecte
        ajaxChangeNote(note);
    }
}

function setButton()
{
    //charge les boutons des listes en haut de la page
    $("#btn-row").html("<button onclick='liste();' tooltip2='A voir' tooltip-position='bottom' id='btn-avoir' type='button' name='"+globalDetail.films.id+"' class='ml-lg-5 mr-lg-5 ml-md-3 mr-md-3 mr-5 ml-5 mb-4 mt-4 btn col-lg-2 col-md-3 col-5  btn-liste btn-avoir '><span name='"+globalDetail.films.id+"' class='btn-lg-profil icon-avoir float-left'></span><span name='"+globalDetail.films.id+"' class=' btn-lg-profil float-right avoir'>+  A VOIR</span></button><button onclick='liste();' tooltip2='Favoris' tooltip-position='bottom' id='btn-favoris' type='button' name='"+globalDetail.films.id+"' class='btn-fav ml-lg-5 mr-lg-5  ml-md-3 mr-md-3 mr-5 ml-5 mb-4 mt-4 btn col-lg-2 col-md-3 col-5  btn-liste   '><span name='"+globalDetail.films.id+"' class='btn-lg-profil icon-fav float-left'></span><span name='"+globalDetail.films.id+"'class=' btn-lg-profil float-right favoris'>+  FAVORIS</span></button><button onclick='liste();' tooltip2='Vue' tooltip-position='bottom' id='btn-vue' type='button' name='"+globalDetail.films.id+"' class='btn-vue ml-lg-5 mr-lg-5  ml-md-3 mr-md-3 mr-5 ml-5 mb-4 mt-4 btn col-lg-2 col-md-3 col-5  btn-liste   ''><span name='"+globalDetail.films.id+"'class='btn-lg-profil icon-vue float-left'></span><span name='"+globalDetail.films.id+"' class=' btn-lg-profil float-right vue'>+  VUE</span></button>")
}

function pageDetail()
{
    //charge les infos du film dans la page

    //variable recuperer à l'aide de fonctions
    var genre = genres();
    var note = notes();
    var date = dates();
    var acteur= acteurs();
    var real = reals();

    $("#titre").html(globalDetail.films.titre);
    $("#genre").html(genre);
    $("#date").html(date);

    //creer les boutons de liste sur la page
    setButton();

    $("#imgdetail").html("<img src='./images/Affiche/"+globalDetail.films.affiche+"' class='img-thumbnail img-film'alt='Affiche "+globalDetail.films.titre+"'>");
    $("#real").html(real);
    $("#acteur").html(acteur);
    $("#resume").html(globalDetail.films.resume);
    $("#noteAttrib").html(note);

    //permet d'afficher la note user et la note globale du film
    setNoteUser();
    setGlobalNote()
}

function setGlobalNote()
{
    //si la note moyenne est nulle on affiche la note en grisé
    if (globalDetail.films.note === null)
    {
        $("#globalNote").html("- /5");
        $("#globalNote").css("color","Gainsboro");
        $("#avis").css("color","Gainsboro");
    }
    else
    {
        //sinon on retire les decimales et on l'affiche en noir
        if((globalDetail.films.note).length>4)
        {
            globalDetail.films.note = (globalDetail.films.note).substring(0,3);
            if(globalDetail.films.note[2]===0)
            {
                globalDetail.films.note=(globalDetail.films.note).substring(0);
            }
        }
        $("#globalNote").html(globalDetail.films.note+"/5");
        $("#avis").css("color","black");
    }
    $("#avis").html(globalDetail.films.nbavis+" Avis");
}

function notes()
{
    //represente la note sous forme de cercle
    var html = "";

    //si la note est inexistante les cercles seront grisés
    if(globalDetail.films.note === null )
    {
        for (var j= 0; j<5; j++)
        {
            html = html + "<i class='fas fa-circle note transparent' style='color: Gainsboro;' ></i>"
        }
    }
    //sinon on affiche les cercles en arrondissant la note a l'entier le plus proche
    else
    {
        var note= Math.round(globalDetail.films.note);
        var conte = 0;
        for (var j= 0; j<note; j++)
        {
            html = html + "<i class='fas fa-circle note'></i>"
            conte++;
        }
        for(var j=conte; j<5; j++)
        {
            html = html + "<i class='far fa-circle note'></i>"

        }
    }
    return html;
}


function genres()
{
    //recupere les genres depuis un tableau et les tranformes en str
    var genre = "";
    for(var j = 0; j<(globalDetail.films.genres).length; j++)
    {
        genre = genre + globalDetail.films.genres[j] +" / "
    }
    genre = genre.substr(0, genre.length - 2);
    return genre;
}


function acteurs()
{
    //genere une liste a partir des acteurs recupere
    var acteur = "";
    for(var j = 0; j<(globalDetail.films.acteur).length; j++)
    {
        acteur = acteur+ "<li>" + globalDetail.films.acteur[j] +"</li> "
    }

    return acteur;
}

function reals()
{
    //genere une liste a partir des reals recupere
    var real = "";
    for(var j = 0; j<(globalDetail.films.real).length; j++)
    {
        real = real+ "<li>" + globalDetail.films.real[j] +"</li> "
    }

    return real;
}

function dates()
{
    //change le format de la date recupere
    var date = "";
    var tabdate = (globalDetail.films.date).split("-");
    date = tabdate[1] + " / " + tabdate[0];

    return date;
}

function $_GET(param)
{
    //recupere dans l'url le parametre pour simuler la methode get
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace(
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value )
        { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param )
    {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}

function setNoteUser()
{
    //si la note de l'user est inexistante ou que l'user n'est pas connecte, on l'affiche ne gris
    if(session.session.issession === false)
    {
        $("#noteuser").css("color","Gainsboro");
    }
    else if(globalDetail.films.noteuser === null)
    {
        $("#noteuserset").css("color","Gainsboro");
    }
    //sinon on affiche la note en noir
    else
    {
        $("#noteuserset").css("color","black");
        $("#noteuserset").html(globalDetail.films.noteuser);
    }
}
