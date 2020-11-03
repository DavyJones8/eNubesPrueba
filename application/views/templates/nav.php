
<nav class="navbar navbar-dark navbar-expand-lg navbar_corporativo">
  <a class="navbar-brand enlace_corporativo h2 m-0" href="<?php echo base_url();?>">eNubes News</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon text-white"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mr-3 d-flex align-items-center">
      <?php if( $_SESSION['group'] == 1 ): ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle h6 m-0 enlace_corporativo" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Administración</a>
        <div class="dropdown-menu text-center">
          <a class="dropdown-item txt_corporativo" href="<?php echo base_url();?>gestion_noticias">Gestión noticias</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item txt_corporativo" href="<?php echo base_url();?>gestion_usuarios">Gestión usuarios</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item txt_corporativo" href="<?php echo base_url();?>panel_estadisticas">Estadísticas</a>	
        </div>
      </li>
      <?php endif; ?>
      <li class="nav-item mx-3">
        <a class="nav-link h6 m-0 enlace_corporativo" href="<?php echo base_url() . 'crear_noticia';?>">Crear noticia</a>
      </li>
			<li class="nav-item mx-3 dropdown d-flex align-items-center justify-content-center">
        <a class="nav-link dropdown-toggle enlace_corporativo" href="#" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-2x"></i></a>
        <div class="dropdown-menu dropdown-menu-right text-center my-3" aria-labelledby="navbarDropdown">	
          <a class="dropdown-item txt_corporativo" href="<?php echo base_url() . 'mis_noticias';?>">Mis noticias</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item txt_corporativo" href="<?php echo base_url();?>panel_usuario">Mi cuenta</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="<?php echo base_url();?>logout">Cerrar sesión</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<script>
$( document ).ready( function(){
	$('.dropdown-toggle').dropdown()
});
</script>
