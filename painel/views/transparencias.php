<?php
    $conn = conexao::getconn();
    tipo_transparencia::setconn($conn['data']);
    $tipos = tipo_transparencia::listar_tipos()['data'] ?? [];
?>
<div class="container border registros">
    <div style="display:flex;justify-content:space-between;">
        <h3 style="padding-top:20px;">Transparencias</h3>
        <span class="material-symbols-outlined" onclick="$('.registro').slideDown();$('.registros').slideUp();$('#arquivo_corrente').hide();">add</span>
    </div>
    <div class="row">
        <div class="col-md-3 p-2">
            <div class="form-group">
                <input name="titulo" type="text" class="form-control" placeholder="Título"/>
            </div>
        </div>
        <div class="col-md-3 p-2">
            <div class="form-group">
                <select name="tipo" id="tipo" class="form-select">
                    <option value="">Tipo</option>
                    <?php   
                        if(!empty($tipos))
                            foreach($tipos as $t)
                                echo '<option value="'.$t['id'].'">'.$t['titulo'].'</option>';
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-3 p-2">
            <select name="ano" style="width:100%;" class="form-select">
                <option value="">Ano</option>
                <?php
                $ano = 2022;
                while(strtotime("$ano-01-01 23:59:59") <= strtotime(date('Y')."-01-01 23:59:59")) {
                    echo '<option value="'.$ano.'">'.$ano.'</option>';
                    $ano++; }
                ?>
            </select>
        </div>
        <div class="col-md-3 p-2">
            <input type="submit" value="Pesquisar" onclick="loadTransparencia();" style="width:100%;" class="btn btn-primary">
        </div>
    </div>
    <div class="row">
        <table id="list-transparencia" style="width:100%" class="table">
            <thead>
                <tr>
                    <th width="25%">Titulo</th>
                    <th width="25%">Tipo</th>
                    <th width="25%">Ano</th>
                    <th width="25%">Arquivo</th>
                    <th width="25%">Ações</th>            
                </tr>
            </thead>
            <tbody>
            </tbody>        
        </table>
    </div>
</div>

<div class="container border registro">
    <div style="display:flex;justify-content:space-between;">
        <h3 style="padding-top:20px;">Transparências</h3>
        <span class="material-symbols-outlined" onclick="$('.registros').slideDown();$('.registro').slideUp();">arrow_back</span>
    </div>
    <br/>
    <form action="" class="form" id="frm-transparencia" method="post" enctype="multipart/form-data">
        <input name="action" type="hidden" value="create"/>
        <input name="id_transparencia" type="hidden" value=""/>
        <div class="row">
            <div class="col-md-6 p-2">
                <div class="form-group">
                    <label for="name">Título</label>
                    <input name="titulo" type="text" class="form-control" id="titulo"/>
                </div>
            </div>
            <div class="col-md-6 p-2">
                <div class="form-group">
                    <label for="ano">Tipo</label>
                    <select name="tipo" class="form-select" id="tipo">
                    <?php   
                        if(!empty($tipos))
                            foreach($tipos as $t)
                                echo '<option value="'.$t['id'].'">'.$t['titulo'].'</option>';
                    ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 p-2">
                <div class="form-group">
                    <label for="ano">Ano</label>
                    <select name="ano" class="form-select" id="ano">
                        <option value="">Nenhum</option>
                        <?php
                        $ano = 2022;
                        while(strtotime("$ano-01-01 23:59:59") <= strtotime(date('Y')."-01-01 23:59:59")) {
                            echo '<option value="'.$ano.'">'.$ano.'</option>';
                            $ano++; }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6 p-2">
                <div class="form-group">
                    <div style="display:flex;justify-content:space-between;">
                        <label for="arquivo">Arquivo</label>
                        <a href="" id="arquivo_corrente" target="_blanck">Baixar arquivo atual</a>
                    </div>
                    <input type="file" name="arquivo" id="arquivo" style="background-color:white;width:100%;border:1px solid #dee2e6;border-radius:4px;padding:5px;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 p-2">
            </div>
            <div class="col-md-2 p-2">
                <div class="form-group">
                    <input type="submit" value="Incluir" style="width:100%;" class="btn btn-primary"/>
                </div>
            </div>
        </div>
    </form>
</div>