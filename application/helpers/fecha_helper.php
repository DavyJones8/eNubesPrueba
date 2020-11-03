<?php 

  function fechaEspCorta( $fecha ){

    $fecha = trim(substr($fecha, 0, 20));
    $numeroDia = date('d', strtotime($fecha));
    $mes = date('m', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));

    $fecha_modificada = $numeroDia . '/' . $mes . '/' . $anio;

    return $fecha_modificada;

  }
    
  function fechaEsp( $fecha ){

    $fecha = trim(substr($fecha, 0, 20));
    $numeroDia = date('d', strtotime($fecha));
    $mes = date('m', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    $hora = date('H', strtotime($fecha));
    $minuto = date('i', strtotime($fecha));
    $segundo = date('s', strtotime($fecha));

    $fecha_modificada = $numeroDia . '/' . $mes . '/' . $anio . ' ' . $hora . ':' . $minuto . ':' . $segundo;

    return $fecha_modificada;

  }
  
?>