<div class="contenedor_scroll">
<div class="container my-3 p-3 border border-info rounded bg-white">
	<h1 class="text-center txt_corporativo">GESTIÓN DE USUARIOS</h1>
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
	if( isset( $usuarios ) && $usuarios ): 
?>
<div class="container bg-white border border-info rounded py-2">
  <table class="table table-stripe table-hover table-responsive-lg">
    <thead>
      <th class="text-center">Usuario</th>
      <th class="text-center">Email</th>
      <th class="text-center">Rol</th>
      <th class="text-center">Acciones</th>
    </thead>
    <tbody>
      <?php 
		    foreach( $usuarios as $u ):
      ?>
      <tr>
        <td class="text-center" title="<?php echo $u->first_name . ' ' . $u->last_name; ?>"><?php echo character_limiter($u->first_name . ' ' . $u->last_name, 30)?></td>
        <td class="text-center" title="<?php echo $u->email; ?>"><?php echo character_limiter($u->email, 30)?></td>
        <td class="text-center">
          <select class="custom-select group" data-id="<?php echo $u->id;?>">
            <option <?php if( $u->group == '1' ) echo 'selected';?> value="1">Admin</option>
            <option <?php if( $u->group == '2' ) echo 'selected';?> value="2">Vip</option>
            <option <?php if( $u->group == '3' ) echo 'selected';?> value="3">Miembro</option>
          </select>
        </td>
        <td class="text-center">
          <button class="btn btn-danger btn-confirm" data-id = "<?php echo $u->id?>" id="btn-confirm-<?php echo $u->id;?>">
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
        <h4 class="modal-title" id="myModalLabel">¿Borrar este usuario?</h4>
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

  $(".group").on("change", function(){
    var id = $(this).data("id");
    var id_group = $(this).val();
    cambiarGroup( id, id_group );
  });

  function cambiarGroup( id, id_group ){

    $.ajaxSetup({data: {token: CFG.token}});
    
    $(document).ajaxSuccess(function(e,x) {
      var result = $.parseJSON(x.responseText);
      $('input:hidden[name="token"]').val(result.token);
      $.ajaxSetup({data: {token: result.token}});
    });
    
    $.ajax({

      method: "POST",
      url: CFG.url + 'user/cambiarGroupAjax',
      data: { 
              id : id,
              group : id_group
            }
      
    }).done(function( data ) {

      window.location.href='<?php echo base_url();?>gestion_usuarios';
      
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
    borrarUsuario( id_click );
  });
  
  $("#modal-btn-no").on("click", function(){
    $("#mi-modal").modal('hide');
  });

  function borrarUsuario( id_usuario ){

    $.ajaxSetup({data: {token: CFG.token}});
    
    $(document).ajaxSuccess(function(e,x) {
      var result = $.parseJSON(x.responseText);
      $('input:hidden[name="token"]').val(result.token);
      $.ajaxSetup({data: {token: result.token}});
    });
    
    $.ajax({

      method: "POST",
      url: CFG.url + 'user/borrarUsuarioAjax',
      data: { id_usuario : id_usuario }
      
    }).done(function( data ) {

      if( data ){

      } else {

      }

      window.location.href='<?php echo base_url();?>gestion_usuarios';
      
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