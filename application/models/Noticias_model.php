<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias_model extends CI_Model{

  public $table = "noticias";
  public $table_id = "id";

  public function getAllNoticias() {

    $this->db->select( 'noticias.*, users.first_name as nombre, users.last_name as apellidos' );
    $this->db->join( 'users', 'users.id = noticias.usuario' );
    $this->db->order_by("fecha", 'desc');
    $query_noticias = $this->db->get( 'noticias' );

    if( $query_noticias ){

      return $query_noticias->result();

    } else {

      return false;

    }
  }

  public function getNoticias( $offset = 0, $order = 'desc') {

    $this->db->select( 'noticias.*, users.first_name as nombre, users.last_name as apellidos' );
    $this->db->join( 'users', 'users.id = noticias.usuario' );
    $this->db->order_by("fecha", $order);
    $this->db->limit( 5 , $offset);
    $query_noticias = $this->db->get( 'noticias' );

    if( $query_noticias ){

      return $query_noticias->result();

    } else {

      return false;

    }
  }

  public function getNoticiasVip( $offset = 0, $order = 'desc' ){

    $this->db->select( 'noticias.*, users.first_name as nombre, users.last_name as apellidos' );
    $this->db->where( 'noticias.estado!=', '2' );
    $this->db->join( 'users', 'users.id = noticias.usuario' );
    $this->db->order_by("fecha", $order);
    $this->db->limit( 5 , $offset);
    $query_noticias = $this->db->get( 'noticias' );

    if( $query_noticias ){

      return $query_noticias->result();

    } else {

      return false;

    }
  }

  public function getNoticiasMember( $offset = 0, $order = 'desc' ){

    $this->db->select( 'noticias.*, users.first_name as nombre, users.last_name as apellidos' );
    $this->db->where( 'noticias.estado!=', '2' );
    $this->db->where( 'noticias.privacidad!=', '2' );
    $this->db->join( 'users', 'users.id = noticias.usuario' );
    $this->db->order_by("fecha", $order);
    $this->db->limit( 5 , $offset);
    $query_noticias = $this->db->get( 'noticias' );

    if( $query_noticias ){

      return $query_noticias->result();

    } else {

      return false;

    }
  }

  public function getNoticiasUsuario( $offset = 0, $usuario, $order = 'desc') {

    $this->db->select( 'noticias.*, users.first_name as nombre, users.last_name as apellidos' );
    $this->db->where( 'noticias.usuario', $usuario );
    $this->db->join( 'users', 'users.id = noticias.usuario' );
    $this->db->order_by("fecha", $order);
    $this->db->limit( 5 , $offset);
    $query_noticias = $this->db->get( 'noticias' );

    if( $query_noticias ){

      return $query_noticias->result();

    } else {

      return false;

    }
  }

  public function count(){
		$count = $this->db->query("SELECT $this->table_id FROM $this->table");
		return $count->num_rows();
  }

  public function count_vip(){
		$count = $this->db->query("SELECT $this->table_id FROM $this->table WHERE estado != '2'");
		return $count->num_rows();
  }

  public function count_member(){
		$count = $this->db->query("SELECT $this->table_id FROM $this->table WHERE estado != '2' AND privacidad != '2'");
		return $count->num_rows();
  }

  public function count_usuario( $usuario ){
		$count = $this->db->query("SELECT $this->table_id FROM $this->table WHERE usuario = $usuario");
		return $count->num_rows();
  }


  public function getNoticia( $id ){

    $this->db->select( 'noticias.*, noticias.id as noticia_id, users.id, users.first_name as nombre, users.last_name as apellidos' );
    $this->db->where( 'noticias.id', $id );
    $this->db->join( 'users', 'users.id = noticias.usuario' );
    $query_noticias = $this->db->get( 'noticias' );

    if( $query_noticias ){

      $datos = array(
        'id_noticia' => $id,
        'visita'     => 1,
        'id_usuario'    => $_SESSION['user_id'],
      );
  
      $this->db->insert('visitas_noticias', $datos );

      $result = $query_noticias->result();

      switch( $_SESSION['group'] ){

        case '1':
          return $result;
        break;
        case '2':

          if( $result[0]->estado != '2'  ){

            if( $_SESSION['user_id'] == $result[0]->usuario ){

              return $result;

            } else {

              return 'error';

            }

          } else {

            return $result;

          }

        break;
        case '3':

          if( $result[0]->estado != '2' && $result[0]->privacidad != '2' ){

            return $result;

          } else {

            return 'error';

          }

        break;
      }

    } else {

      return false;

    }

  }

  public function saveNoticia( $datos ){

    if( !isset($datos['privacidad']) || $datos['privacidad'] == '' ){

      $datos['privacidad'] = '1';

    }

    $datos = array(
      'titulo'     => $datos['titulo'],
      'contenido'  => $datos['contenido'],
      'usuario'    => $datos['usuario'],
      'estado'     => $datos['estado'],
      'privacidad' => $datos['privacidad']
    );

    $query = $this->db->insert('noticias', $datos );

    if( $query ){

    return true;

    } else {

    return false;

    }
  }

  public function updateNoticia( $datos ){

    if( !isset($datos['privacidad']) || $datos['privacidad'] == '' ){

      $datos['privacidad'] = '1';

    }

    $this->db->set('titulo', $datos['titulo']);
    $this->db->set('contenido', $datos['contenido']);
    $this->db->set('estado', $datos['estado']);
    $this->db->set('privacidad', $datos['privacidad']);
    $this->db->where('id', $datos['id']);

    $query = $this->db->update( 'noticias' );

    if( $query ){

      return true;

    } else {

      return false;

    }
  }

  public function deleteNoticia( $id_noticia ){

    $query_delete_visitas = $this->db->delete( 'visitas_noticias', array( 'id_noticia' => $id_noticia ));

    if( $query_delete_visitas ){

      $query_delete = $this->db->delete( 'noticias', array( 'id' => $id_noticia ));

      $this->session->set_flashdata('mensaje_correcto', 'Noticia eliminada correctamente.');

      return true;

    } else {

      $this->session->set_flashdata('mensaje_error', 'No se ha podido eliminar la noticia.');

      return false;

    }
  }
  
  public function cambiarEstado( $datos ){

    $this->db->set('estado', $datos['estado']);
    $this->db->where('id', $datos['id']);

    $query = $this->db->update( 'noticias' );

    if( $query ){

      $this->session->set_flashdata('mensaje_correcto', 'Estado de noticia actualizado correctamente.');

      return true;

    } else {

      $this->session->set_flashdata('mensaje_error', 'No se ha podido actualizar el estado de la noticia.');

      return false;

    }

  }

  public function cambiarPrivacidad( $datos ){

    $this->db->set('privacidad', $datos['privacidad']);
    $this->db->where('id', $datos['id']);

    $query = $this->db->update( 'noticias' );

    if( $query ){

      $this->session->set_flashdata('mensaje_correcto', 'Privacidad de noticia actualizada correctamente.');

      return true;

    } else {

      $this->session->set_flashdata('mensaje_error', 'No se ha podido actualizar la privacidad de la noticia.');

      return false;

    }

  }

}
?>