<?php 

class User extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation', 'session']);
		$this->load->helper(['url', 'language','form']);
		$this->load->model(array('user_model'));


    $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

    if( !$this->ion_auth->logged_in() ){
   
      redirect('auth/login', 'refresh');

    }
  }

  public function index()
  {
    if( !$this->ion_auth->logged_in() ){
   
      redirect('login', 'refresh');

    }

    $user_id = (int)$_SESSION['user_id'];

    $this->data['user'] = $this->user_model->getUser( $user_id );
    $this->title['title'] = "Panel de usuario";
    $this->load->view('templates/header', $this->title);
    $this->load->view('templates/nav');
    $this->load->view('user/user_panel', $this->data );
    $this->load->view('templates/footer');
  }

  public function gestion_usuarios(){

		if($this->ion_auth->logged_in()){

			if($this->ion_auth->in_group('admin')){

				$data['usuarios'] = $this->user_model->getUsuarios();

				$this->title['title'] = "Gestión usuarios";
				$this->load->view('templates/header', $this->title);
				$this->load->view('templates/nav');
				$this->load->view('user/gestion_usuarios', $data );
        $this->load->view('templates/footer');

			} else {

				redirect('/', 'refresh');

			}


		} else {

			redirect('login', 'refresh');

		}

	}

  public function updateUser( $id = false ){

    if( !$this->ion_auth->logged_in() ){
   
      redirect('login', 'refresh');

    }

    if( $id ){
      
      $user = $this->ion_auth->user($id)->row();
    
      if( $_SESSION['user_id'] != $user->id ){ redirect('login', 'refresh'); }

      $this->form_validation->set_rules('first_name', 'nombre', 'trim|required');
      $this->form_validation->set_rules('last_name', '/ los apellidos', 'trim|required');

      if (isset($_POST) && !empty($_POST))
      {
        if ($this->form_validation->run() === TRUE)
        {
          $data = [
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
          ];

          if ($this->ion_auth->update($user->id, $data))
          {
    
            $this->session->set_flashdata('mensaje_correcto', 'Datos de usuario actualizados correctamente');
        
            redirect('panel_usuario', 'refresh');

          }
          else
          {

            $this->session->set_flashdata('mensaje_error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
      
            redirect('panel_usuario', 'refresh');

          }
        }

        $this->session->set_flashdata('mensaje_error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));

      }

      redirect('panel_usuario', 'refresh');

    } else {

      $this->session->set_flashdata('mensaje_error', 'Ha ocurrido un error al actualizar el usuario' );
      redirect('panel_usuario', 'refresh');

    }
  }

  public function updateEmail( $id = false ){

    if( !$this->ion_auth->logged_in() ){
   
      redirect('login', 'refresh');

    }

    if( $id ){

      $user = $this->ion_auth->user($id)->row();
    
      if( $_SESSION['user_id'] != $user->id ){ redirect('login', 'refresh'); }
  
      $tables = $this->config->item('tables', 'ion_auth');
  
      $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
  
      if (isset($_POST) && !empty($_POST))
      {
        if ($this->form_validation->run() === TRUE)
        {
          $data = [
            'email' => $this->input->post('email'),
          ];
  
          if ($this->ion_auth->update($user->id, $data))
          {
    
            $this->session->set_flashdata('mensaje_correcto', 'Email actualizado correctamente');
        
            redirect('panel_usuario', 'refresh');
  
          }
          else
          {
  
            $this->session->set_flashdata('mensaje_error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
      
            redirect('panel_usuario', 'refresh');
  
          }
        }
  
        $this->session->set_flashdata('mensaje_error', (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message'))));
  
      }
  
      redirect('panel_usuario', 'refresh');

    } else {

      $this->session->set_flashdata('mensaje_error', 'Ha ocurrido un error al actualizar el email');
      redirect('panel_usuario', 'refresh');

    }
  }

  public function updatePassword( $id = false ){

    if( !$this->ion_auth->logged_in() ){
    
      redirect('login', 'refresh');

    }

    if( $id ){

      $user = $this->ion_auth->user( $id )->row();

      if( $_SESSION['user_id'] != $user->id ){ redirect('login', 'refresh'); }
  
      $this->form_validation->set_rules('old', 'contraseña antigua', 'required');
      $this->form_validation->set_rules('new', 'contraseña nueva', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
      $this->form_validation->set_rules('new_confirm', 'confirmar contraseña', 'required');
      
  
      if ($this->form_validation->run() === FALSE)
      {
  
        $this->session->set_flashdata('message_password_error', (validation_errors()) ? validation_errors() : $this->session->flashdata('message') );
  
        redirect('panel_usuario/#password', 'refresh');
        
      }
      else
      {
        $identity = $this->session->userdata('identity');
  
        $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
  
        if ($change)
        {
          //if the password was successfully changed
          $this->session->set_flashdata('message_password', $this->ion_auth->messages());
          
          redirect('panel_usuario/#password', 'refresh');
  
        }
        else
        {
          $this->session->set_flashdata('message_password_error', $this->ion_auth->errors());
          
          redirect('panel_usuario/#password', 'refresh');
        }
      }
    } else {

      $this->session->set_flashdata('mensaje_error', 'Ha ocurrido un error al actualizar la contraseña.');
      redirect('panel_usuario', 'refresh');

    }
  }

  public function borrarUsuarioAjax(){

    if(!$this->input->is_ajax_request()){

        show_404();

    } else {

        $this->borrar_usuario(array('foo' => 'bar'));

    }
  }

  private function borrar_usuario( $array ) {

    if (!is_array($array)) return false;

    $send = array("token" => $this->security->get_csrf_hash()) + $array;

    if (!headers_sent()) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . date('r'));
        header('Content-type: application/json');
    }

    $id_usuario = $_POST['id_usuario'];
    $delete = $this->user_model->deleteUsuario( $id_usuario );
    
		exit( json_encode( $delete ));
		
	}
	
	public function cambiarGroupAjax(){

    if(!$this->input->is_ajax_request()){

        show_404();

    } else {

        $this->cambiar_group(array('foo' => 'bar'));

    }
  }

  private function cambiar_group( $array ) {

    if (!is_array($array)) return false;

    $send = array("token" => $this->security->get_csrf_hash()) + $array;

    if (!headers_sent()) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . date('r'));
        header('Content-type: application/json');
    }

    $change = $this->user_model->cambiarGroup( $_POST );
    
		exit( json_encode( $change ));
		
	}

}

?>