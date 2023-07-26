$(document).ready(function(){    
    loadTiposTransparencias();  
});

$('#frm-tipotransparencia').submit(function(e){
    e.preventDefault();
    $.post('api/tipo_transparencia.php', $(this).serialize(), function(data) {
        if(!data.result) return alert(data.msg);
        alert(data.msg);
        location.reload();
    }).fail(function(){
        alert('error');
    });
});

function loadTiposTransparencias() {
    $('#list-tipostransparencias').dataTable({
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
        ajax: {
            url: "api/tipo_transparencia.php",
            type: "POST",
            data : {
                action : 'pesquisar',
                pesquisa: $('input[name=pesquisa]').val()
            },
            dataSrc: function(json) {
                console.log(json);
                json.recordsTotal = json.recordsTotal;
                json.recordsFiltered = json.recordsFiltered;
                json.data = json.data.data;
                return json.data;
            }
        },
        columns: [
        { 'data': 'titulo' },
        { 'data': 'qtd_transp' },
        { 'data': function(id){ return ``; } }
        ],
        fnRowCallback: function(nRow, aData) {
            $(nRow).find('td:nth-child(3)').html(`
                <span class="material-symbols-outlined btn-acoes" onclick="consultar(${aData.id});">edit</span>
                <span class="material-symbols-outlined btn-acoes" onclick="excluir(${aData.id});">delete</span>`);
        }      
    });
}

function consultar(id) {
    $.post('api/tipo_transparencia.php', {'action':'read', 'id':id}, function(data){
        console.log(data);
        if(!data.result) return alert(data.msg);
        $('input[name=action]').val('update');
        $('input[name=id_tipotransparencia]').val(data.data[0].id);
        $('input[name=titulo]').val(data.data[0].titulo);
        $('.registros').slideUp();
        $('.registro').slideDown();
        $('#frm-tipotransparencia input[type=submit]').attr('value','Alterar');
    });
}

function excluir(id) {
    if(!confirm('Deseja realmente excluir este tipo de transparência?')) return false;
    $.post('api/tipo_transparencia.php', {'action':'delete', 'id':id}, function(data){
        if(!data.result) return alert(data.msg);
        alert(data.msg);
        location.reload();
    });
}

