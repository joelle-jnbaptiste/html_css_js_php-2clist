<?php

$vo_reponseAjax="";

//test la connexion a la Bdd
testBdd();

//selectionne l'id d'un film de maniere aleatoire
getRandom($vo_reponseAjax);

//renvoie la reponse Ajax
echo $vo_reponseAjax;


//__________________________________________________________________________________________________________________

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

function getRandom(&$vo_reponseAjax)
{
    //recupère l'id d'un film choisit au hasard
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->query('SELECT SQL_NO_CACHE idfilm
                            FROM film
                            ORDER BY RAND( )
                            LIMIT 1 ');
    while($donnees = $reponse -> fetch() )
    {
        $vo_reponseAjax=$donnees['idfilm'];
    }
    $reponse->closeCursor();
}
?>
