<div class="contenedor_scroll">
<div class="container my-3 p-3 border border-info rounded bg-white">
	<h1 class="text-center txt_corporativo">GESTIÓN DE NOTICIAS</h1>
</div>
<div class="container">
  <?php
    if( $this->session->flashdata('mensaje_error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $this->session->flashdata('mensaje_error');?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php endif;
    if( $this->session->flashdata('mensaje_correcto')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $this->session->flashdata('mensaje_correcto');?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php endif; ?>
  </div>
<?php 
	if( isset( $noticias ) && $noticias ): 
?>
<div class="container bg-white border border-info rounded py-2">
  <table class="table table-stripe table-hover table-responsive-lg">
    <thead>
      <th class="text-center">Fecha</th>
      <th class="text-center">Usuario</th>
      <th class="text-center">Título</th>
      <th class="text-center">Estado</th>
      <th class="text-center">Privacidad</th>
      <th class="text-center">Acciones</th>
    </thead>
    <tbody>
      <?php 
		    foreach( $noticias as $n ):
      ?>
      <tr>
        <td data-sort="<?php echo $n->fecha;?>" class="text-center"><?php echo fechaEsp( $n->fecha );?></td>
        <td class="text-center" title="<?php echo $n->nombre . ' ' . $n->apellidos; ?>"><?php echo character_limiter($n->nombre . ' ' . $n->apellidos, 30)?></td>
        <td class="text-center" title="<?php echo $n->titulo; ?>"><?php echo character_limiter($n->titulo, 30)?></td>
        <td class="text-center">
          <select class="custom-select estado" data-id="<?php echo $n->id;?>">
            <option <?php if( $n->estado == '1' ) echo 'selected';?> value="1">Publicada</option>
            <option <?php if( $n->estado == '2' ) echo 'selected';?> value="2">No publicada</option>
          </select>
        </td>
        <td class="text-center">
          <select class="custom-select privacidad" data-id="<?php echo $n->id;?>">
            <option <?php if( $n->privacidad == '1' ) echo 'selected';?> value="1">Pública</option>
            <option <?php if( $n->privacidad == '2' ) echo 'selected';?> value="2">Privada</option>
          </select>
        </td>
        <td class="text-center">
          <a href="<?php echo base_url() . 'editar_noticia/' . $n->id;;?>" class="btn btn-success mr-1"><i class="fas fa-pen-nib"></i></a>
          <button class="btn btn-danger btn-confirm" data-id = "<?php echo $n->id?>" id="btn-confirm-<?php echo $n->id;?>">
            <i class ="fas fa-eraser"></i>
          </button>
        </td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-center">
        <h4 class="modal-title" id="myModalLabel">¿Borrar esta noticia?</h4>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-success" id="modal-btn-si">Si</button>
        <button type="button" class="btn btn-danger" id="modal-btn-no">No</button>
      </div>
    </div>
  </div>
</div>
<script>

$( document ).ready( function(){

  $('.table').dataTable({
      "order": [[ 0, "desc" ]],
			"bPaginate": true,
      "lengthMenu": [ 10, 25, 50 ],
			"bLengthChange": true,
			"bFilter": true,
			"bInfo": false,
			"bAutoWidth": false,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
			}
  });

  $(".estado").on("change", function(){
    var id = $(this).data("id");
    var id_estado = $(this).val();
    console.log(id);
    console.log(id_estado);
    cambiarEstado( id, id_estado );
  });

  function cambiarEstado( id, id_estado ){

    $.ajaxSetup({data: {token: CFG.token}});
    
    $(document).ajaxSuccess(function(e,x) {
      var result = $.parseJSON(x.responseText);
      $('input:hidden[name="token"]').val(result.token);
      $.ajaxSetup({data: {token: result.token}});
    });
    
    $.ajax({

      method: "POST",
      url: CFG.url + 'noticias/cambiarEstadoAjax',
      data: { 
              id : id,
              estado : id_estado
            }
      
    }).done(function( data ) {

      window.location.href='<?php echo base_url();?>gestion_noticias';
      
    });
  }

  $(".privacidad").on("change", function(){
    var id = $(this).data("id");
    var id_privacidad = $(this).val()
    cambiarPrivacidad( id, id_privacidad );
  });

  function cambiarPrivacidad( id, id_privacidad ){

    $.ajaxSetup({data: {token: CFG.token}});
    
    $(document).ajaxSuccess(function(e,x) {
      var result = $.parseJSON(x.responseText);
      $('input:hidden[name="token"]').val(result.token);
      $.ajaxSetup({data: {token: result.token}});
    });
    
    $.ajax({

      method: "POST",
      url: CFG.url + 'noticias/cambiarPrivacidadAjax',
      data: { 
              id : id,
              privacidad : id_privacidad
            }
      
    }).done(function( data ) {

      window.location.href='<?php echo base_url();?>gestion_noticias';
      
    });
  }

  $(".btn-confirm").on("click", function(){
    var id_click = $(this).data("id");
    $("#modal-btn-si").data( 'id', id_click );
    $("#mi-modal").modal('show');
  });

  $("#modal-btn-si").on("click", function(){
    var id_click = $(this).data("id");
    $("#mi-modal").modal('hide');
    borrarNoticia( id_click );
  });
  
  $("#modal-btn-no").on("click", function(){
    $("#mi-modal").modal('hide');
  });

  function borrarNoticia( id_noticia ){

    $.ajaxSetup({data: {token: CFG.token}});
    
    $(document).ajaxSuccess(function(e,x) {
      var result = $.parseJSON(x.responseText);
      $('input:hidden[name="token"]').val(result.token);
      $.ajaxSetup({data: {token: result.token}});
    });
    
    $.ajax({

      method: "POST",
      url: CFG.url + 'noticias/borrarNoticiaAjax',
      data: { id_noticia : id_noticia }
      
    }).done(function( data ) {

      if( data ){

      } else {

      }

      window.location.href='<?php echo base_url();?>gestion_noticias';
      
    });
  }
});
</script>
<?php else: ?>
<div class="container">
	<h3 class="text-center txt_corporativo">No hay noticias todavía.</h3>
</div>
<?php endif; ?>
</div>