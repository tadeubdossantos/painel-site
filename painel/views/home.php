<div class="container">
  <div class="row">
    <div class="col-lg-12 p-2">
      <h3>
        <?php
          if(date('H') >= 6 && date('H') < 12) echo 'Bom dia ';
          else if(date('H') >= 12 && date('H') < 18) echo 'Boa tarde ';
          else echo 'Boa noite ';
          echo user::getcurrent($_COOKIE['token'])['nome'] ?? 'usuário desconhecido';
          echo ', seja bem vindo!';
        ?></h3>
      <hr />
    </div>
  </div>
  <div class="row">

    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
      <a class="text-decoration-none" href="#" data-toggle="modal" data-target="#modelHELP">
        <div class="card p-3 shadow text-white text-center border-0 bg-primary">
          <div class="card-body" style="display:flex;justify-content:space-between;">
            <div><span class="material-symbols-outlined">person</span></div>
            <div><p class="card-title lead"><?=user::count_users() ?? 0;?></p></div>
          </div>
          <div><p>Usuários ativos até o momento</p></div>
        </div>
      </a>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
      <a class="text-decoration-none" href="#" data-toggle="modal" data-target="#modelHELP">
        <div class="card p-3 shadow text-white text-center border-0 bg-danger">
          <div class="card-body" style="display:flex;justify-content:space-between;">
            <div><span class="material-symbols-outlined">draft</span></div>
            <div><p class="card-title lead"><?php
                tipo_transparencia::setconn($conn['data'] ?? '');
                echo tipo_transparencia::qtd();
              ?></p></div>
          </div>
          <div><p>Tipo de Transparências</p></div>
        </div>
      </a>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 p-2">
      <a class="text-decoration-none" href="#" data-toggle="modal" data-target="#modelHELP">
        <div class="card p-3 shadow text-white text-center border-0 bg-success">
          <div class="card-body" style="display:flex;justify-content:space-between;">
            <div><span class="material-symbols-outlined">draft</span></div>
            <div><p class="card-title lead"><?php
                transparencia::setconn($conn['data'] ?? '');
                echo transparencia::qtd();
              ?></p></div>
          </div>
          <div><p>Transparências incluídas</p></div>
        </div>
      </a>
    </div>
  </div>
</div>
