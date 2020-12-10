<?php


session_start();

$vo_reponseAjax=array();
$vs_genre1=$_POST['genre1'];
$vs_genre2=$_POST['genre2'];
$vs_iduser = $_SESSION['iduser'];
$vs_typeList = $_POST['list'];
$vs_tri=$_POST['tri'];

class Film
{
    public $id;
    public $titre;
    public $note;
    public $genres = [] ;
    public $date;

}
testBdd();

//si le user est connecte on cherche les films en fonction de la liste en chois
if(!empty($_SESSION['iduser']))
{
    if ($vs_typeList === "vue")
    {
        listvue($vo_reponseAjax,$vs_genre1,$vs_genre2,$vs_iduser);
    }
    else if ($vs_typeList === "fav")
    {
        listfav($vo_reponseAjax,$vs_genre1,$vs_genre2,$vs_iduser);
    }
    else if ($vs_typeList === "avoir")
    {
        listavoir($vo_reponseAjax,$vs_genre1,$vs_genre2,$vs_iduser);
    }
    //effectue un tri sur film en fonction de la selection du user
    triUser($vo_reponseAjax,$vs_tri);
}


//reponse ajax
$json = json_encode( $vo_reponseAjax);
echo($json) ;

//_____________________________________________________________________________________________________________________
function testBdd()
{
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }
}
function filtresAvoir($vs_genre1,$vs_genre2,$vs_iduser)
{
    if($vs_genre1 === "" && $vs_genre2 !== "")
    {
        $reponse = selectFilmGenre2Avoir($vs_genre2,$vs_iduser);

    }
    else if($vs_genre1 !== "" && $vs_genre2 === "")
    {
        $reponse = selectFilmGenre1Avoir($vs_genre1,$vs_iduser);
    }
    else if($vs_genre1 !== "" && $vs_genre2 !== "")
    {
        $reponse = selectFilmGenresAvoir($vs_genre1,$vs_genre1,$vs_iduser);
    }
    else
    {
        $reponse = selectFilmAvoir($vs_iduser);
    }
        return $reponse;
}
function selectFilmGenre2Avoir($vs_genre2,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, date FROM film
                                INNER JOIN genrefilm ON genrefilm.idfilm = film.idfilm
                                INNER JOIN avoir ON avoir.idfilm = film.idfilm
                                WHERE genrefilm.idgenre = :genre AND avoir.iduser = :iduser;');
    $reponse->execute(array('genre' => $vs_genre2 ,'iduser' => $vs_iduser));
    return $reponse;
}
function selectFilmGenre1Avoir($vs_genre2,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre,date FROM film
                                INNER JOIN genrefilm ON genrefilm.idfilm = film.idfilm
                                INNER JOIN avoir ON avoir.idfilm = film.idfilm
                                WHERE genrefilm.idgenre = :genre AND avoir.iduser = :iduser;');
    $reponse->execute(array('genre' => $vs_genre1 ,'iduser' => $vs_iduser));
    return $reponse;
}
function selectFilmGenresAvoir($vs_genre1,$vs_genre1,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, date FROM film
                                INNER JOIN genrefilm AS genre1 ON genre1.idfilm = film.idfilm
                                INNER JOIN genrefilm AS genre2 ON genre2.idfilm = film.idfilm
                                INNER JOIN avoir ON avoir.idfilm = film.idfilm
                                WHERE genre1.idgenre = :genre1 AND genre2.idgenre = :genre2 AND avoir.iduser = :iduser;');
    $reponse->execute(array('genre1' => $vs_genre1, 'genre2' => $vs_genre2,'iduser' => $vs_iduser));
    return $reponse;
}
function selectFilmAvoir($vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre,date FROM film
                                INNER JOIN avoir ON avoir.idfilm = film.idfilm WHERE avoir.iduser = :iduser ;');
    $reponse->execute(array('iduser' => $vs_iduser));
    return $reponse;
}

function filtresVue($vs_genre1,$vs_genre2,$vs_iduser)
{
    if($vs_genre1 === "" && $vs_genre2 !== "")
    {
        $reponse = selectFilmGenre2Vue($vs_genre2,$vs_iduser);

    }
    else if($vs_genre1 !== "" && $vs_genre2 === "")
    {
        $reponse = selectFilmGenre1Vue($vs_genre1,$vs_iduser);
    }
    else if($vs_genre1 !== "" && $vs_genre2 !== "")
    {
        $reponse = selectFilmGenresVue($vs_genre1,$vs_genre1,$vs_iduser);
    }
    else
    {
        $reponse = selectFilmVue($vs_iduser);
    }
        return $reponse;
}
function selectFilmGenre2Vue($vs_genre2,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre,date FROM film
                                INNER JOIN genrefilm ON genrefilm.idfilm = film.idfilm
                                INNER JOIN vue ON vue.idfilm = film.idfilm
                                WHERE genrefilm.idgenre = :genre AND vue.iduser = :iduser;');
    $reponse->execute(array('genre' => $vs_genre2 ,'iduser' => $vs_iduser));
    return $reponse;
}
function selectFilmGenre1Vue($vs_genre2,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre,date FROM film
                                INNER JOIN genrefilm ON genrefilm.idfilm = film.idfilm
                                INNER JOIN vue ON vue.idfilm = film.idfilm
                                WHERE genrefilm.idgenre = :genre AND vue.iduser = :iduser;');
    $reponse->execute(array('genre' => $vs_genre1 ,'iduser' => $vs_iduser));
    return $reponse;
}

function selectFilmGenresVue($vs_genre1,$vs_genre1,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, date FROM film
                                INNER JOIN genrefilm AS genre1 ON genre1.idfilm = film.idfilm
                                INNER JOIN genrefilm AS genre2 ON genre2.idfilm = film.idfilm
                                INNER JOIN vue ON vue.idfilm = film.idfilm
                                WHERE genre1.idgenre = :genre1 AND genre2.idgenre = :genre2 AND vue.iduser = :iduser;');
    $reponse->execute(array('genre1' => $vs_genre1, 'genre2' => $vs_genre2,'iduser' => $vs_iduser));
    return $reponse;
}
function selectFilmVue($vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre,date FROM film
                                INNER JOIN vue ON vue.idfilm = film.idfilm WHERE vue.iduser = :iduser ;');
    $reponse->execute(array('iduser' => $vs_iduser));
    return $reponse;
}

function filtresFavoris($vs_genre1,$vs_genre2,$vs_iduser)
{
    if($vs_genre1 === "" && $vs_genre2 !== "")
    {
        $reponse = selectFilmGenre2Favoris($vs_genre2,$vs_iduser);

    }
    else if($vs_genre1 !== "" && $vs_genre2 === "")
    {
        $reponse = selectFilmGenre1Favoris($vs_genre1,$vs_iduser);
    }
    else if($vs_genre1 !== "" && $vs_genre2 !== "")
    {
        $reponse = selectFilmGenresFavoris($vs_genre1,$vs_genre1,$vs_iduser);
    }
    else
    {
        $reponse = selectFilmFavoris($vs_iduser);
    }
        return $reponse;
}
function selectFilmGenre2Favoris($vs_genre2,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, date FROM film
                                INNER JOIN genrefilm ON genrefilm.idfilm = film.idfilm
                                INNER JOIN favoris ON favoris.idfilm = film.idfilm
                                WHERE genrefilm.idgenre = :genre AND favoris.iduser = :iduser;');
    $reponse->execute(array('genre' => $vs_genre2 ,'iduser' => $vs_iduser));
    return $reponse;
}
function selectFilmGenre1Favoris($vs_genre2,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, date FROM film
                                INNER JOIN genrefilm ON genrefilm.idfilm = film.idfilm
                                INNER JOIN favoris ON favoris.idfilm = film.idfilm
                                WHERE genrefilm.idgenre = :genre AND favoris.iduser = :iduser;');
    $reponse->execute(array('genre' => $vs_genre1 ,'iduser' => $vs_iduser));
    return $reponse;
}

function selectFilmGenresFavoris($vs_genre1,$vs_genre1,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, date FROM film
                                INNER JOIN genrefilm AS genre1 ON genre1.idfilm = film.idfilm
                                INNER JOIN genrefilm AS genre2 ON genre2.idfilm = film.idfilm
                                INNER JOIN favoris ON favoris.idfilm = film.idfilm
                                WHERE genre1.idgenre = :genre1 AND genre2.idgenre = :genre2 AND favoris.iduser = :iduser;');
    $reponse->execute(array('genre1' => $vs_genre1, 'genre2' => $vs_genre2,'iduser' => $vs_iduser));
    return $reponse;
}
function selectFilmFavoris($vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre,date FROM film
                                INNER JOIN favoris ON favoris.idfilm = film.idfilm WHERE favoris.iduser = :iduser ;');
    $reponse->execute(array('iduser' => $vs_iduser));
    return $reponse;
}

function recupFilms($reponse,&$vo_reponseAjax)
{
    while($donnees = $reponse -> fetch() )
    {
        $idfilm = $donnees['idfilm'];
        ${"film".$idfilm} = new Film;

        //recupere les infos principales des films
        infoFilms($donnees,${"film".$idfilm});

        //chercher les genres d'un film dans un tableau
        getGenre($donnees,${"film".$idfilm});

        $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
        //recupere la note moyenne d'un film
        getAvgNote($donnees,${"film".$idfilm});

        array_push($vo_reponseAjax, ${"film".$idfilm});
    }
}
function infoFilms($donnees,&$object)
{

    $object -> id = $donnees['idfilm'] ;
    $object -> titre = $donnees['titre'] ;
    $object -> date = $donnees['date'] ;
}

function getGenre($donnees,&$object)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse2 = $bdd->prepare(' SELECT nomgenre FROM genre
                                INNER JOIN genrefilm ON genrefilm.idgenre = genre.idgenre
                                INNER JOIN film ON genrefilm.idfilm = film.idfilm
                                WHERE film.titre = :titre ;');
    $reponse2->execute(array('titre' => $donnees['titre']));
    while($donnees2 = $reponse2 -> fetch() )
    {
        array_push($object -> genres, $donnees2['nomgenre']);
    }
    $reponse2->closeCursor();
}

function getAvgNote($donnees,&$object)
{
    //recupere les notes d'un et en fin la moyenne
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse3 = $bdd->prepare(' SELECT AVG(note) as noteavg FROM note
                                INNER JOIN film ON film.idfilm = note.idfilm
                                WHERE titre = :titre ;');
    $reponse3->execute(array('titre' => $donnees['titre']));
    while($donnees3 = $reponse3 -> fetch() )
    {
        $object -> note = $donnees3['noteavg'] ;
    }
    $reponse3->closeCursor();
}
function filtrePage($vo_reponseAjax,&$vo_reponseAjax2)
{
    $tabEnvoi = array();

    //si l'user est sur la page des nouveautes, seul les films recent apparaitront
    if($_SESSION["page"] === "new")
    {
        pageNew($tabEnvoi,$vo_reponseAjax,$vo_reponseAjax2);
    }
    //si l'user est sur la page enfant, seul les films etant adapte apparaitront
    else if($_SESSION["page"] === "kid")
    {
        pageKid($tabEnvoi,$vo_reponseAjax,$vo_reponseAjax2);
    }
    //si l'user est sur la page les mieux notes, seuls les films ayant une moyenne supeurieure ou egale a 4 apparaitront
    else if($_SESSION["page"] === "note")
    {
        pageNote($tabEnvoi,$vo_reponseAjax,$vo_reponseAjax2);
    }
    //sinon aucun traitement ne sera fait
    else
    {
        $vo_reponseAjax2 = $vo_reponseAjax;
    }
}


function triUser(&$vo_reponseAjax2,$vs_tri)
{
    //1 = ancien au plus recent
    if($vs_tri === "1")
    {
        dateCroissant($vo_reponseAjax2);
    }
    //2 = par ordre alphabetique
    else if($vs_tri === "2")
    {
        ordreAlpha($vo_reponseAjax2);
    }
    //3 = selon les notes
    else if($vs_tri === "3")
    {
        bestNote($vo_reponseAjax2);
    }
    //4 = du plus recent au plus ancien
    else if($vs_tri === "4")
    {
        dateDecroissant($vo_reponseAjax2);
    }
}
function listvue(&$vo_reponseAjax,$vs_genre1,$vs_genre2,$vs_iduser)
{
    $reponse = filtresVue($vs_genre1,$vs_genre2,$vs_iduser);

    //stocke dans un tableau la reponse de la requete SQL precedante
    recupFilms($reponse,$vo_reponseAjax);
}

function listfav(&$vo_reponseAjax,$vs_genre1,$vs_genre2,$vs_iduser)
{
    $reponse = filtresFavoris($vs_genre1,$vs_genre2,$vs_iduser);

    //stocke dans un tableau la reponse de la requete SQL precedante
    recupFilms($reponse,$vo_reponseAjax);
}
function listavoir(&$vo_reponseAjax,$vs_genre1,$vs_genre2,$vs_iduser)
{
    $reponse = filtresAvoir($vs_genre1,$vs_genre2,$vs_iduser);

    //stocke dans un tableau la reponse de la requete SQL precedante
    recupFilms($reponse,$vo_reponseAjax);
}
function dateCroissant(&$vo_reponseAjax2)
{
    //tri des films par des plus ancien au plus recent
    function comparer($a, $b)
    {
        return strcmp($a->date, $b->date);
    }
    usort($vo_reponseAjax2, 'comparer');
}
function ordreAlpha(&$vo_reponseAjax2)
{
    //tri des films par ordre alphaetique de leur titre
    function comparer($a, $b)
    {
        return strcmp($a->titre, $b->titre);
    }
    usort($vo_reponseAjax2, 'comparer');
}
function bestNote(&$vo_reponseAjax2)
{
    //tri des films par ordre decroissant des notes
    function comparer($a, $b)
    {
        return strcmp($b->note,$a->note);
    }
    usort($vo_reponseAjax2, 'comparer');
}
function dateDecroissant(&$vo_reponseAjax2)
{
    //tri des films du plus recent au plus ancien
    function comparer($a, $b)
    {
        return strcmp($b->date,$a->date);
    }
    usort($vo_reponseAjax2, 'comparer');
}

?>
