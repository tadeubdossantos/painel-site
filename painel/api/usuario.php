<?php
    header('Cache-Control: no-cache, must-revalidate'); 
    header('Content-Type: application/json; charset=utf-8');
    require_once('../../models/conexao.php');
    if(!isset($_REQUEST)) return ['result' => false];
    
    if((!is_array($conn = conexao::getconn() ?? [])) || (!$conn['result'])) {
        echo json_encode($conn);
        exit; }
    require_once('../../models/user.php');

    //validar usuário autenticado
    user::setconn($conn['data']);
    $data = $_REQUEST;
    
    require_once('usuario.php');    

    if($_REQUEST['action'] == 'pesquisar') {
        $data['pesquisa'] = $_REQUEST['pesquisa'] ?? '';
        $data = user::pesquisar($data) ?? [];
        echo json_encode([
            'data' => $data,
            'recordsTotal' => count($data['data'] ?? []), 
            'recordsFiltered' => count($data['data'] ?? [])
        ]);
        exit; 
    } else if($data['action'] == 'create' || $data['action'] == 'update') {
        if(empty($data['nome'] ?? '')) {
            echo json_encode(['result' => false, 'msg' => 'Informe o nome!']);
            exit; }
        if(empty($data['email'] ?? '')) {
            echo json_encode(['result' => false, 'msg' => 'Informe o e-mail!']);
            exit; }
        if(empty($data['login'] ?? '')) {
            echo json_encode(['result' => false, 'msg' => 'Informe o login!']);
            exit; }
        if(empty($data['senha'] ?? '')) {
            echo json_encode(['result' => false, 'msg' => 'Informe a senha!']);
            exit; }
        if(empty($data['confirma_senha'] ?? '')) {
            echo json_encode(['result' => false, 'msg' => 'Informa a senha de confirmação!']);
            exit; }
        if($data['senha'] != $data['confirma_senha']) {
            echo json_encode(['result' => false, 'msg' => 'Senhas não conferem!']);
            exit; }
        if(empty($data['id_usuario'])) {
            if(user::create($data) < 1) {
                echo json_encode(['result' => false, 'msg' => 'Inclusão não realizada!']);
                exit; }
            echo json_encode(['result' => true, 'msg' => 'Inclusão realizada com sucesso!']);
            exit;
        }
        else {
            if(user::update($data) < 1) {
                echo json_encode(['result' => false, 'msg' => 'Atualização não realizada!']);
                exit; }
            echo json_encode(['result' => true, 'msg' => 'Atualização realizada com sucesso!']);
            exit;
        }
    } else if($data['action'] == 'delete') {
        if(!user::delete($data)) 
            echo json_encode(['result' => false, 'msg' => 'Exclusão não realizada com sucesso! Tente novamente mais tarde!']);
        else echo json_encode(['result' => true, 'msg' => 'Inclusão realizada com sucesso!']);
        exit;
    } else if($data['action'] == 'read') {
        if(empty($row = user::read($data))) 
            echo json_encode(['result' => false, 'msg' => 'Consulta não realizada com sucesso! Tente novamente mais tarde!']);
        else echo json_encode(['result' => true, 'data' => $row]);
    }
    

?>