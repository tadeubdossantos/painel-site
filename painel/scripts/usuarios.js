$(document).ready(function(){    
    loadUsuarios();  
});

$('#frmusuario').submit(function(e){
    e.preventDefault();
    if($('input[name=senha]').val() != $('input[name=confirma_senha]').val())
        return alert('Senhas não conferem!');
    $.post('api/usuario.php', $(this).serialize(), function(data) {
        if(!data.result) return alert(data.msg);
        alert(data.msg);
        location.reload();
    }).fail(function(){
        alert('error');
    })
});

function loadUsuarios() {
    $('#list-usuarios').dataTable({
        filter: false,
        paging: false,
        ordering: false,
        info: false,
        serverSide: true,
        bDestroy: true,
        language: {
            lengthMenu: "Exibindo _MENU_ registros",
            info: "Mostrando _START_ de _END_ de _TOTAL_ registro(s) ",
            infoEmpty: "Mostrando de 0 a 0 de 0 registros",
            infoFiltered: "(Filtrados no total de  _MAX_ registros)",
            zeroRecords: "Não foram encontrados registros com base na pesquisa",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Próximo",
                previous: "Anterior"
            }
        },
        ajax:{
        url: "api/usuario.php",
        type: "POST",
        data : {
            action : 'pesquisar',
            pesquisa: $('input[name=pesquisa]').val()
        },
        dataSrc: function(json) {
            json.recordsTotal = json.recordsTotal;
            json.recordsFiltered = json.recordsFiltered;
            json.data = json.data.data;
            return json.data;
        }
        },
        columns: [
        { 'data': 'nome' },
        { 'data': 'login' },
        { 'data': 'email' },
        { 'data': function(id){ return ``; } }
        ],
        fnRowCallback: function(nRow, aData) {
            $(nRow).find('td:nth-child(4)').html(`
                <span class="material-symbols-outlined btn-acoes" onclick="consultar(${aData.id});">edit</span>
                <span class="material-symbols-outlined btn-acoes" onclick="excluir(${aData.id});">delete</span>`);
        }      
    });
}

function consultar(id) {
    $.post('api/usuario.php', {'action':'read', 'id':id}, function(data){
        if(!data.result) return alert(data.msg);
        $('input[name=action]').val('update');
        $('input[name=id_usuario]').val(data.data[0].id);
        $('input[name=nome]').val(data.data[0].nome);
        $('input[name=email]').val(data.data[0].email);
        $('input[name=login]').val(data.data[0].login);
        $('.registros').slideUp();
        $('.registro').slideDown();
        $('#frmusuario input[type=submit]').attr('value','Alterar');
    });
}

function excluir(id) {
    if(!confirm('Deseja realmente excluir este usuário?')) return false;
    $.post('api/usuario.php', {'action':'delete', 'id':id}, function(data){
        if(!data.result) return alert(data.msg);
        alert(data.msg);
        location.reload();
    });
}

