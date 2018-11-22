<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Api extends CI_Controller {



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

		$this->load->library('Pdf');

		$this->load->helper('lgpdf');

		//$this->check_db();

	}



	public function index(){

		echo "11";

	}

	public function fingerprint($action){

		if ($action == 'fregister') {
			$datas['user_id']=$this->input->post('user_id', TRUE);
			$datas['data']=$this->input->post('data', TRUE);
			$msg = $this->save($datas);
			echo json_encode($msg);
			return;
		}elseif($action == 'fverify') {
			$datas['code']=$this->input->post('code', TRUE);
			if($pvv_id = $this->getPvv($datas)){
				$finger = $this->Mapi->getFinger($pvv_id);
				if(isset($finger['finger_data'])){
					echo json_encode(array('success'=>true, 'user_id'=>$pvv_id, 'data'=>$finger['finger_data']));
					return;
				}
				echo json_encode(array('success'=>false, 'error'=>'Ce PVV n\'est pas enregistr&eacute;'));
				return;
			}
			echo json_encode(array('success'=>false, 'error'=>'Aucun PVV ne correspond &agrave; ce code'));
			return;
		}elseif($action == 'get_user') {
			$datas['code']=$this->input->post('code', TRUE);
			if($pvv_id = $this->getPvv($datas)){
				echo json_encode(array('success'=>true, 'user_id'=>$pvv_id));
				return;
			}
			echo json_encode(array('success'=>false, 'error'=>'Aucun PVV ne correspond'));
			return;
		}

	}


	private function save($datas){

		if (!empty($datas) && !$this->fingerCheck($datas)) {
			extract($datas);
			$ins = $this->db->insert('finger_data',array('user_id' => $user_id, 'finger_data' => $data));
			if ($ins) {
				$res['result'] = true;	
				$msg='Enregsitrement reussi';			
			} else {
				$res['success'] = false;
				$res['error'] = "Erreur lors de la sauvegarde!";
				$msg='Erreur lors de la sauvegarde!';			
			}
		} else {
			$res['success'] = false;
			$res['error'] = "Ce template existe.";
			$msg='Ce template existe.';			
		}
		return $res;

	}


	private function fingerCheck($datas){

		if (!empty($datas)) {
			extract($datas);
			if($uid = $this->Mapi->checkFingerExist($data)){
				return $uid;
			}else{
				return false;
			}
		}
		return false;

	}

	private function getPvv($datas){

		if (!empty($datas)) {
			extract($datas);
			$pvv = $this->landella_helper->get_single_pvv_by_code($code);
			if(isset($pvv['id'])){	
				return $pvv['id'];
			}else{
				return false;
			}
		}

	}


}

