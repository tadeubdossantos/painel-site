<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link href="styles/painel.css" rel="stylesheet">

<!-- materials icons -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">

<nav class="nav bg-primary text-white justify-content-center">
  <a class="nav-link text-white" href="home">Inicio</a>
  <a class="nav-link text-white" href="usuarios">Usuários</a>
  <a class="nav-link text-white" href="tipos_transparencias">Tipo de Transp.</a>
  <a class="nav-link text-white" href="transparencias">Transparências</a>
  <a class="nav-link text-white" href="#" onclick="
    if(confirm('Deseja realmente sair?')) {
      removeItem('token');
      window.location.href='login'; }
  ">Sair</a>
</nav>