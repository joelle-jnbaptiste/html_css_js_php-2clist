<?php
//VERIFIE SI LA SESSION EST ACTIVE
session_start();

class Session
{
    public $issession;
    public $iduser;
    public $nomuser;
}
$vo_reponseAjax=array();
$session = new Session;

setSession($session)

//reponse Ajax
$json = json_encode( $session);
echo($json) ;

//__________________________________________________________________________________________________
function setSession(&$session)
{
    if(!empty($_SESSION))
    {
        $session -> issession = true;
        $session ->  nomuser = $_SESSION['user'];
        $session -> iduser = $_SESSION['iduser'];
    }
    else
    {
        $session -> issession =false;
    }
}

?>
