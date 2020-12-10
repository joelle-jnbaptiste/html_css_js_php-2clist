<?php
//RENVOI LES DONNEES CONCERNANT LE FILM SELECTIONNE
session_start();

$vo_reponseAjax=array();
$vs_id=$_GET['id'];

class Film
{
    public $id;
    public $titre;
    public $affiche;
    public $note;
    public $noteuser;
    public $genres = [] ;
    public $real = [] ;
    public $acteur = [] ;
    public $date;
    public $resume;
    public $nbavis;
}

testBdd();

//créé un objet Film
$detailFilm = new Film;

//recupère les informations principales du film
infoFilm($detailFilm,$vs_id);

//recupere les genres
getGenre($detailFilm->titre,$detailFilm);

//recupere la moyenne des notes et le nombre de personne qui a vote
getAvis($detailFilm->titre,$detailFilm);

//recupere le nom des realisateurs
getReal($detailFilm->titre,$detailFilm);

//recupere le nom des acteurs
getActeur($detailFilm->titre,$detailFilm);

//recupere la note donne par l'utilisateur si il est connecte
getNoteUser($vs_id,$detailFilm);

$json = json_encode( $detailFilm);
echo($json) ;

//___________________________________________________________________________________________________________________________
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

function getGenre($titre, &$detailFilm)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse2 = $bdd->prepare(' SELECT nomgenre FROM genre
                                INNER JOIN genrefilm ON genrefilm.idgenre = genre.idgenre
                                INNER JOIN film ON genrefilm.idfilm = film.idfilm
                                WHERE film.titre = :titre ;');
    $reponse2->execute(array('titre' => $titre));
    while($donnees2 = $reponse2 -> fetch() )
    {
        array_push($detailFilm -> genres, $donnees2['nomgenre']) ;
    }
    $reponse2->closeCursor();
}

function getAvis($titre, &$detailFilm)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse3 = $bdd->prepare(' SELECT AVG(note) as noteavg, COUNT(note) as avis FROM note
                                INNER JOIN film ON film.idfilm = note.idfilm
                                WHERE titre = :titre ;');
    $reponse3->execute(array('titre' => $titre));
    while($donnees3 = $reponse3 -> fetch() )
    {
        $detailFilm -> note = $donnees3['noteavg'] ;
        $detailFilm -> nbavis = $donnees3['avis'] ;
    }
    $reponse3->closeCursor();
}

function getReal($titre, &$detailFilm)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse4 = $bdd->prepare(' SELECT nomreal, prenomreal FROM realisateur
                                INNER JOIN  realfilm ON realfilm.idreal = realisateur.idreal
                                INNER JOIN film ON realfilm.idfilm = film.idfilm
                                WHERE film.titre = :titre ;');
    $reponse4->execute(array('titre' => $titre));
    while($donnees4 = $reponse4 -> fetch() )
    {
        array_push($detailFilm -> real, $donnees4['prenomreal']." ".$donnees4['nomreal'] );
    }
    $reponse4->closeCursor();
}

function getActeur($titre, &$detailFilm)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse5 = $bdd->prepare('SELECT nomacteur, prenomacteur FROM acteur
        INNER JOIN acteurfilm ON acteurfilm.idacteur = acteur.idacteur
        INNER JOIN film ON acteurfilm.idfilm = film.idfilm
        WHERE film.titre = :titre ;');
        $reponse5->execute(array('titre' => $titre));
        while($donnees5 = $reponse5 -> fetch() )
        {
            array_push($detailFilm -> acteur, $donnees5['prenomacteur']." ".$donnees5['nomacteur']);
        }
        $reponse5->closeCursor();
}

function getNoteUser($idfilm, &$detailFilm)
{
    //si le user est connete on recupere la note qu'il a donne pour ce film, si celle ci est donne
    if(!empty($_SESSION['iduser']))
    {
        $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
        $reponse5 = $bdd->prepare(" SELECT note.note FROM note
                                    WHERE note.idfilm = :idfilm AND note.iduser = :iduser ;");
        $reponse5->execute(array('idfilm' => $idfilm,'iduser' => $_SESSION['iduser'] ));
        while($donnees5 = $reponse5 -> fetch() )
        {
            $detailFilm-> noteuser = $donnees5['note'];
        }
        $reponse5->closeCursor();
    }
    //si le user n'est pas connecte, la note sera null
    else
    {
        $detailFilm-> noteuser =  null;
    }
}

function infoFilm(&$detailFilm,$vs_id)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('SELECT film.idfilm,titre, affiche,resume,date,isEnfant FROM film WHERE film.idfilm = :id;');
    $reponse->execute(array('id' => $vs_id));

    while($donnees = $reponse -> fetch() )
    {
        $idfilm = $donnees['idfilm'];
        $detailFilm -> id = $donnees['idfilm'] ;
        $detailFilm -> titre = $donnees['titre'] ;
        $detailFilm -> affiche = $donnees['affiche'] ;
        $detailFilm -> resume = $donnees['resume'] ;
        $detailFilm -> date = $donnees['date'] ;
    }
}

?>
