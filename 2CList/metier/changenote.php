<?php

//CHANGE LA NOT D UN FILM DONNEE PAR UN USER
session_start();
$vo_reponseAjax=array();
$vn_idfilm=$_POST['id'];
$vn_note=$_POST['note'];


//si le user est connecte
if(!empty($_SESSION['iduser']))
{
    $vn_iduser = $_SESSION['iduser'];

    //test si la connexion a la BDD est établie
    testBdd();
    $tab="";
    $tab2="";

    //verifie si le user a vue le film
    testIfVue($tab2,$vn_idfilm,$vn_iduser);
    if($tab2)
    {
        //verifie si le user a deja note le film
        testIfNote($tab,$vn_idfilm,$vn_iduser);

        //si le tableau est rempli, le film est deja note, on update la note
        if($tab)
        {
            updateNote($vn_idfilm,$vn_iduser,$vn_note);
        }
        //si le film n'est pas note on ajoute la note et le user
        else
        {
            addNote($vn_idfilm,$vn_iduser,$vn_note);
        }
        array_push($vo_reponseAjax, "updateNote");
        echo json_encode($vo_reponseAjax);
    }
    else
    {
        array_push($vo_reponseAjax, "avertUser");
        echo json_encode($vo_reponseAjax);
    }
}
//si le user n'est pas connecte on le previent
else
{
    array_push($vo_reponseAjax, "avertUser");
    echo json_encode($vo_reponseAjax);
}

//_______________________________________________________________________________________________________________
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

function testIfNote(&$tab,$vn_idfilm,$vn_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('SELECT note FROM note WHERE idfilm = :idfilm AND iduser = :iduser');
    $reponse->execute(array('idfilm' => $vn_idfilm,'iduser'=> $vn_iduser));

    while($donnees = $reponse -> fetch() )
    {
        $tab =  $donnees['note'];
    }
    $reponse->closeCursor();
}

function testIfVue(&$tab2,$vn_idfilm,$vn_iduser)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('SELECT iduser FROM vue WHERE idfilm = :idfilm AND iduser = :iduser');
    $reponse->execute(array('idfilm' => $vn_idfilm,'iduser'=> $vn_iduser));

    while($donnees = $reponse -> fetch() )
    {
        $tab2 =  $donnees['iduser'];
    }
    $reponse->closeCursor();
}

function updateNote($vn_idfilm,$vn_iduser,$vn_note)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  UPDATE note
                                SET note.note = :note
                                WHERE idfilm = :idfilm AND iduser = :iduser');
    $reponse->execute(array('idfilm' => $vn_idfilm,'iduser'=> $vn_iduser, 'note'=> $vn_note));
}

function addNote($vn_idfilm,$vn_iduser,$vn_note)
{
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('  INSERT INTO note(idfilm,iduser,note)
                                VALUES (:idfilm,:iduser,:note)');
    $reponse->execute(array('idfilm' => $vn_idfilm,'iduser'=> $vn_iduser, 'note'=> $vn_note));
}
?>
