<?php
//recupère les genres pour alimenter les filtres par genre
$vo_reponseAjax=array();
class Genre
{
    public $id;
    public $genre;
}

//teste la connexion a la base de donnee
testBdd();

//recupere les genres de film et leur ID dans la BDD
getGenre($vo_reponseAjax);

//reponse Ajax
$json = json_encode( $vo_reponseAjax);
echo($json) ;

//_____________________________________________________________________________________________

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

function getGenre(&$vo_reponseAjax)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->query('SELECT nomgenre,idgenre FROM genre ORDER BY nomgenre;');
    while($donnees = $reponse -> fetch() )
    {
        $idgenre = $donnees['idgenre'];
        ${"genre".$idgenre} = new Genre;
        ${"genre".$idgenre} -> id = $donnees['idgenre'] ;
        ${"genre".$idgenre} -> genre = $donnees['nomgenre'] ;
        array_push($vo_reponseAjax, ${"genre".$idgenre});
    }
}
 ?>
