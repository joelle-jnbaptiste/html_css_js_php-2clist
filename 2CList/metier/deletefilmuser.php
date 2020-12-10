<?php
session_start();

$vs_idfilm=$_POST['id'];
$vs_iduser = $_SESSION['iduser'];
$vs_typeList = $_POST['list'];

testBdd();

//enleve retire un film de la liste du user connecte en fonction du type de liste selectionne
if ($vs_typeList === "vue")
{
    //supprime un film de la liste vue
    deletelistvue($vs_idfilm,$vs_iduser);
}
else if ($vs_typeList === "fav")
{
    //supprime un film de la liste favoris
    deletelistfav($vs_idfilm,$vs_iduser);
}
else if ($vs_typeList === "avoir")
{
    //supprime un film de la liste avoir
    deletelistavoir($vs_idfilm,$vs_iduser);
}

//renvoie Ajax
echo "supprimer";

//______________________________________________________________________________________________________________________
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
function deletelistvue($vs_idfilm,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('DELETE FROM vue WHERE iduser = :user AND idfilm = :idfilm  ');
    $reponse->execute(array('user' => $vs_iduser, 'idfilm' => $vs_idfilm));
    $reponse->closeCursor();
}

function deletelistfav($vs_idfilm,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('DELETE FROM favoris WHERE iduser = :user AND idfilm = :idfilm  ');
    $reponse->execute(array('user' => $vs_iduser, 'idfilm' => $vs_idfilm));
    $reponse->closeCursor();
}

function deletelistavoir($vs_idfilm,$vs_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('DELETE FROM avoir WHERE iduser = :user AND idfilm = :idfilm  ');
    $reponse->execute(array('user' => $vs_iduser, 'idfilm' => $vs_idfilm));
    $reponse->closeCursor();
}
 ?>
