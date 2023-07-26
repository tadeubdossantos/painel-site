$(document).ready(function(){    
    loadTransparencia();  
});

$('#frm-transparencia').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: "api/transparencias.php",
        method: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        enctype: 'multipart/form-data',
        success: function (data) {
            if(!data.result) return alert(data.msg);
            alert(data.msg);
            location.reload();
        }
    });
});

function loadTransparencia() {
    $('#list-transparencia').dataTable({
        filter: false,
        paging: false,
        ordering: false,
        info: false,
        serverSide: true,
        bDestroy: true,
        responsive: true,
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
            url: "api/transparencias.php",
            type: "POST",
            data : {
                action : 'pesquisar',
                titulo: $('input[name=titulo]').val(),
                tipo: $('select[name=tipo]').val(),
                ano: $('select[name=ano]').val()
            },
            dataSrc: function(json) {
                json.recordsTotal = json.recordsTotal;
                json.recordsFiltered = json.recordsFiltered;
                json.data = json.data.data;
                return json.data;
            }
        },
        columns: [
        { 'data': 'titulo' },
        { 'data': 'titulo_tipo' },
        { 'data': 'ano' },
        { 'data': 'nome_arquivo' },
        { 'data': function(id){ return ``; } }
        ],
        fnRowCallback: function(nRow, aData) {
            $(nRow).find('td').click(function() {
                window.open('../files/'+aData.src, '_blank');
            });

            $(nRow).find('td:nth-child(5)')
                .off('click')
                .html(`<span class="material-symbols-outlined btn-acoes" onclick="consultar(${aData.id});">edit</span>
                <span class="material-symbols-outlined btn-acoes" onclick="excluir(${aData.id});">delete</span>`);
        }      
    });
}

function consultar(id) {
    $.post('api/transparencias.php', {'action':'read', 'id':id}, function(data){
        if(!data.result) return alert(data.msg);
        $('input[name=titulo]').val(data.data[0].titulo);
        $('select[name=tipo]').val(data.data[0].tipoid);
        $('select[name=ano]').val(data.data[0].ano);
        $('#arquivo_corrente').attr('href', '../files/'+data.data[0].src).show();
        $('input[name=action]').val('update');
        $('input[name=id_transparencia]').val(data.data[0].id);
        $('.registros').slideUp();
        $('.registro').slideDown();
        $('#frm-transparencia input[type=submit]').attr('value','Alterar');
    });
}

function excluir(id) {
    if(!confirm('Deseja realmente excluir essa transparência?')) return false;
    $.post('api/transparencias.php', {'action':'delete', 'id':id}, function(data){
        if(!data.result) return alert(data.msg);
        alert(data.msg);
        location.reload();
    });
}