<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadisticas extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
		$this->load->database();
		$this->load->library(['ion_auth', 'form_validation', 'session']);
		$this->load->model(array('estadisticas_model'));


    $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

	}

	public function index()
  {
    if( !$this->ion_auth->logged_in() ){
   
      redirect('login', 'refresh');

    }

		$this->title['title'] = "Panel de estadísticas";
		
		$data['visitas_noticias'] = $this->estadisticas_model->getVisitasNoticias();
		$data['count_noticias']   = $this->estadisticas_model->countNoticias();
		$data['count_usuarios']   = $this->estadisticas_model->countUsuarios();

    $this->load->view('templates/header', $this->title);
    $this->load->view('templates/nav');
    $this->load->view('estadisticas/panel_estadisticas', $data );
    $this->load->view('templates/footer');
  }

	
	public function getDatosGraficaAjax(){

    if(!$this->input->is_ajax_request()){

        show_404();

    } else {

        $this->get_datos_grafica(array('foo' => 'bar'));

    }
  }

  private function get_datos_grafica( $array ) {

    if (!is_array($array)) return false;

    $send = array("token" => $this->security->get_csrf_hash()) + $array;

    if (!headers_sent()) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . date('r'));
        header('Content-type: application/json');
    }

    $change = $this->estadisticas_model->getDatosGrafica( $_POST );
    
		exit( json_encode( $change ));
		
	}

	public function getDatosGraficaVisitantesAjax(){

    if(!$this->input->is_ajax_request()){

        show_404();

    } else {

        $this->get_datos_grafica_visitantes(array('foo' => 'bar'));

    }
  }

  private function get_datos_grafica_visitantes( $array ) {

    if (!is_array($array)) return false;

    $send = array("token" => $this->security->get_csrf_hash()) + $array;

    if (!headers_sent()) {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: ' . date('r'));
        header('Content-type: application/json');
    }

    $change = $this->estadisticas_model->getDatosGraficaVisitantes( $_POST );
    
		exit( json_encode( $change ));
		
	}
}
