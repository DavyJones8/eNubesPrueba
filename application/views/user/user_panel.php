<div class="contenedor_scroll">
<body class="">
	<div class="panel">
		<div class="container mt-3">
			<?php
				if( $this->session->flashdata('mensaje_error')): ?>
				<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
					<?php echo $this->session->flashdata('mensaje_error');?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php endif;
				if( $this->session->flashdata('mensaje_correcto')): ?>
				<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
					<?php echo $this->session->flashdata('mensaje_correcto');?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?php endif; ?>
		</div>
		<div class="container my-3">
			<div class="datos">
			<?php 
				foreach( $user as $dato ):
			?>
				<div class="container my-3 p-3 border border-info rounded bg-white">
					<h1 class="text-center txt_corporativo">DATOS DE USUARIO</h1>
				</div>
				<div class="container bg-white border border-info rounded">
					<?php 
						$attributes = ['id' => 'updateUser'];
						echo form_open('user/updateUser/' . $dato->id, $attributes);
					?>
					<ul class="list-group list-group-flush">
						<li class="list-group-item font-weight-bold">
							<div class="row">
								<div class="col-12 col-md-6 d-flex align-items-center">
									<span>Nombre: </span>
								</div>
								<div class="col-12 col-md-6">
									<div class="input-group">
										<input type="text" name="first_name" class="form-control" aria-label="Nombre" aria-describedby="basic-addon1" value="<?php echo $dato->first_name; ?>">
									</div>
								</div>
							</div>
						</li>
						<li class="list-group-item font-weight-bold">
							<div class="row">
								<div class="col-12 col-md-6 d-flex align-items-center">
									<span>Apellidos: </span>
								</div>
								<div class="col-12 col-md-6">
									<div class="input-group">
										<input type="text" name="last_name" class="form-control" aria-label="Apellidos" aria-describedby="basic-addon1" value="<?php echo $dato->last_name; ?>">
									</div>
								</div>
							</div>
						</li>
					</ul>
					<div class="d-flex justify-content-center mt-4 pb-3">
          	<a href="#" class="btn btn_corporativo btn-flat font-weight-bold text-center" id = "submit_user">Actualizar usuario</a>
					</div>
					<?php echo form_close();?>	
				</div>
				<?php
					endforeach;
				?>
			</div>
		</div>
		<div class="container py-2">
			<hr>
		</div>
		<div class="container my-3">
			<div class="datos">
			<?php 
				foreach( $user as $dato ):
			?>
				<div class="container my-3 p-3 border border-info rounded bg-white">
					<h1 class="text-center txt_corporativo">ACTUALIZAR EMAIL</h1>
				</div>
				<div class="container bg-white  border border-info rounded">
					<?php 
						$attributes = ['id' => 'updateEmail'];
						echo form_open('user/updateEmail/' . $dato->id, $attributes);
					?>
					<ul class="list-group list-group-flush">
						<li class="list-group-item font-weight-bold">
							<div class="row">
								<div class="col-12 col-md-6 d-flex align-items-center">
									<span>Email: </span>
								</div>
								<div class="col-12 col-md-6">
									<div class="input-group">
										<input type="text" name="email" class="form-control" aria-label="Email" aria-describedby="basic-addon1" value="<?php echo $dato->email; ?>">
									</div>
								</div>
							</div>
						</li>
					</ul>
					<div class="d-flex justify-content-center mt-4 pb-3">
          	<a href="#" class="btn btn_corporativo btn-flat font-weight-bold text-center" id = "submit_email">Actualizar usuario</a>
					</div>
					<?php echo form_close();?>	
				</div>
				<?php
					endforeach;
				?>
			</div>
		</div>
		<div class="container py-2">
			<hr>
		</div>
		<?php if ($this->session->flashdata('update')) : ?>
		<div class="container">
			<div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="infoMessage">
					<?php echo $this->session->flashdata('update'); ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<?php endif; ?>
		<span id="password"></span>
		<?php if ($this->session->flashdata('message_password_error')) : ?>
		<div class="container">
			<div class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="infoMessage">
					<?php echo $this->session->flashdata('message_password_error'); ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('message_password')) : ?>
		<div class="container">
			<div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="infoMessage">
					<?php echo $this->session->flashdata('message_password'); ?>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<?php endif; ?>
		<div class="container my-3 mb-4">
			<div class="datos">
				<div class="container my-3 p-3 border border-info rounded bg-white">
					<h1 class="text-center txt_corporativo">ACTUALIZAR CONTRASEÑA</h1>
				</div>
				<div class="container bg-white  border border-info rounded">
				<?php 
					$attributes = ['id' => 'updatePassword'];
					echo form_open('user/updatePassword/' . $dato->id, $attributes);
				?>
				<ul class="list-group list-group-flush">
					<li class="list-group-item font-weight-bold">
						<div class="row">
							<div class="col-12 col-md-6 d-flex align-items-center">
								<span>Contraseña antigua: </span>
							</div>
							<div class="col-12 col-md-6">
								<div class="input-group">
									<input type="password" name="old" class="form-control" aria-label="antigua" aria-describedby="basic-addon1" autocomplete="off">
								</div>
							</div>
						</div>
					</li>
					<li class="list-group-item font-weight-bold">
						<div class="row">
							<div class="col-12 col-md-6 d-flex align-items-center">
								<span>Contraseña nueva: </span>
							</div>
							<div class="col-12 col-md-6">
								<div class="input-group">
									<input type="password" name="new" class="form-control" aria-label="nueva" aria-describedby="basic-addon1">
								</div>
							</div>
						</div>
					</li>
					<li class="list-group-item font-weight-bold">
						<div class="row">
							<div class="col-12 col-md-6 d-flex align-items-center">
								<span>Confirmar contraseña: </span>
							</div>
							<div class="col-12 col-md-6">
								<div class="input-group">
									<input type="password" name="new_confirm" class="form-control" aria-label="Confirmar" aria-describedby="basic-addon1">
								</div>
							</div>
						</div>
					</li>
				</ul>
				<div class="d-flex justify-content-center mt-4 pb-3">
					<a href="#" class="btn btn_corporativo btn-flat font-weight-bold text-center" id = "submit_password">Actualizar contraseña</a>
				</div>
				<?php echo form_close();?>	
				</div>
			</div>
		</div>
	</div>
	<script>
	document.getElementById("submit_user").onclick = function() {

    document.getElementById("updateUser").submit();

  }
  
  document.getElementById("submit_password").onclick = function() {

    document.getElementById("updatePassword").submit();

	}
	
	document.getElementById("submit_email").onclick = function() {

		document.getElementById("updateEmail").submit();

	}
	</script>
</body>

</div>