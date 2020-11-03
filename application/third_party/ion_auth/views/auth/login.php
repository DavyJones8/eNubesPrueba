<title><?php echo $title ?></title>
<body>
<div class="contenedor_scroll">
  <div class="container mt-3">
    <?php if( isset( $message ) ): ?>
      <div class="container pb-4">
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="infoMessage">
            <?php echo $message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    <?php endif; ?>
    <?php if( isset( $message_error ) ): ?>
      <div class="container pb-4">
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="infoMessage">
            <?php echo $message_error; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
    <?php endif; ?>
    <?php
    if( $this->session->flashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo $this->session->flashdata('message');?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php endif;
    if( $this->session->flashdata('message_error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?php echo $this->session->flashdata('message_error');?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php endif; ?>
  </div>
  </div>
  <div class="container contenedor_login d-flex justify-content-center align-items-center text-center">
    <div class="card caja_login">
      <div class="card-header bg_corporativo">
        <h2 class="card-title text-white text-center mt-2">
          Iniciar sesión
        </h2>
      </div>
      <div class="card-body">
        
      <?php 
        $attributes = ['id' => 'login_form'];
        echo form_open('auth/login', $attributes);
      ?>
        <div class="input-group mb-3">
          <input type="email" name="identity" id="identity" class="form-control" placeholder="Email" required>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
        </div> 
        <br>
        <div class="col-xs-4">
          <a href="#" class="btn btn_corporativo btn-block btn-flat font-weight-bold text-center" id = "submit">Acceder</a>
        </div>
        <br>
        <div class="col-xs-4 text-center mt-3">
          <a class="btn btn_corporativo_secundario btn-block" href="<?php echo base_url(); ?>registro">Registrarse</a> 
        </div>
        <input type="hidden" id="max_allowed_attempts" value="<?php echo config_item('max_allowed_attempts'); ?>" />
        <input type="hidden" id="mins_on_hold" value="<?php echo ( config_item('seconds_on_hold') / 60 ); ?>" />
      <?php echo form_close();?>	
      </div>
    </div>
  </div>
</div>
<script>
$( document ).ready( function(){

  document.getElementById("submit").onclick = function() {

    document.getElementById("login_form").submit();

  }
});
</script>
</body>


