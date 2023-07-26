<?php
    //url amigável
    $page = 'home';
    $acao = '';
    if(!empty($_GET['url'] ?? '')) {
        $params = str_replace('.php', '', $_GET['url']);
        $params = explode('/', $params);
        if(file_exists('views/'.$params[0].'.php')) {
            $page = $params[0] ?? '';
            $acao = $params[1] ?? ''; }
        else
            $page = 'nao-encontrado';
    }

    //descrição da página
    $descricao = [
        'home' => 'Página Inicial',
        'eventos' => 'Eventos',
        'nossa-historia' => 'Nossa História',
        'transparencias' => 'Transparências',
        'transparencias_alteracao' => 'Transparências',
        'contato' => 'Contato'
    ];


?>