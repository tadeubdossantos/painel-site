<?php
    require_once("../includes/config.php");
    require_once("../models/conexao.php");
    require_once("../models/user.php");
    require_once("../models/transparencia.php");
    require_once("../models/tipo_transparencia.php");
    $conn = conexao::getconn();
    user::setconn($conn['data'] ?? '');
    if($page != 'login' && !empty($_COOKIE['token'] ?? '') && user::validar_token($_COOKIE['token'])) {
        require_once('includes/header.php');
        require_once('views/'.$page.'.php');
        require_once('includes/footer.php'); }
    else require_once('views/login.php');
?>