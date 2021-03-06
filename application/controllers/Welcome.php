<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct(){
		parent::__construct();
		$this->load->config('lgedit');
		$this->load->helper('lgedit');
		$this->load->library('lg');
		//$this->check_db();
		if($this->ion_auth->logged_in()){
			redirect('backend');			
		}
	}

	public function index(){
		$this->load->view('home/welcome');
	}

	public function inscription(){
		$this->load->view('home/inscription');
	}

	public function thanks_registration(){
		$this->load->view('home/thanks_registration');
	}

	public function politique_confidentialite(){
		$this->load->view('home/privacy_policy');
	}	
}
