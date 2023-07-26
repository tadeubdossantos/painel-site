<?php
    header('Cache-Control: no-cache, must-revalidate'); 
    header('Content-Type: application/json; charset=utf-8');
    require_once('../../models/conexao.php');
    if(!isset($_REQUEST)) return ['result' => false];
    
    if((!is_array($conn = conexao::getconn() ?? [])) || (!$conn['result'])) {
        echo json_encode($conn);
        exit; }
    require_once('../../models/transparencia.php');

    //validar usuário autenticado
    transparencia::setconn($conn['data']);
    $data = $_REQUEST;

    if(empty($_REQUEST['action'] ?? '')) {
        echo json_encode([]); 
        exit; }

    $data['titulo'] = $_REQUEST['titulo'] ?? '';
    $data['tipo'] = $_REQUEST['tipo'] ?? '';
    $data['ano'] = $_REQUEST['ano'] ?? '';
    $data['arquivo'] = $_FILES['arquivo'] ?? [];

    if($_REQUEST['action'] == 'pesquisar') {
        $data = transparencia::pesquisar($data) ?? [];
        foreach(($data['data'] ?? []) as $k => $v) $data['data'][$k]['nome_arquivo'] = str_replace('files/','',$v['src']); 
        echo json_encode([
            'data' => $data,
            'recordsTotal' => count($data['data'] ?? []), 
            'recordsFiltered' => count($data['data'] ?? [])
        ]);
        exit; 
    } else if($data['action'] == 'create' || $data['action'] == 'update') {
        if(empty($data['titulo'])) {
            echo json_encode(['result' => false, 'msg' => 'Informe o título!']);
            exit; }
        if(empty($data['tipo'])) {
            echo json_encode(['result' => false, 'msg' => 'Informe o tipo!']);
            exit; }
        if(empty($data['id_transparencia'])) {
            if(empty($data['arquivo']['name'])) {
                echo json_encode(['result' => false, 'msg' => 'Informe o arquivo!']);
                exit; }
            if(transparencia::create($data) < 1) {
                echo json_encode(['result' => false, 'msg' => 'Inclusão não realizada!']);
                exit; }
            echo json_encode(['result' => true, 'msg' => 'Inclusão realizada com sucesso!']);
            exit;
        }
        else {
            if(transparencia::update($data) < 1) {
                echo json_encode(['result' => false, 'msg' => 'Atualização não realizada!']);
                exit; }
            echo json_encode(['result' => true, 'msg' => 'Atualização realizada com sucesso!']);
            exit;
        }
    } else if($data['action'] == 'delete') {
        if(!transparencia::delete($data)) 
            echo json_encode(['result' => false, 'msg' => 'Exclusão não realizada com sucesso! Tente novamente mais tarde!']);
        else echo json_encode(['result' => true, 'msg' => 'Inclusão realizada com sucesso!']);
        exit;
    } else if($data['action'] == 'read') {
        if(empty($row = transparencia::read($data))) 
            echo json_encode(['result' => false, 'msg' => 'Consulta não realizada com sucesso! Tente novamente mais tarde!']);
        else echo json_encode(['result' => true, 'data' => $row]);
    }
    

?>