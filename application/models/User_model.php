<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{

  public function getUser( $user_id ){

    $this->db->distinct();
    $this->db->select( 'users.*, users_groups.group_id as group');
    $this->db->where( 'users.id', $user_id );
    $this->db->join( 'users_groups', 'users_groups.user_id = users.id' );

    $query = $this->db->get( 'users' );

    if( $query->num_rows() > 0 ){

      return $query->result();

    } else {

      return false;

    }
  }

  public function getUsuarios() {

    $this->db->distinct();
    $this->db->select( 'users.*, users_groups.group_id as group');
    $this->db->join( 'users_groups', 'users_groups.user_id = users.id' );
    $this->db->order_by("users.id", 'desc');

    $query = $this->db->get( 'users' );

    if( $query->num_rows() > 0 ){

      return $query->result();

    } else {

      return false;

    }
  }

  
  public function deleteUsuario( $id_usuario ){

    $query_delete = $this->db->delete( 'users', array( 'id' => $id_usuario ));

    if( $query_delete ){

      $query_delete_group = $this->db->delete( 'users_groups', array( 'user_id' => $id_usuario ));

      if( $query_delete_group ){

        $this->session->set_flashdata('mensaje_correcto', 'Usuario eliminado correctamente.');

        return true;

      } else {

        $this->session->set_flashdata('mensaje_error', 'No se ha podido completar el borrado de este usuario.');

        return false;
      }

    } else {

      $this->session->set_flashdata('mensaje_error', 'No se ha podido eliminar este usuario.');

      return false;

    }
  }
  
  public function cambiarGroup( $datos ){

    $this->db->set('group_id', $datos['group']);
    $this->db->where('user_id', $datos['id']);

    $query = $this->db->update( 'users_groups' );

    if( $query ){

      $this->session->set_flashdata('mensaje_correcto', 'Rol de usuario actualizado correctamente.');

      return true;

    } else {

      $this->session->set_flashdata('mensaje_error', 'No se ha podido actualizar el rol de este usuario.');

      return false;

    }

  }

}
?>