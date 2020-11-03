<html lang="Es-es">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta http-equiv="Expires" content="0">
	<meta http-equiv="Last-Modified" content="0">
	<meta http-equiv="Cache-Control" content="max-age=31536000">

	<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
	<script src="<?php echo base_url();?>assets/datatables/datatables.min.js"></script>
	<script src="<?php echo base_url();?>assets/js/font_awesome.min.js"></script>
	<link rel="shortcut icon" href="https://www.enubes.com/templates/img/favicon.ico">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/nav.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables/datatables.min.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

	<script type="text/javascript">

		var CFG = {
				url: '<?php echo $this->config->item('base_url');?>',
				token: '<?php echo $this->security->get_csrf_hash();?>'
		};

	</script>

	<title><?php if( isset($title) && $title ): echo $title; endif; ?></title>

</head>
