<?php
    header('Cache-Control: no-cache, must-revalidate'); 
    header('Content-Type: application/json; charset=utf-8');
    if(!isset($_REQUEST)) exit;
    
    require_once('../models/conexao.php');
    if((!is_array($conn = conexao::getconn() ?? [])) || (!$conn['result'])) {
        echo json_encode($conn);
        exit; }
    
    if($_REQUEST['action'] ?? '') {
        require_once('../models/transparencia.php');
        require_once('../models/tipo_transparencia.php');
        transparencia::setconn($conn['data']);
        tipo_transparencia::setconn($conn['data']);
        
        if($_REQUEST['action'] == 'pesquisar') {
            $data = [
                'titulo' => $_REQUEST['titulo'] ?? '', 
                'tipo' => $_REQUEST['tipo'] ?? '',
                'ano' => $_REQUEST['ano'] ?? ''
            ];
            
            $data = transparencia::pesquisar($data) ?? [];
            echo json_encode([
                'data' => $data,
                'recordsTotal' => count($data), 
                'recordsFiltered' => count($data)
            ]);
            exit; }

        if($_REQUEST['action'] == 'tipos') {
            $data = tipo_transparencia::listar_tipos() ?? [];
            echo json_encode($data);
            exit; }

        if($_REQUEST['action'] == 'anos') {
            $data = transparencia::listar_anos() ?? [];
            echo json_encode([
                'result' => count($data),
                'data' => $data,
            ]);
            exit;
        }
    }

    




?>