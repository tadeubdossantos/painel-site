<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel - Login</title>
    <link href="styles/login.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        #retorno { background-color:#d35351; color:#fff; height:50px; margin-top:10px; padding:10px; position:relative; }
        #retorno div:first-child { width:10%; text-align: center;}
        #retorno div:nth-child(2) { width:90%; text-align:left;}
        #retorno #close { position:absolute; right:10px; top:0; }
        #retorno #close:hover { color:#ff6c2c; cursor:pointer;  }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 48 }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box" style="margin-top:20px";>
                <div id="retorno"></div>
                <div class="col-lg-12 login-title">PAINEL ADM</div>
                <div class="col-lg-12 login-form">
                    <form>
                        <div>
                            <label class="form-control-label">Login</label>
                            <input type="text" class="form-control" placeholder="joao123" id="login">
                        </div>
                        <div>
                            <label class="form-control-label">Senha</label>
                            <input type="password" class="form-control" onkeyup="if(event.keyCode == 13) logar();">
                        </div>
                        <br/>
                        <div class="col-lg-12 loginbttm">
                            <div class="col-lg-12 login-btm login-button">
                                <button type="button" class="btn btn-primary" onclick="logar();">Logar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script>
            $(document).ready(function(){});

            function logar() {
                var login = $('input[type=text]').val();
                var password = $('input[type=password]').val();
                $.post('../api/login.php', {
                    'action':'logar', 
                    'login':login, 
                    'password':password }, 
                function(data){
                    if(data.result == false) {
                        console.log(data.msg);
                        $('#retorno').html(`
                            <div><span class="material-symbols-outlined">error</span></div>
                            <div>${data.msg}</div>
                            <span id="close" onclick="$('#retorno').slideUp();">[X]</span>`).css({'display':'flex', 'justify-content':'space-around'});
                        return $('#retorno').slideDown(); }
                    setCookie('token', data.token, 7);
                    window.location.href = "home";
                });
            }

            function setCookie(cname,cvalue,exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays*24*60*60*1000));
                var expires = "expires=" + d.toGMTString();
                document.cookie = cname+"="+cvalue+"; "+expires; 
            }
        </script>
  </body>
</html>
