<?php
    header('Cache-Control: no-cache, must-revalidate'); 
    header('Content-Type: application/json; charset=utf-8');
    require_once('../../models/conexao.php');
    if(!isset($_REQUEST)) return ['result' => false];
    
    if((!is_array($conn = conexao::getconn() ?? [])) || (!$conn['result'])) {
        echo json_encode($conn);
        exit; }
    require_once('../../models/tipo_transparencia.php');

    //validar usuário autenticado
    tipo_transparencia::setconn($conn['data']);
    $data = $_REQUEST;
    
    require_once('tipo_transparencia.php');    

    if($_REQUEST['action'] == 'pesquisar') {
        $data['pesquisa'] = $_REQUEST['pesquisa'] ?? '';
        $data = tipo_transparencia::pesquisar($data) ?? [];
        echo json_encode([
            'data' => $data,
            'recordsTotal' => count($data['data'] ?? []), 
            'recordsFiltered' => count($data['data'] ?? [])
        ]);
        exit; 
    } else if($data['action'] == 'create' || $data['action'] == 'update') {
        if(empty($data['titulo'] ?? '')) {
            echo json_encode(['result' => false, 'msg' => 'Informe o título!']);
            exit; }        
        if(empty($data['id_tipotransparencia'])) {
            if(tipo_transparencia::create($data) < 1) {
                echo json_encode(['result' => false, 'msg' => 'Inclusão não realizada!']);
                exit; }
            echo json_encode(['result' => true, 'msg' => 'Inclusão realizada com sucesso!']);
            exit;
        }
        else {
            if(tipo_transparencia::update($data) < 1) {
                echo json_encode(['result' => false, 'msg' => 'Atualização não realizada!']);
                exit; }
            echo json_encode(['result' => true, 'msg' => 'Atualização realizada com sucesso!']);
            exit;
        }
    } else if($data['action'] == 'delete') {
        if(!tipo_transparencia::delete($data)) 
            echo json_encode(['result' => false, 'msg' => 'Exclusão não realizada com sucesso! Tente novamente mais tarde!']);
        else echo json_encode(['result' => true, 'msg' => 'Inclusão realizada com sucesso!']);
        exit;
    } else if($data['action'] == 'read') {
        if(empty($row = tipo_transparencia::read($data))) 
            echo json_encode(['result' => false, 'msg' => 'Consulta não realizada com sucesso! Tente novamente mais tarde!']);
        else echo json_encode(['result' => true, 'data' => $row]);
    }
    

?>