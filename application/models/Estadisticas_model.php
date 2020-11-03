<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas_model extends CI_Model{

  public function getVisitasNoticias(){

    $this->db->distinct();
    $this->db->select('noticias.*, users.first_name as nombre, users.last_name as apellidos');
    $this->db->join( 'users', 'users.id = noticias.usuario' );
    $query = $this->db->get('noticias');

    if( $query ){

      $result = $query->result();

      foreach( $result as $r ){

        $this->db->select('count(visita) as visitas');
        $this->db->where('id_noticia', $r->id );

        $query_visitas = $this->db->get('visitas_noticias');

        $r->numero_visitas = $query_visitas->result()[0]->{'visitas'};

      }

      return $query->result();


    } else {

      return false; 

    }

  }

  public function getDatosGrafica( $datos ){

    for( $x = (int)$datos['intervalo']; $x >= 0; $x-- ){
      
      $fecha_actual = date("Y-m-d");
      $fecha_actual = date("Y-m-d",strtotime($fecha_actual."- " . $x . " days"));

      $array_visitas[fechaEspCorta($fecha_actual)] = 0;

      $this->db->select( 'COUNT(id) as visitas' );
      $this->db->where( 'id_noticia', $datos['id_noticia']);
      $this->db->where( 'date(fecha)', $fecha_actual);
  
      $query = $this->db->get('visitas_noticias');

      if( $query && $query->num_rows() > 0 ){

        $result = $query->result();

        $array_visitas[fechaEspCorta($fecha_actual)] = $result[0]->visitas;

      } else {

        $array_visitas[fechaEspCorta($fecha_actual)] = 0;

      }
    }

    if( $array_visitas ){

      return $array_visitas;

    } else {

      return false; 

    }

  }

  public function getDatosGraficaVisitantes( $datos ){

    for( $x = (int)$datos['intervalo']; $x >= 0; $x-- ){
      
      $fecha_actual = date("Y-m-d");
      $fecha_actual = date("Y-m-d",strtotime($fecha_actual."- " . $x . " days"));

      $array_visitas[fechaEspCorta($fecha_actual)] = 0;

      $this->db->distinct();
      $this->db->select( 'id_usuario' );
      $this->db->where( 'id_noticia', $datos['id_noticia']);
      $this->db->where( 'date(fecha)', $fecha_actual);
  
      $query = $this->db->get('visitas_noticias');

      if( $query && $query->num_rows() > 0 ){

        $result = $query->result();

        $array_visitas[fechaEspCorta($fecha_actual)] = count($result);

      } else {

        $array_visitas[fechaEspCorta($fecha_actual)] = 0;

      }
    }

    if( $array_visitas ){

      return $array_visitas;

    } else {

      return false; 

    }

  }

  public function countNoticias(){
		$count = $this->db->query("SELECT id FROM noticias");
		return $count->num_rows();
  }

  public function countUsuarios(){
		$count = $this->db->query("SELECT id FROM users");
		return $count->num_rows();
  }
}

?>