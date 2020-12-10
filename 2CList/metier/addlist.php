<?php

//SI UN USER ET CONNECTE AJOUTE LE FILM DANS LA LISTE DESIGNEE

session_start();

$vo_reponseAjax="";
$vs_typeList=trim($_POST['liste']);
$vn_idFilm=$_POST['idfilm'];

//verifie si le user est connecté
if(!empty($_SESSION['iduser']))
{
    $vn_idUser = $_SESSION['iduser'];

    //test si la connexion a la BDD est établie
    testBdd();

    //si le user a choisi la liste a voir, on ajoute le film
    if($vs_typeList === "avoir")
    {
        addListAvoir($vo_reponseAjax,$vn_idFilm,$vn_idUser);
    }
    //si le user a choisi la liste favoris, on ajoute le film
    else if($vs_typeList === "favoris")
    {
        addListFavoris($vo_reponseAjax,$vn_idFilm,$vn_idUser);

    }
    //si le user a choisi la liste vue, on ajoute le film
    else if($vs_typeList === "vue")
    {
        addListVue($vo_reponseAjax,$vn_idFilm,$vn_idUser);
    }
}
//si l'user n'est pas connecte on le previent
else
{
    $vo_reponseAjax= "NotConnected";
}

//renvoie Ajax
echo $vo_reponseAjax;

//____________________________________________________________________


function addListAvoir(&$vo_reponseAjax,$vn_idFilm,$vn_idUser)
{
    $tab="";
    //vérifie si le film n'est pas deja present dans la liste
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('SELECT idfilm FROM avoir WHERE idfilm = :idfilm AND iduser = :iduser');
    $reponse->execute(array('idfilm' => $vn_idFilm,'iduser'=> $vn_idUser, ));

    while($donnees = $reponse -> fetch() )
    {
        $tab =  $donnees['idfilm'];
    }
    $reponse->closeCursor();

    //si le film n'est pas présent on l'ajoute
    if(!$tab)
    {
        $reponse = $bdd->prepare('INSERT INTO avoir (idfilm,iduser)
        VALUES (:idfilm,:iduser)');
        $reponse->execute(array('idfilm' => $vn_idFilm,'iduser'=> $vn_idUser));
        $reponse->closeCursor(); // Termine le traitement de la requête
        $vo_reponseAjax= "updateList";
    }
    //sinon on avertie l'user qu'il est deja present
    else
    {
        $vo_reponseAjax="AlreadyPresent";
    }
}


function addListFavoris(&$vo_reponseAjax,$vn_idFilm,$vn_idUser)
{
            $tab="";
            //vérifie si le film n'est pas deja present dans la liste
            $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
            $reponse = $bdd->prepare('SELECT idfilm FROM favoris WHERE idfilm = :idfilm AND iduser = :iduser');
            $reponse->execute(array('idfilm' => $vn_idFilm,'iduser'=> $vn_idUser, ));
            while($donnees = $reponse -> fetch() )
            {
                $tab =  $donnees['idfilm'];
            }
            $reponse->closeCursor();

            //si le film n'est pas présent on l'ajoute
            if(!$tab)
            {
                $reponse = $bdd->prepare('INSERT INTO favoris (idfilm,iduser)
                VALUES (:idfilm,:iduser)');
                $reponse->execute(array('idfilm' => $vn_idFilm,'iduser'=> $vn_idUser));
                $reponse->closeCursor();
                $vo_reponseAjax= "updateList";
            }
            //sinon on avertie l'user qu'il est deja present
            else
            {
                $vo_reponseAjax="AlreadyPresent";
            }
}

function addListVue(&$vo_reponseAjax,$vn_idFilm,$vn_idUser)
{
    $tab="";
    //vérifie si le film n'est pas deja present dans la liste
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('SELECT idfilm FROM vue WHERE idfilm = :idfilm AND iduser = :iduser');
    $reponse->execute(array('idfilm' => $vn_idFilm,'iduser'=> $vn_idUser, ));
    while($donnees = $reponse -> fetch() )
    {
        $tab =  $donnees['idfilm'];
    }
    $reponse->closeCursor();

    //si le film n'est pas présent on l'ajoute
    if(!$tab)
    {
        $reponse = $bdd->prepare('INSERT INTO vue (idfilm,iduser)
        VALUES (:idfilm,:iduser)');
        $reponse->execute(array('idfilm' => $vn_idFilm,'iduser'=> $vn_idUser));
        $reponse->closeCursor();
        $vo_reponseAjax= "updateList";
    }
    //sinon on avertie l'user qu'il est deja present
    else
    {
        $vo_reponseAjax="AlreadyPresent";
    }
}


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
?>
