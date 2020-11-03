<div class="contenedor_scroll">
<script src="<?php echo base_url();?>assets/ckeditor/ckeditor.js"></script>
  <div class="container my-2 d-flex justify-content-center align-items-center">

  <div class="container my-3 p-3 border border-info rounded bg-white">
      <h1 class = "text-center txt_corporativo">
      <?php 
        if( !isset( $noticia )):

          echo 'CREAR NOTICIA';

        else:

          echo 'EDITAR NOTICIA';

        endif;
      ?>
      </h1>
    </div>
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
    if( !isset( $noticia )):
      $attributes = ['id' => 'crear_form'];
      echo form_open_multipart('save' , $attributes );
    else:
      $attributes = ['id' => 'crear_form'];
      $hidden = ['usuario' => $noticia[0]->usuario ];
      echo form_open_multipart('update/' . $noticia[0]->noticia_id , $attributes, $hidden );
    endif;
  ?>
  <div class="container my-3">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text d-flex justify-content-center bg_corporativo text-white" style="width: 105px;">Título</span>
      </div>
      <input type="text" class="form-control" name="titulo" value="<?php if(isset($noticia)) echo $noticia[0]->titulo;?>" required>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text d-flex justify-content-center bg_corporativo text-white" style="width: 105px;">Estado</label>
      </div>
      <select class="custom-select" id="inputGroupSelect01" name="estado" required>
        <option value='' selected>Selecciona un estado</option>
        <option <?php if(isset($noticia) && $noticia[0]->estado == '1' ) echo 'selected';?> value="1">Publicada</option>
        <option <?php if(isset($noticia) && $noticia[0]->estado == '2' ) echo 'selected';?> value="2">No publicada</option>
      </select>
    </div>
    <?php if( $_SESSION['group'] <= 2 ): ?>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text d-flex justify-content-center bg_corporativo text-white" style="width: 105px;">Privacidad</label>
      </div>
      <select class="custom-select" id="inputGroupSelect02" name="privacidad">
        <option value='' selected>Selecciona la privacidad</option>
        <option <?php if(isset($noticia) && $noticia[0]->privacidad == '1' ) echo 'selected';?> value="1">Pública</option>
        <option <?php if(isset($noticia) && $noticia[0]->privacidad == '2' ) echo 'selected';?> value="2">Privada</option>
      </select>
    </div>
    <?php endif;?>
    <textarea name="contenido" class="contenido"><?php if(isset($noticia)) echo $noticia[0]->contenido;?></textarea>
  </div>
  <div class="d-flex justify-content-center my-4">
    <a href="#" class="btn btn_corporativo btn-flat font-weight-bold text-center" id = "submit_crear">
      <?php 
        if( !isset( $noticia )):
          echo 'Guardar noticia';
        else: 
          echo 'Actualizar noticia';
        endif;
      ?>
    </a>
  </div>
  <?php 
    echo form_close(); 
  ?>
  <script>

  $( document ).ready( function(){

		if( document.getElementById("submit_crear") ){

			document.getElementById("submit_crear").onclick = function() {

				document.getElementById("crear_form").submit();

			}
    }
    
    $(function () {
      var editor = CKEDITOR.replace('contenido', {
        height: 350,
      });
    });

	});
</script>
</div>