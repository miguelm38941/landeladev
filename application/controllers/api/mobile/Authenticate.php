<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Authenticate extends CI_Controller {



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

		$this->load->model('Mapi');

		$this->load->config('lgedit');

		$this->load->helper('lgedit');

		$this->load->helper('landella_helper');

		$this->load->library('lg');

		//$this->load->library('Pdf');

		//$this->load->helper('db');

		//$this->check_db();
		
        $CI =& get_instance();
		$CI->load->model('mlg');
		//$this->load->database();

	}



	public function index(){

		echo "11";

	}


	public function inscription(){
		// Creer nouvelle consultation
		// Sets our destination URL
		$endpoint_url = base_url().'lgedit/add/pvv';

		// Creates our data array that we want to post to the endpoint
		$data_to_post = [
							'nom' => $this->input->post('nom'),
							'prenom' => $this->input->post('prenom'),
							'birthdate' => $this->input->post('birthdate'),
							'birthplace' => $this->input->post('birthplace'),
							'sexe' => $this->input->post('sexe'),
							'etatcivil' => $this->input->post('etatcivil'),
							'cnib' => $this->input->post('cnib'),
							'debut_traitement' => $this->input->post('debut_traitement'),
							'nouveau_cas' => $this->input->post('nouveau_cas'),
							'date_depistage' => $this->input->post('date_depistage'),
							'date_inscription' => $this->input->post('date_inscription'),
							'adresse' => $this->input->post('adresse'),
							'telephone' => $this->input->post('telephone'),
							'email' => $this->input->post('email'),
							'province' => $this->input->post('province'),
							'ville' => $this->input->post('ville'),
							'zonesante' => $this->input->post('zonesante'),
							'educateur' => $this->input->post('educateur'),
							'username' => $this->input->post('username'),
							'password' => $this->input->post('password'),
							'password_confirm' => $this->input->post('password_confirm')
		];

		// Sets our options array so we can assign them all at once
		$options = [
		  	CURLOPT_URL        => $endpoint_url,
			CURLOPT_POST       => true,
			CURLOPT_POSTFIELDS => $data_to_post,
		];

		// Initiates the cURL object
		$curl = curl_init();

		// Assigns our options
		curl_setopt_array($curl, $options);

		// Executes the cURL POST
		$result = curl_exec($curl);

		// Be kind, tidy up!
		curl_close($curl);

		echo json_encode($result);
	}

	public function inscription_membres(){
		// Creer nouvelle consultation
		// Sets our destination URL
		/*$endpoint_url = base_url().'lgedit/add/pvv';

		// Creates our data array that we want to post to the endpoint
		$data_to_post = [
							'nom' => $this->input->post('nom'),
							'prenom' => $this->input->post('prenom'),
							'birthdate' => $this->input->post('birthdate'),
							'birthplace' => $this->input->post('birthplace'),
							'sexe' => $this->input->post('sexe'),
							'etatcivil' => $this->input->post('etatcivil'),
							'cnib' => $this->input->post('cnib'),
							'debut_traitement' => $this->input->post('debut_traitement'),
							'nouveau_cas' => $this->input->post('nouveau_cas'),
							'date_depistage' => $this->input->post('date_depistage'),
							'date_inscription' => $this->input->post('date_inscription'),
							'adresse' => $this->input->post('adresse'),
							'telephone' => $this->input->post('telephone'),
							'email' => $this->input->post('email'),
							'province' => $this->input->post('province'),
							'ville' => $this->input->post('ville'),
							'zonesante' => $this->input->post('zonesante'),
							'educateur' => $this->input->post('educateur'),
							'username' => $this->input->post('username'),
							'password' => $this->input->post('password'),
							'password_confirm' => $this->input->post('password_confirm')
		];*/
        $identity_column = $this->config->item('identity','ion_auth');
        $email    = strtolower($this->input->post('email'));
        $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
        $password = $this->input->post('password');

        $additional_data = array(
            'first_name' => $this->input->post('prenom'),
            'last_name'  => $this->input->post('nom'),
            //'company'    => $this->input->post('company'),
            'phone'      => $this->input->post('telephone'),
        );

		$id = $this->ion_auth->register($identity, $password, $email, $additional_data, array(2));

		// Sets our options array so we can assign them all at once
		/*$options = [
		  	CURLOPT_URL        => $endpoint_url,
			CURLOPT_POST       => true,
			CURLOPT_POSTFIELDS => $data_to_post,
		];

		// Initiates the cURL object
		$curl = curl_init();

		// Assigns our options
		curl_setopt_array($curl, $options);

		// Executes the cURL POST
		$result = curl_exec($curl);

		// Be kind, tidy up!
		curl_close($curl);*/

		echo json_encode(array('result'=>'Enregistrement reussi!'));
	}

	public function get_entity($table){
		$filter = array();
        $entities = $this->lg->get_datas($table,$filter,true);
        $data = array();
        $i=0;
        foreach ($entities as $k=>$entity):
        	if(isset($entity['titre'])):
	        	$data[$i]['id'] = $entity['id'];
	        	$data[$i]['entity'] = $entity['titre'];
	        elseif(isset($entity['nom'])):
	        	$data[$i]['id'] = $entity['id'];
	        	$data[$i]['entity'] = $entity['nom'];
        	endif;
        	$i++;
        endforeach;
        header('Content-type: application/json');
        //$responseData['success'] = true;
        $responseData['wisata'] = $data;
        echo json_encode($responseData); 
	}	

}

