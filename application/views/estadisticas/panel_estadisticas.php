<div class="contenedor_scroll">
<div class="container my-3 p-3 border border-info rounded bg-white">
	<h1 class="text-center txt_corporativo">PANEL DE ESTADÍSTICAS</h1>
</div>
<div class="container mb-3 border border-info rounded">
  <div class="row bg-white p-3">
  <?php if( isset( $count_usuarios ) && $count_usuarios != ''):?>
    <div class="col-12 col-md-6 border-right">
      <div class="row">
        <div class="col-6 d-flex justify-content-center align-items-center">
          <h4 class="txt_corporativo">Nº de usuarios</h4>
        </div>
        <div class="col-6 d-flex justify-content-center align-items-center">
          <h1 class="txt_corporativo_secundario"><?php echo $count_usuarios?></h1>
        </div>
      </div>
    </div>
  <?php endif;?>
  <?php if( isset( $count_noticias ) && $count_noticias != ''):?>
    <div class="col-12 col-md-6 border-left">
      <div class="row">
        <div class="col-6 d-flex justify-content-center align-items-center">
          <h4 class="txt_corporativo">Nº de noticias</h4>
        </div>
        <div class="col-6 d-flex justify-content-center align-items-center">
          <h1 class="txt_corporativo_secundario"><?php echo $count_noticias?></h1>
        </div>
      </div>
    </div>
  <?php endif;?>
  </div>
</div>
<div class="container mb-3 border border-info rounded bg-white p-3">
  <h4 class="txt_corporativo text-center">Visitas por noticia</h4>
  <hr>
  <?php if( isset( $visitas_noticias ) && $visitas_noticias ):?>
  <table class="table table-responsive-lg  table-hover table-striped">
    <thead class="text-center">
      <th>Id</th>
      <th>Título</th>
      <th>Usuario</th>
      <th>Nº visitas</th>
      <th>Acciones</th>
    </thead>
    <tbody class="text-center">
      <?php foreach( $visitas_noticias as $v ): ?>
        <tr>
          <td><?php echo $v->id; ?></td>
          <td title="<?php echo $v->titulo;?>"><?php echo character_limiter( $v->titulo, 30 ); ?></td>
          <td title="<?php echo $v->nombre . ' ' . $v->apellidos, 30;?>"><?php echo character_limiter($v->nombre . ' ' . $v->apellidos, 30); ?></td>
          <td><?php echo $v->numero_visitas ?></td>
          <td>
            <a class="btn btn_corporativo" href="<?php echo base_url() . 'noticia/' . $v->id;?>" title="Ir a noticia"><i class="fas fa-eye"></i></a>
            <a href="#" class="btn btn_corporativo_azul grafica" data-id="<?php echo $v->id;?>"><i class="fas fa-chart-area" title="Gráfica de visitas"></i></a>
            <a href="#" class="btn btn-success grafica_visitantes" data-id="<?php echo $v->id;?>" title="Gráfica de visitantes"><i class="fas fa-chart-bar"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="container mt-2" id="grafico_div" style="display: none;">
    <h4 id="titulo_grafica"></h4>
    <div class="row d-flex justify-content-between">
      <div class="col-12 col-md-6 col-lg-8">
        <h6 id="ultimos"></h6>
      </div>
      <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-end">
        <select class="custom-select group" id="select_grafica" style="display: none;">
          <option value="30">Últimos 30 días</option>
          <option value="15">Últimos 15 días</option>
          <option value="7">Últimos 7 días</option>
        </select> 
        <select class="custom-select group" id="select_grafica_visitantes" style="display: none;">
          <option value="30">Últimos 30 días</option>
          <option value="15">Últimos 15 días</option>
          <option value="7">Últimos 7 días</option>
        </select> 
      </div>
    </div>
    <div id="graph" style="height: 500px;"></div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script> 
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

      $(".grafica").click( function(){

        id_noticia = $(this).data('id');
        intervalo = 30;

        $("#graph").empty();
        $("#titulo_grafica").empty();
        $("#ultimos").empty();
        $("#select_grafica_visitantes").hide();

        getDatosGrafica( id_noticia, intervalo );

      });

      $("#select_grafica").on( 'change', function() {

        id_noticia = $(this).data('id');
        intervalo = parseInt($(this).val());

        $("#graph").empty();
        $("#titulo_grafica").empty();
        $("#ultimos").empty();

        getDatosGrafica( id_noticia, intervalo );

      });

      function getDatosGrafica( $id_noticia, intervalo ){

        $.ajaxSetup({data: {token: CFG.token}});
    
        $(document).ajaxSuccess(function(e,x) {
          var result = $.parseJSON(x.responseText);
          $('input:hidden[name="token"]').val(result.token);
          $.ajaxSetup({data: {token: result.token}});
        });
        
        $.ajax({

          method: "POST",
          url: CFG.url + 'estadisticas/getDatosGraficaAjax',
          data: { 
                  id_noticia : id_noticia,
                  intervalo : intervalo
                }
          
        }).done(function( data ) {

          if( data != 'false' ){

            var morrisData = [];

            var ultimos = -1;

            $.each(data, function(key, val){

              morrisData.push({'fecha': key, 'visitas' : val}); 

              ultimos++;

            });

            $("#grafico_div").fadeIn();
            $("#titulo_grafica").html('Gráfica de visitas de la noticia nº: ' + id_noticia);
            $("#ultimos").html('Últimos ' + ultimos + ' días');
            $("#select_grafica").data('id', id_noticia );
            $("#select_grafica").show();

            $('html,body').animate({
              scrollTop: $("#grafico_div").offset().top},
            500);

            var grafico = Morris.Area({
              element: 'graph',
              data: morrisData,
              xkey: 'fecha',
              ykeys: ['visitas'],
              labels: ['Visitas'],
              parseTime: false,
              lineColors: ['rgba(27,171,227)'],
              pointFillColors: ['#3d3d3d'],
              resize: true,
            });
          }
        });
      }

      $(".grafica_visitantes").click( function(){

        id_noticia = $(this).data('id');
        intervalo = 30;

        $("#graph").empty();
        $("#titulo_grafica").empty();
        $("#ultimos").empty();
        $("#select_grafica").hide();

        getDatosGraficaVisitantes( id_noticia, intervalo );

      });

      $("#select_grafica_visitantes").on( 'change', function() {

        id_noticia = $(this).data('id');
        intervalo = parseInt($(this).val());

        $("#graph").empty();
        $("#titulo_grafica").empty();
        $("#ultimos").empty();

        getDatosGraficaVisitantes( id_noticia, intervalo );

      });

      function getDatosGraficaVisitantes( $id_noticia, intervalo ){

        $.ajaxSetup({data: {token: CFG.token}});
    
        $(document).ajaxSuccess(function(e,x) {
          var result = $.parseJSON(x.responseText);
          $('input:hidden[name="token"]').val(result.token);
          $.ajaxSetup({data: {token: result.token}});
        });
        
        $.ajax({

          method: "POST",
          url: CFG.url + 'estadisticas/getDatosGraficaVisitantesAjax',
          data: { 
                  id_noticia : id_noticia,
                  intervalo : intervalo
                }
          
        }).done(function( data ) {

          if( data != 'false' ){

            var morrisData = [];

            var ultimos = -1;

            $.each(data, function(key, val){

              morrisData.push({'fecha': key, 'visitas' : val}); 

              ultimos++;

            });

            $("#grafico_div").fadeIn();
            $("#titulo_grafica").html('Gráfica de visitantes de la noticia nº: ' + id_noticia);
            $("#ultimos").html('Últimos ' + ultimos + ' días');
            $("#select_grafica_visitantes").data('id', id_noticia );
            $("#select_grafica_visitantes").show();

            $('html,body').animate({
              scrollTop: $("#grafico_div").offset().top},
            500);

            var grafico = Morris.Bar({
              element: 'graph',
              data: morrisData,
              xkey: 'fecha',
              ykeys: ['visitas'],
              labels: ['Visitantes'],
              parseTime: false,
              barColors: ['#28a745'],
              resize: true,
            });
          }
        });
      }
    });
  </script>
  <?php endif;?>
</div>
</div>