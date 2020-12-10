<?php
//SI LE USER EST CONNECTE ON LUI SUPPRIME SES DONNEES DE SESSION
session_start();

if(!empty($_SESSION))
{
    session_unset();
    echo json_encode("deconnexion");
}


?>
