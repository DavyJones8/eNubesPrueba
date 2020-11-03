<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Captcha extends CI_Controller
{
  function __construct() {
    parent::__construct();
    // Load the captcha helper
		$this->load->helper(['captcha']);
		$this->load->library(['session']);
  }
  
  public function index(){
    // If captcha form is submitted
    if($this->input->post('submit')){
      $inputCaptcha = $this->input->post('captcha');
      $sessCaptcha = $this->session->userdata('captchaCode');
      if($inputCaptcha === $sessCaptcha){
          echo 'Captcha code matched.';
      }else{
          echo 'Captcha code was not match, please try again.';
      }
    }
    
    // Captcha configuration
    $config = array(
        'img_path'      => 'assets/captcha_images/',
        'img_url'       => base_url().'assets/captcha_images/',
        'img_width'     => '150',
        'img_height'    => 50,
        'word_length'   => 8,
        'font_size'     => 16
    );
    $captcha = create_captcha($config);
    
    // Unset previous captcha and store new captcha word
    $this->session->unset_userdata('captchaCode');
    $this->session->set_userdata('captchaCode',$captcha['word']);
    
    // Send captcha image to view
    $data['captchaImg'] = $captcha['image'];
    
    // Load the view
    $this->load->view('captcha/index', $data);
  }
  
  public function refresh(){

    // Captcha configuration
    $config = array(
        'img_path'      => 'assets/images/captcha_images/',
        'img_url'       =>  base_url().'assets/images/captcha_images/',
        'img_width'     => '150',
        'img_height'    => 50,
        'expiration'    => 7200,
        'word_length'   => 8,
        'font_size'     => 16,
        'img_id'        => 'Imageid',
        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(27,171,227)
        )
    );
    $captcha = create_captcha($config);
    
    // Unset previous captcha and store new captcha word
    $this->session->unset_userdata('captchaCode');
    $this->session->set_userdata('captchaCode',$captcha['word']);
    
    // Display captcha image
    echo $captcha['image'];
  }
}

?>