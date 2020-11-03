<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticias extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation', 'session']);
		$this->load->model(array('noticias_model'));

    $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

	}

	public function index( $num_page = 1 )
	{	

		if (!$this->ion_auth->logged_in())
		{
			redirect('login', 'refresh');
		}
		else
		{

			if($this->ion_auth->in_group('admin')){
				$group = array('group' => 1);
				$num_page--;
				$num_post = $this->noticias_model->count();
				$last_page = ceil($num_post/5);
		
				if($num_page < 0){
						$num_page = 0;
				} else if($num_page > $last_page) {
						// TODO
						$num_page = 0;
				} 
				$offset = $num_page * 5;
				$this->data['noticias'] = $this->noticias_model->getNoticias( $offset );
			}elseif($this->ion_auth->in_group('vip')){
				$group = array('group' => 2);
				$num_page--;
				$num_post = $this->noticias_model->count_vip();
				$last_page = ceil($num_post/5);
		
				if($num_page < 0){
						$num_page = 0;
				} else if($num_page > $last_page) {
						// TODO
						$num_page = 0;
				} 
				$offset = $num_page * 5;
				$this->data['noticias'] = $this->noticias_model->getNoticiasVip( $offset );
			}elseif($this->ion_auth->in_group('members')){
				$num_page--;
				$num_post = $this->noticias_model->count_member();
				$last_page = ceil($num_post/5);
		
				if($num_page < 0){
						$num_page = 0;
				} else if($num_page > $last_page) {
						// TODO
						$num_page = 0;
				} 
				$offset = $num_page * 5;
				$group = array('group' => 3);
				$this->data['noticias'] = $this->noticias_model->getNoticiasMember( $offset);
			}

			$this->data['last_page'] = $last_page;
			$this->data['current_page'] = $num_page;

			$this->session->set_userdata($group);
			$this->data['message_error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->title['title'] = "Home";
			$this->load->view('templates/header', $this->title);
			$this->load->view('templates/nav');
			$this->load->view('home', $this->data);
			$this->load->view('templates/footer');
		}
	}
	
	public function noticia( $id = false ){

		if($this->ion_auth->logged_in()){

			if( $id ){

				$data['noticia'] = $this->noticias_model->getNoticia( $id );

				if( $data['noticia'] ){

					if( $data['noticia'] == 'error' ){

						$this->session->set_flashdata('mensaje_error', 'No tiene acceso a esta noticia.');
						redirect('/', 'refresh');

					}

				$data['id'] = $id;

				$this->title['title'] = "Noticia";
				$this->load->view('templates/header', $this->title);
				$this->load->view('templates/nav');
				$this->load->view('noticias/noticia', $data );
				$this->load->view('templates/footer');

				} else {

					$this->session->set_flashdata('mensaje_error', 'Ha ocurrido un error al buscar esta noticia.');
					redirect('/', 'refresh');

				}

			} else {

				$this->session->set_flashdata('mensaje_error', 'Ha ocurrido un error al buscar esta noticia.');
				redirect('/', 'refresh');

			}
		
		} else {

			redirect('login', 'refresh');

		}
		
	}

	public function mis_noticias( $num_page = 1 )
	{	

		if (!$this->ion_auth->logged_in())
		{
			redirect('login', 'refresh');
		}
		else
		{

			$usuario = $_SESSION['user_id'];

			$num_page--;
			$num_post = $this->noticias_model->count_usuario( $usuario );
			$last_page = ceil($num_post/5);
	
			if($num_page < 0){
					$num_page = 0;
			} else if($num_page > $last_page) {
					$num_page = 0;
			} 
			$offset = $num_page * 5;

			$this->data['noticias'] = $this->noticias_model->getNoticiasUsuario( $offset, $usuario );
			$this->data['last_page'] = $last_page;
			$this->data['current_page'] = $num_page;

			$this->title['title'] = "Mis noticias";
			$this->load->view('templates/header', $this->title);
			$this->load->view('templates/nav');
			$this->load->view('noticias/mis_noticias', $this->data);
			$this->load->view('templates/footer');
		}
	}

	public function gestion_noticias(){

		if($this->ion_auth->logged_in()){

			if($this->ion_auth->in_group('admin')){

				$data['noticias'] = $this->noticias_model->getAllNoticias();

				$this->title['title'] = "Gestión noticias";
				$this->load->view('templates/header', $this->title);
				$this->load->view('templates/nav');
				$this->load->view('noticias/gestion_noticias', $data );
				$this->load->view('templates/footer');

			} else {

				redirect('/', 'refresh');

			}


		} else {

			redirect('login', 'refresh');

		}

	}

	public function crear_noticia(){

		if($this->ion_auth->logged_in()){

			$this->title['title'] = "Crear noticia";
			$this->load->view('templates/header', $this->title);
			$this->load->view('templates/nav');
			$this->load->view('noticias/crear_noticia' );
			$this->load->view('templates/footer');

		} else {

			redirect('login', 'refresh');

		}
	}

	public function editar_noticia( $id = false ){

		if($this->ion_auth->logged_in()){

			if( $id ){

				$this->data['noticia'] = $this->noticias_model->getNoticia( $id );
				$this->title['title'] = "Editar noticia";
				$this->load->view('templates/header', $this->title);
				$this->load->view('templates/nav');
				$this->load->view('noticias/crear_noticia', $this->data );
				$this->load->view('templates/footer');

			} else {

				$this->session->set_flashdata('mensaje_error', 'No se ha encontrado esta noticia.');
				redirect('/', 'refresh');

			}

		} else {

			redirect('login', 'refresh');

		}
  }

  public function save(){

    if( !$this->ion_auth->logged_in() ){

      $this->session->set_flashdata('mensaje_error', 'Debe iniciar sesión para crear una noticia.');
   
      redirect('login', 'refresh');

    }

    if( !isset($_POST) && !$_POST ){

      $this->session->set_flashdata('mensaje_error', 'No se ha podido crear la entrada. Inténtalo de nuevo.');
      
      redirect('crear_noticia', 'refresh');

    }

    $id = $_SESSION['user_id'];

		$_POST['usuario'] = $id;

		if( $this->noticias_model->saveNoticia( $_POST ) ){

			$this->session->set_flashdata('mensaje_correcto', 'Noticia creada correctamente.');

		} else {

			$this->session->set_flashdata('mensaje_error', 'No se ha podido crear la noticia.');

		}

		redirect('crear_noticia', 'refresh');

	}
	
	public function update( $id = false ){

    if( !$this->ion_auth->logged_in() ){

      $this->session->set_flashdata('message_error', 'Tiene que estar logueado para poder modificar una noticia' );
   
      redirect('login', 'refresh');

    }

    if( $id ){

			if( !isset($_POST) || empty($_POST )){

				$this->session->set_flashdata('mensaje_error', 'No se ha podido modificar la noticia. Inténtelo de nuevo.');
				
				redirect('editar_noticia/'.$id, 'refresh');
	
			}
	
			$id_user = $_SESSION['user_id'];
	
			if( $_POST['usuario'] != $id_user && $_SESSION['group'] != 1 ){
	
				$this->session->set_flashdata('mensaje_error', 'No puede modificar esta noticia');
				
				redirect('/', 'refresh');
	
			}
			
			$_POST['id'] = $id;
	 
			if( $this->noticias_model->updateNoticia( $_POST ) ){
	
				$this->session->set_flashdata('mensaje_correcto', 'Noticia modificada correctamente.');
	
			} else {
	
				$this->session->set_flashdata('mensaje_error', 'No se ha podido modificar la noticia.');
				
			}

			redirect('editar_noticia/'.$id, 'refresh');

		} else {

      $this->session->set_flashdata('mensaje_error', 'No se ha encontrado esta noticia.' );
			redirect('/', 'refresh');

		}
	}

	public function borrarNoticiaAjax(){

    if(!$this->input->is_ajax_request()){

        show_404();

    } else {

        $this->borrar_noticia(array('foo' => 'bar'));

    }
  }

  private function borrar_noticia( $array ) {

    if (!is_array($array)) return false;

    $send = array("token" => $this->security->get_csrf_hash()) + $array;

    if (!headers_sent()) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . date('r'));
        header('Content-type: application/json');
    }

    $id_noticia = $_POST['id_noticia'];
    $delete = $this->noticias_model->deleteNoticia( $id_noticia );
    
		exit( json_encode( $delete ));
		
	}
	
	public function cambiarEstadoAjax(){

    if(!$this->input->is_ajax_request()){

        show_404();

    } else {

        $this->cambiar_estado(array('foo' => 'bar'));

    }
  }

  private function cambiar_estado( $array ) {

    if (!is_array($array)) return false;

    $send = array("token" => $this->security->get_csrf_hash()) + $array;

    if (!headers_sent()) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . date('r'));
        header('Content-type: application/json');
    }

    $change = $this->noticias_model->cambiarEstado( $_POST );
    
		exit( json_encode( $change ));
		
	}
	
	public function cambiarPrivacidadAjax(){

    if(!$this->input->is_ajax_request()){

        show_404();

    } else {

        $this->cambiar_privacidad(array('foo' => 'bar'));

    }
  }

  private function cambiar_privacidad( $array ) {

    if (!is_array($array)) return false;

    $send = array("token" => $this->security->get_csrf_hash()) + $array;

    if (!headers_sent()) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . date('r'));
        header('Content-type: application/json');
    }

    $change = $this->noticias_model->cambiarPrivacidad( $_POST );
    
		exit( json_encode( $change ));
		
  }
}
