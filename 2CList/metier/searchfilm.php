<?php
//RECUPERE LA LISTE DES FILMS SELON LES CONDITIONS ENVOYEES
session_start();

$vo_reponseAjax=array();

$vs_genre1=$_POST['genre1'];
$vs_genre2=$_POST['genre2'];
$vs_search = $_POST['search'];
$vs_tri=$_POST['tri'];

class Film
{
    public $id;
    public $titre;
    public $affiche;
    public $note;
    public $genres = [] ;
    public $date;
    public $resume;
    public $isEnfant;
}

//test la connexion a la BDD
testBdd();

//envoi la requete SQL correspondante au  genre et la recherche en cours et recupère une liste de film
$reponse = filtres($vs_genre1,$vs_genre2,$vs_search);

//stocke dans un tableau la reponse de la requete SQL precedante
recupFilms($reponse,$vo_reponseAjax);

$vo_reponseAjax2 =array();

//filtre les films en fonction de la page que consulte le user
filtrePage($vo_reponseAjax,$vo_reponseAjax2);

//effectue un tri sur film en fonction de la selection du user
triUser($vo_reponseAjax2,$vs_tri);

//renvoie Ajax
$json = json_encode( $vo_reponseAjax2);
echo($json) ;

//___________________________________________________________________________________________________________________
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

function selectFilmGenre2($vs_genre2)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, affiche,resume,date,isEnfant FROM film
                                INNER JOIN genrefilm ON genrefilm.idfilm = film.idfilm
                                WHERE genrefilm.idgenre = :genre;');
    $reponse->execute(array('genre' => $vs_genre2));
    return $reponse;
}
function selectFilmGenre1($vs_genre1)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, affiche,resume,date,isEnfant FROM film
                                INNER JOIN genrefilm ON genrefilm.idfilm = film.idfilm
                                WHERE genrefilm.idgenre = :genre;');
    $reponse->execute(array('genre' => $vs_genre1));
    return $reponse;
}
function selectFilmGenres($vs_genre1,$vs_genre2)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  SELECT film.idfilm,titre, affiche,resume,date,isEnfant FROM film
                                INNER JOIN genrefilm AS genre1 ON genre1.idfilm = film.idfilm
                                INNER JOIN genrefilm AS genre2 ON genre2.idfilm = film.idfilm
                                WHERE genre1.idgenre = :genre1 AND genre2.idgenre = :genre2;');
    $reponse->execute(array('genre1' => $vs_genre1, 'genre2' => $vs_genre2));
    return $reponse;
}
function research($vs_search)
{
    //retourne les infos des films ayant un titre, un real ou un acteur proche de la recherche
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $vs_like = '%'.trim($vs_search).'%';
    $reponse = $bdd->prepare('  SELECT DISTINCT film.idfilm,titre, affiche,resume,date,isEnfant FROM film
                                INNER JOIN acteurfilm  ON acteurfilm.idfilm = film.idfilm
                                INNER JOIN acteur  ON acteur.idacteur = acteurfilm.idacteur
                                INNER JOIN realfilm  ON realfilm.idfilm = film.idfilm
                                INNER JOIN realisateur  ON realisateur.idreal= realfilm.idreal

                                WHERE film.titre LIKE :like
                                OR prenomreal LIKE :like
                                OR nomreal LIKE :like
                                OR nomacteur LIKE :like
                                OR prenomacteur LIKE :like');
    $reponse->execute(array('like' => $vs_like));
    return $reponse;
}
function infoFilms($donnees,&$object)
{

    $object -> id = $donnees['idfilm'] ;
    $object -> titre = $donnees['titre'] ;
    $object -> affiche = $donnees['affiche'] ;
    $object -> resume = $donnees['resume'] ;
    $object -> date = $donnees['date'] ;
    $object -> isEnfant = $donnees['isEnfant'] ;
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

function pageNew($tabEnvoi,$vo_reponseAjax,&$vo_reponseAjax2)
{
    //stocke dans un  nouveau tableau les films ayant une date de sortie inferieure a trois mois
    $tabEnvoi=array_filter($vo_reponseAjax,function($a)
    {
        $dateAComp = date("Y-m-d", strtotime("-3 month"));
        return $dateAComp < $a->date;
    });
    foreach($tabEnvoi as $key => $value)
    {
        array_push($vo_reponseAjax2,$value);
    }
}
function pageKid($tabEnvoi,$vo_reponseAjax,&$vo_reponseAjax2)
{
    //stocke dans un nouveau tableau les films adaptés pour les enfants
    $tabEnvoi=array_filter($vo_reponseAjax,function($a)
    {
        return  $a->isEnfant;
    });
    foreach($tabEnvoi as $key => $value)
    {
        array_push($vo_reponseAjax2,$value);
    }
}
function pageNote($tabEnvoi,$vo_reponseAjax,&$vo_reponseAjax2)
{
    //stocke dans un nouveua tableau les films dont les notes sont superieure ou egale a 4
    $tabEnvoi=array_filter($vo_reponseAjax,function($a)
    {
        return  $a->note>=4;
    });
    foreach($tabEnvoi as $key => $value)
    {
        array_push($vo_reponseAjax2,$value);
    }
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
function filtres($vs_genre1,$vs_genre2,$vs_search)
{
    //recupere les films correspondant au genre 2 si il est selectionne
    if($vs_genre1 === "" && $vs_genre2 !== "")
    {
        $reponse=selectFilmGenre2($vs_genre2);
    }
    //recupere les films correspondant au genre 1 si il est selectionne
    else if($vs_genre1 !== "" && $vs_genre2 === "")
    {
        $reponse=selectFilmGenre1($vs_genre1);
    }
    //recupere les films correspondant au genre 1 et du genre2
    else if($vs_genre1 !== "" && $vs_genre2 !== "")
    {
        $reponse=selectFilmGenres($vs_genre1,$vs_genre2);
    }
    //si aucun genre n'est selectionne verifie si une expression est recherchee
    else if(trim($vs_search) !== "")
    {
        $reponse=research($vs_search);
    }
    //renvoie les infos de tous les films
    else
    {
        $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
        $reponse = $bdd->query('SELECT film.idfilm,titre, affiche,resume,date,isEnfant FROM film;');
    }
    return $reponse;
}


?>
