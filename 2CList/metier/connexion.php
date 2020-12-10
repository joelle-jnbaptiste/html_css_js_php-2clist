<?php
//DECIDE DE L ACTION QUI SUIT UNE TENTATIVE DE CONNEXION
session_start();

$vb_user=trim($_POST['email']);
$vs_mdp=$_POST['mdp'];
$vb_isUser = false;
$vb_isMdp = false;
$vo_reponseAjax=array();

testBdd();

//verifie si l'user existe
$vb_isUser = verifUser($vb_user,$vo_reponseAjax);

//si l'user existe verifie si pour cet user le mdp est correct
if($vb_isUser === true)
{
    $vb_isMdp = verifMdp($vs_mdp,$vb_user,$vo_reponseAjax);
}

//si le mdp et le user correspondent on valide la connexion
if($vb_isUser && $vb_isMdp)
{
    connectUser($vb_user);
    array_push($vo_reponseAjax, "validConnexion");
}

echo json_encode($vo_reponseAjax);

//_________________________________________________________________________________________________________________
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

function connectUser($vb_user)
{
    //recupère l'id de l'user pour le stocker dans une variable de session
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('SELECT iduser FROM user WHERE nomuser=:user ');
    $reponse->execute(array('user' => $vb_user));

    while($donnees = $reponse -> fetch() )
    {
        $_SESSION['iduser']=$donnees['iduser'];
    }
    $reponse->closeCursor();

    //stocke le nom de l'user dans une variable de session
    $_SESSION['user'] = $vb_user;
}

function verifUser($vb_user,&$vo_reponseAjax)
{
    $vb_isUserTable = false;
    //test si l'user est present dans la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->query('SELECT nomuser FROM user');
    while($donnees = $reponse -> fetch() )
    {
        if($donnees['nomuser'] === $vb_user)
        {
            $vb_isUserTable = true;
            break;
        }
    }

    //si on le retrouve dans la BDD on renvoie True
    if ($vb_isUserTable === true)
    {
        return true;
    }
    //sinon on renvoie que l'user est invalide
    else
    {
        array_push($vo_reponseAjax, "invalidUser");
        return false;
    }

}

function verifMdp($vs_mdp,$vb_user,&$vo_reponseAjax)
{
    $vb_ismdpTable = false;
    //verifie si pour l'user donné, le mdp correspond a celui dans la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('SELECT password FROM user WHERE nomuser=:user ');
    $reponse->execute(array('user' => $vb_user));

    while($donnees = $reponse -> fetch() )
    {
        if (password_verify($vs_mdp, $donnees['password']))
        {
            $vb_ismdpTable = true;
            break;
        }
    }

    //si le mdp est correct on revoie vrai
    if($vb_ismdpTable === true)
    {
        return true;
    }
    //sinon on notifie l'user que le mdp est invalide
    else
    {
        array_push($vo_reponseAjax, "invalidPassword");
        return false;
    }
}

?>
