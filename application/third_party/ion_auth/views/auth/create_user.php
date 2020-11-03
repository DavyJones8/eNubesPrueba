<div class="contenedor_scroll">
<div class="container mt-3">
<?php if( isset( $message ) ): ?>
    <div class="container">
      <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="infoMessage">
          <?php echo $message; ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  <?php endif; ?>
  <?php if( isset( $message_error ) ): ?>
    <div class="container">
      <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="infoMessage">
          <?php echo $message_error; ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
	<?php endif; ?>
	<?php if( isset( $message_error_captcha ) ): ?>
    <div class="container">
      <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="infoMessage">
          <?php echo $message_error_captcha; ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  <?php endif; ?>
</div>
<div class="contenedor_registro">
  <div class="container d-flex justify-content-center align-items-center text-center mb-4">
    <div class="card caja_login">
			<div class="card-header bg_corporativo">
				<h2 class="card-title card_title_login text-center mt-2">
					Registro
				</h2>
			</div>
			<div class="card-body">
				<?php 
				$attributes = ['id' => 'register_form'];
				echo form_open('auth/create_user', $attributes);
				?>
				<div class="input-group mb-3">
					<input type="text" name="first_name" id="first_name" class="form-control" placeholder="Nombre" required>
				</div>
				<div class="input-group mb-3">
					<input type="text" name="last_name" id="last_name" class="form-control" placeholder="Apellidos" required>
				</div>
				<div class="input-group mb-3">
					<input type="text" name="email" id="email" class="form-control" placeholder="Email" required>
				</div>
				<div class="input-group mb-3">
					<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
				</div> 
				<div class="input-group mb-3">
					<input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirma contraseña" required>
				</div> 
				<p>Indique los caracteres de la imagen.</p>
				<div class="d-flex justify-content-around align-items-center mb-3">
					<span id="captImg"><?php echo $captchaImg; ?></span>
					<a href="javascript:void(0);" class="refreshCaptcha txt_corporativo" ><i class="fas fa-sync fa-2x"></i></a>
				</div>
				<div class="input-group mb-3">
					<input type="text" name="captcha" id="captcha" class="form-control" placeholder="Captcha" required>
				</div>
				<div class="col-xs-4 mt-2">
					<a href="#" class="btn btn_corporativo btn-block btn-flat font-weight-bold text-center" id = "submit">Registrar</a>
				</div>
				<br>
				<div class="col-xs-4 text-center mt-2">
					<a class="btn btn_corporativo_secundario btn-block" href="<?php echo base_url(); ?>login">Ya estoy registrado</a> 
				</div>
			<?php echo form_close();?>	
			</div>
		</div>
  </div>
</div>
<script>
	$(document).ready(function(){

		$('.refreshCaptcha').on('click', function(){
			$('.fa-sync').addClass('fa-spin');
			$('#captImg i').addClass();
			$.get('<?php echo base_url().'captcha/refresh'; ?>', function(data){
				$('#captImg').html(data);
				$('.fa-sync').removeClass('fa-spin');
			});
		});

		document.getElementById("submit").onclick = function() {

      document.getElementById("register_form").submit();

    }
	});
</script>
</div>