<div class="contenedor_scroll">
<div class="container my-3 p-3 border border-info rounded bg-white">
	<h1 class="text-center txt_corporativo">MIS NOTICIAS</h1>
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
		foreach( $noticias as $n ):
?>
<div class="container bg_corporativo p-3 mt-2 border border-info rounded-top">
	<div class="row mt-3">
		<div class="col-12">
			<h3 class="m-0 text-justify text-center text-uppercase titulo"><?php echo $n->titulo; ?></h3>
		</div>
	</div>
	<div class="row">
		<?php if( $_SESSION['group'] == 1 || $_SESSION['group'] > 1 && $n->usuario == $_SESSION['user_id'] ): ?>
		<div class="col-12 mt-2 d-flex justify-content-end align-items-center">
			<div class="dropdown d-inline mr-1">
				<button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-newspaper"></i>
				</button>
				<div class="dropdown-menu text-center" aria-labelledby="dropdownMenuButton">
					<?php if( $_SESSION['group'] <= 2 ):?>
					<button class="dropdown-item privacidad <?php if( $n->privacidad == '1' ): echo 'bg-info'; endif;?>" data-privacidad="1" data-id="<?php echo $n->id;?>">Pública</button>
					<button class="dropdown-item privacidad <?php if( $n->privacidad == '2' ): echo 'bg-info'; endif;?>" data-privacidad="2" data-id="<?php echo $n->id;?>">Privada</button>
					<?php endif; ?>
					<button class="dropdown-item estado <?php if( $n->estado == '1' ): echo 'bg-info'; endif;?>" data-estado="1" data-id="<?php echo $n->id;?>">Publicada</button>
					<button class="dropdown-item estado <?php if( $n->estado == '2' ): echo 'bg-info'; endif;?>" data-estado="2" data-id="<?php echo $n->id;?>">No publicada</button>
				</div>
			</div>
			<a href="<?php echo base_url() . 'editar_noticia/' . $n->id;;?>" class="btn btn-success mr-1"><i class="fas fa-pen-nib"></i></a>
			<button class="btn btn-danger btn-confirm" data-id = "<?php echo $n->id?>" id="btn-confirm-<?php echo $n->id;?>">
				<i class ="fas fa-eraser"></i>
			</button>
		</div>
		<?php endif; ?>
	</div>
</div>	
<div class="container border border-top-0 border-bottom-0 border-info p-3 bg-white contenido">
	<?php echo word_limiter( $n->contenido, 50 ); ?>
	<div class="d-flex justify-content-center">
		<a href="<?php echo base_url() . 'noticia/' . $n->id; ?>" class="btn btn_corporativo_secundario btn-flat font-weight-bold text-center mt-3 border" id = "seguir_leyendo">Seguir leyendo</a>
	</div>
</div>
<div class="container bg_corporativo p-3 border border-info rounded-bottom d-md-flex align-items-center justify-content-between">
	<h6 class="m-0">Usuario: <?php echo $n->nombre . ' ' . $n->apellidos;?></h6>
	<h6 class="m-0">Fecha: <?php echo fechaEsp($n->fecha); ?></h6>
</div>
<div class="container py-2">
	<hr>
</div>
	<?php endforeach;?>
	<?php
		$prev = $current_page - 1;
		$next = $current_page + 1;

		if ($prev < 1)
				$prev = 1;

		if ($next > $last_page)
				$next = $last_page;
	?>
  <div class="card_button mb-4">
		<ul class= "pagination d-flex justify-content-center align-content-center">
			<li class="page-item"><a class="page-link btn_corporativo enlace_corporativo" href = "<?php echo base_url() . 'noticias/' . $prev ?>"><</a></li>
			<?php for ($i = 1; $i <= $last_page; $i++) { ?>
				<li class="page-link btn_corporativo"><a class="enlace_corporativo" href ="<?php echo base_url() . 'noticias/' . $i; ?> "> <?php echo $i; ?></a></li>
			<?php } ?>
			<?php if ($current_page != $next) { ?>
				<li class="page-link btn_corporativo"><a class="enlace_corporativo" href = "<?php echo base_url() . 'noticias/' . $next ?> ">></a></li>
			<?php } ?>
		</ul>
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

			$(".estado").on("click", function(){
				var id = $(this).data("id");
				var id_estado = $(this).data("estado");
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

					window.location.href='<?php echo base_url();?>mis_noticias';
					
				});
			}

			$(".privacidad").on("click", function(){
				var id = $(this).data("id");
				var id_privacidad = $(this).data("privacidad");
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

					window.location.href='<?php echo base_url();?>mis_noticias';
					
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

					window.location.href='<?php echo base_url();?>mis_noticias';
					
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