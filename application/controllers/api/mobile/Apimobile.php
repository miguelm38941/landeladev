<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Apimobile extends CI_Controller {



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

	public function pvv_ordonnances(){

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
				$finger_data = $this->Mapi->getFinger($pvv_id);
				if($finger_data){
					echo json_encode(array('success'=>true, 'user_id'=>$pvv_id, 'data'=>$finger_data));
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
			$pvv = $this->get_single_pvv_by_code($code);
			if(isset($pvv['id'])){	
				return $pvv['id'];
			}else{
				return false;
			}
		}

	}

	private function get_single_pvv_by_code($code){
		$CI =& get_instance();
		$res=array();
		$datas=$CI->lg->get_data('pvv',array('code'=>$code),true);
		$pvv = array('id'=>$datas['id'], 'name'=>$datas['nom'] . ' ' . $datas['prenom']);
		return $pvv;
	}

	
	public function ordonnances($action=false,$id=false){

		$datas=array();
		$filters=array();
		$uid = $this->session->userdata('user_id');	
		$cid = $this->session->userdata('organisation');	

		if($action == "show"){
			$res=$this->lg->get_data('ordonnances',array('id' => $id),true);
			$res2=$this->lg->get_data('pvv',array('id' => $res['pvv']),true);
			$this->load->view('ordonnance',array('ordonnance' => $res, 'pvv' => $res2));
			return;
		}

		if($action == "search"){
			$res=$this->lg->get_data('ordonnances',array('prepose_pharmacie' => $uid),true);
			$res2=$this->lg->get_data('pvv',array('id' => $res['pvv']),true);
			$this->load->view('ordonnance',array('ordonnance' => $res, 'pvv' => $res2));
			return;
		}
//var_dump($datas);

		if($action == "deliver"){
			if($this->lg->get_data('ordonnances',array('id' => $id,'delivered' => ''))){

				$datas = $this->lg->get_data('ordonnances',array('id' => $id),true);
				$datas['produits'] = json_decode($datas['produits'],true);
				$r=stock_decrease($cid,$datas['produits'],true);

				if($r){
					stock_decrease($cid,$datas['produits']);
					$this->lg->set_data('ordonnances',$id,array('prepose_pharmacie' => $uid,'delivered' => date('Y-m-d H:i:s'), 'etat' => 'tobereceived'),false);
					//$this->lg->set_data('ordonnances',$id,array('prepose_pharmacie' => $uid,'delivered' => date('Y-m-d H:i:s'), 'etat' => 'Livree'),false);
				}else{
					redirect('/backend/ordonnances/?err=noStock');
					//echo "<h1>Stock non disponible</h1>";
					//echo "<a href='".$_SERVER['HTTP_REFERER']."'>Back</a>";
					//return;
				}
			}
			redirect('/backend/ordonnances');
		}

		if($action == "receive"){
			//if($this->lg->get_data('ordonnances',array('id' => $id,'delivered' => ''))){
			$datas = $this->lg->get_data('ordonnances',array('id' => $id),true);
			$this->lg->set_data('ordonnances',$id,array('etat' => 'Livree'),false);
			//$this->lg->set_data('ordonnances',$id,array('prepose_pharmacie' => $uid,'delivered' => date('Y-m-d H:i:s'), 'etat' => 'Livree'),false);
			//}
		}

		if($action == "pvv"){
			if(!$id){
				$code = $this->input->post('search');
				redirect('/backend/ordonnances/pvv/'.$code);
			}else{
				$filters['pvv']=$id;
			}
		}

		if($this->ion_auth->in_group(array('medecin'))){
			$filters['user']=$uid;
		}elseif($this->ion_auth->in_group(array('pvv'))){
			$username = $this->session->userdata('username');
			$pvv=$this->lg->get_data('pvv',array('username' => $username),true);
			$filters['pvv']=$pvv['id'];
		}

		$datas['table']="ordonnances";
		$datas['title']="Ordonnances";
		$datas['can_add']=false;
		$datas['options']=array(
				'can_add' => false,
				'can_edit' => false,
				'can_copy' => false,
				'can_delete' => false,
				'columns' => array(
					'initiated' => array(
						'label'  => 'Emission',
						'type' => 'text'
						),
					'closed' => array(
						'label'  => 'Validit&eacute;',
						'type' => 'text'
						),
					'num_renewed' => array(
						'label'  => 'Renouvell&eacute;',
						'type' => 'text'
						),
					'delivered' => array(
						'label' => 'Livr&eacute;e le',
						'type' => 'text'
						)
					),
				'buttons' => array(
					//'livrer' => '/backend/ordonnances/deliver'
					),
				'links' => array(
					'assignment' => '/backend/ordonnances/show'
					)
					//'dbclick' => '/taaps/projects'
					);
		//var_dump($datas['datas']);

		$datas['options']['hide_columns'] = array('id','produits','commentaires');

		if(!$this->ion_auth->in_group($this->global_access)){
			$filters['prepose_pharmacie']=$this->session->userdata('user_id');
			$datas['options']['hide_columns'] = array('id','produits','commentaires','prepose_pharmacie');
			$datas['options']['buttons']=array(
							'livrer' => '/backend/ordonnances/deliver'
						);
			//$datas['options']['buttons']=array();
			//$filters['delivered']='!isset';
		}

		
		if($this->ion_auth->in_group(array('medecin','pvv'))){
			unset($filters['prepose_pharmacie']);
		}

		$ordonnances = $this->lg->get_datas('ordonnances',$filters,true);

		foreach ($ordonnances as $k=>$ordonnance) {
			if(isset($ordonnance['prepose_pharmacie'])){
				$ordonnances[$k]['prepose_pharmacie']=$this->lg->get_user_company($ordonnance['prepose_pharmacie']);
			}
			
		}
		//echo '<pre>';
		$datas['datas']=$ordonnances;
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		if($this->ion_auth->in_group(array('pharmacie'))){
			$datas['group']='pharmacie';
		}
		elseif($this->ion_auth->in_group(array('pvv'))){
			$datas['group']='pvv';
		}
		$this->load->view('lgedit/show',$datas);
	}	

}

