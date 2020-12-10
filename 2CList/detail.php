<?php
session_start();

//charge une partie du header
require_once("/pages/head.html");

//a l'aide de la methode get, recupere l'id pour charger le titre du film dans la balise title
$vn_id=$_GET["id"];
$titre = "";
$bdd = new PDO('mysql:host=localhost;dbname=toseelist;charset=utf8', 'root', '');
$reponse = $bdd->prepare('SELECT titre FROM film WHERE idfilm = :id');
$reponse->execute(array('id' => $vn_id));
while($donnees = $reponse -> fetch() )
{
    $titre =$donnees['titre'] ;
}
$reponse->closeCursor();


echo "<title> 2C-LIST ".$titre."</title>";


echo "<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>";
echo "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>";
echo "<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css' integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>";
echo "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>";
echo "<link rel='stylesheet' href='style/icone.css'>";
echo "<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.4.1/css/all.css' integrity='sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz' crossorigin='anonymous'>";
echo "<link rel='stylesheet' media='all' href='style/style.scss'>";

//on charge un menu different selon si le user est connecte
if(!empty($_SESSION['user'])&&!empty($_SESSION['iduser'])){
    require_once("/Pages/headerco.html");
}
else {
    require_once("/Pages/header.html");
}

//charge le coeur de la page
require_once("/Pages/detail.html");

//charge les scripts
echo "<script src='pages/script/jquery-3.3.1.min.js'></script>";
echo "<script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js' integrity='sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy' crossorigin='anonymous'></script>";
echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js' integrity='sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49' crossorigin='anonymous'></script>";
echo "<script type='text/javascript' src='pages/script/issession.js'></script>";
echo "<script type='text/javascript' src='pages/script/deconnexion.js'></script>";
echo "<script type='text/javascript' src='pages/script/detail.js'></script>";
echo "<script type='text/javascript' src='pages/script/liste.js'></script>";

//charge le footer
require_once("/Pages/footer.html");

 ?>
