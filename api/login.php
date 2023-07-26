<?php
    header('Cache-Control: no-cache, must-revalidate'); 
    header('Content-Type: application/json; charset=utf-8');
    if(!isset($_REQUEST)) exit;
    
    require_once('../models/conexao.php');
    if((!is_array($conn = conexao::getconn() ?? [])) || (!$conn['result'])) {
        echo json_encode($conn);
        exit; }
    require_once('../models/user.php');
    user::setconn($conn['data']);

    if($_REQUEST['action'] ?? '') 
        
        if($_REQUEST['action'] == 'logar') {
            $data = ['login' => $_REQUEST['login'] ?? '', 'password' => $_REQUEST['password'] ?? ''];
            $data = user::login($data) ?? [];
            setcookie('token', $data['token'] ?? '', (7 * 24 * 60 * 60), '/');
            echo json_encode($data);
            exit;
        }
?>