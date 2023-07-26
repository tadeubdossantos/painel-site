<?php
    user::setconn($conn['data'] ?? '');
?>
<div class="container border registros">
    <div style="display:flex;justify-content:space-between;">
        <h3 style="padding-top:20px;">Usuários</h3>
        <span class="material-symbols-outlined" onclick="$('.registro').slideDown();$('.registros').slideUp();limparCampos();">add</span>
    </div>
    <div class="row">
        <div class="col-md-10 p-2">
            <input type="text" class="form-control" value="" placeholder="Nome, E-mail ou Login" name="pesquisa" style="width:100%;">
        </div>
        <div class="col-md-2 p-2">
            <input type="submit" value="Pesquisar" onclick="loadUsuarios();" class="btn btn-primary" style="width:100%;">
        </div>
    </div>
    <div style="padding-top:20px;">
        <table id="list-usuarios" style="width:100%" class="table">
            <thead>
                <tr>
                    <th width="33%">Nome</th>
                    <th width="33%">Login</th>
                    <th width="33%">E-mail</th>
                    <th width="33%">Ações</th>            
                </tr>
            </thead>
            <tbody>
            </tbody>        
        </table>
    </div>
</div>

<div class="container border registro">
    <div style="display:flex;justify-content:space-between;">
        <h3 style="padding-top:20px;">Usuários</h3>
        <span class="material-symbols-outlined" onclick="$('.registros').slideDown();$('.registro').slideUp();">arrow_back</span>
    </div>
    <div class="retorno"></div>
    <br/>
    <form action="" class="form" id="frmusuario" method="post">
        <input name="action" type="hidden" value="create"/>
        <input name="id_usuario" type="hidden" value=""/>
        <div class="row">
            <div class="col-md-4 p-2">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input name="nome" type="text" class="form-control"/>
                </div>
            </div>
            <div class="col-md-4 p-2">
                <div class="form-group">
                    <label for="name">E-mail</label>
                    <input name="email" type="text" class="form-control"/>
                </div>
            </div>
            <div class="col-md-4 p-2">
                <div class="form-group">
                    <label for="name">Login</label>
                    <input name="login" type="text" class="form-control"/>
                </div>
            </div>
            <div class="col-md-4 p-2">
                <div class="form-group">
                    <label for="name">Senha</label>
                    <input name="senha" type="password" class="form-control"/>
                </div>
            </div>
            <div class="col-md-4 p-2">
                <div class="form-group">
                    <label for="name">Confirme a senha</label>
                    <input name="confirma_senha" type="password" class="form-control"/>
                </div>
            </div>
            <div class="col-md-4 p-2">
                <div class="form-group">
                    <br/>
                    <input type="submit" value="Incluir" class="btn btn-primary" style="width:100%;"/>
                </div>
            </div>
        </div>        
    </form>
</div>