<?php
//INSCRIT UN USER DANS LA BDD SI CELUI CI REMPLIT LES CONDITIONS

session_start();

$vs_user=trim($_POST['email2']);
$vs_mdp=$_POST['mdp2'];
$vs_verifMdp=$_POST['verifmdp'];
$vb_isUser = false;
$vb_isMdp = false;
$vo_reponseAjax=array();

testBdd();


//verifie que le nom user est valide ou n'est pas deja present dans la BDD
$vb_isUser = verifUser($vs_user,$vo_reponseAjax);

//verifie si le mdp remplit les conditions
$vb_isMdp = verifMdp($vs_mdp,$vs_verifMdp,$vo_reponseAjax);

//si l'user et le mdp sont valides, on inscrit l'user
if($vb_isUser && $vb_isMdp)
{
    addInscription($vs_user,$vs_mdp,$vo_reponseAjax);
}

//renvoie Axaj
echo json_encode($vo_reponseAjax);

//______________________________________________________________________________________________________________
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

function verifUser($vs_user,&$vo_reponseAjax)
{
    $vb_isUserTable = false;

    //verifie l'user est deja present dans la BDD
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->query('SELECT nomuser FROM user');
    while($donnees = $reponse -> fetch() )
    {
        if($donnees['nomuser'] === $vs_user)
        {
            $vb_isUserTable = true;
            break;
        }
    }

    //si l'user est deja present ou qu'il est vide, on revoie qu'il est invalide
    if ($vb_isUserTable === true || $vs_user === "")
    {
        array_push($vo_reponseAjax, "invalidEmail");
        return false;
    }

    //sinon il est valide
    else
    {
        return true;
    }
}

function verifMdp($vs_mdp,$vs_verifMdp,&$vo_reponseAjax)
{
    //verifie si le mdp est superieur a 8 caractere
    if(strlen($vs_mdp)>= 8)
    {
        //si le premier mdp entre correspond a celui entre en confirmation renvoie vrai
        if($vs_mdp === $vs_verifMdp)
        {
            return true;
        }
        //si ils ne correspondent pas on notifie l'user
        else
        {
            array_push($vo_reponseAjax, "invalidPassword");
            return false;
        }
    }
    else
    {
        //verifie si le premier mdp entre correspond a celui entre en confirmation
        if($vs_mdp !== $vs_verifMdp)
        {
            array_push($vo_reponseAjax, "invalidPassword");
        }
        //notifie que la longueur du mdp n'est pas valide
        array_push($vo_reponseAjax, "invalidPasswordLength");
        return false;
    }
}







function addInscription($vs_user,$vs_mdp,&$vo_reponseAjax)
{
    $vs_mdp = password_hash($vs_mdp, PASSWORD_DEFAULT);
    //insere dans la BDD le nouvel user et son mdp
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('INSERT INTO user(nomuser,password) VALUES (:nom,:mdp);');
    $reponse->execute(array('nom' => $vs_user, 'mdp' => $vs_mdp));
    $reponse->closeCursor();


    //notifie l'user que son inscription est valide
    array_push($vo_reponseAjax, "validInscription");

    //recupere l'id du user pour creer une variable de session
    $bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
    $reponse = $bdd->prepare('SELECT iduser FROM user WHERE nomuser=:user ;');
    $reponse->execute(array('user' => $vs_user));

    while($donnees = $reponse -> fetch() )
    {
        $_SESSION['iduser']=$donnees['iduser'];
    }
    $reponse->closeCursor();

    //recupere le nom de l'user pour le stocker dans une variable de session
    $_SESSION['user'] = $vs_user;
}


?>
