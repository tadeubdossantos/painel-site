<div class="container border registros">
    <div style="display:flex;justify-content:space-between;">
        <h3 style="padding-top:20px;">Tipo de Transparências</h3>
        <span class="material-symbols-outlined" onclick="$('.registro').slideDown();$('.registros').slideUp();">add</span>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-10 p-2">
            <input type="text" class="form-control" value="" placeholder="Tipo de Transparência" name="pesquisa" style="width:100%;">
        </div>
        <div class="col-md-2 p-2">
            <input type="submit" value="Pesquisar" onclick="loadTiposTransparencias();" class="btn btn-primary" style="width:100%;">
        </div>
    </div>
    <div style="padding-top:20px;">
        <table id="list-tipostransparencias" style="width:100%" class="table">
            <thead>
                <tr>
                    <th width="80%">Titulo</th>
                    <th witdh="10%">Qtd. Transp.</th>
                    <th width="10%">Ações</th>            
                </tr>
            </thead>
            <tbody>               
            </tbody>        
        </table>
    </div>
</div>

<div class="container border registro">
    <div style="display:flex;justify-content:space-between;">
        <h3 style="padding-top:20px;">Tipo de Transparênciass</h3>
        <span class="material-symbols-outlined" onclick="$('.registros').slideDown();$('.registro').slideUp();">arrow_back</span>
    </div>
    <div class="retorno"></div>
    <br/>
    <form action="" class="form" id="frm-tipotransparencia" method="post">
        <input name="action" type="hidden" value="create"/>
        <input name="id_tipotransparencia" type="hidden" value=""/>
        <div class="row">
            <div class="col-md-10 p-2">
                <div class="form-group">
                    <label for="name">Titulo</label>
                    <input name="titulo" type="text" class="form-control"/>
                </div>
            </div>
            <div class="col-md-2 p-2">
                <div class="form-group">
                    <br/>
                    <input type="submit" value="Incluir" class="btn btn-primary" style="width:100%;"/>
                </div>
            </div>
        </div>        
    </form>
</div>