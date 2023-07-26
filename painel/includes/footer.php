<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js" defer></script>
<script src="scripts/globals.js"></script>
<script src="scripts/<?=($page ?? 'index')?>.js"></script>
<script>
  
  $('#frmtransparencia').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this)[0];
    $.ajax({
      type: 'POST',
      url: 'includes/api.php',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(response) {
        console.log(response)
        if(!response.result) {
          return $('.retorno').show().html(response.msg); }
        return alert(response.msg);
      },
      error: function(){
        console.log('erro')
      }
    });
  });  
  
</script>