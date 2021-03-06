<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {

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

	private $global_access = array('pnls','admin','ministere');
	private $can_command = array('pharmacie','zonesante','regionsante');
	private $haveStock = array('pharmacie','regionsante','zonesante');
	private $time_limit_ver = '10';
	private $time_limit_reg = '15';

	function __construct(){
		parent::__construct();
		$this->load->helper('lgedit');
		$this->load->library('email');
		$this->load->library('Pdf');
		$this->load->helper('lgpdf');

		/*if(!$this->ion_auth->logged_in()){
			redirect('auth/login');			
		}*/
		/*
		$this->client_id = false;
		if($this->ion_auth->in_group('clients')){
			$id = $this->session->userdata('user_id');	
			$this->client_id = $this->mlns->get_client_from_userid($id);
			//echo $this->client_id;die();
			if(!is_numeric($this->client_id)) die('CLIENT NOT ASSIGNED');

			//redirect('clients');			
		}
		*/
		$this->syncUsers();
	}

	public function index(){
		$this->load->view('welcome');
		///redirect('backend/welcome');
	}
	
	/*function telecharger(){
		$this->load->helper('download');
		force_download(APPPATH . 'telecharger/landela_app.apk', NULL);
		//$this->load->view('welcome');
		//$data = file_get_contents(APPPATH . 'controllers/upload/project_name/bc68gdas9jfeh9yfj/'.$this->uri->segment(3)); // Read the file's contents
		//$name = $this->uri->segment(3);
		//force_download($name, $data);
	}*/


	function telecharger(){
		/*$file = base_url()."telecharger/landela_app.apk"; //not public folder
		if( file_exists($file)){
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/vnd.android.package-archive');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    ob_clean();
		    flush();
		    readfile($file);
		    exit;
		}*/

        $yourFile = APPPATH . 'telecharger/landela_app.apk';
        $file = @fopen($yourFile, "rb");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=landela_app.apk');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($yourFile));
        while (!feof($file)) {
            print(@fread($file, 1024 * 8));
            ob_flush();
            flush();
        }
	}

	function disableEditPermissionForMinistere(){
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
	}

	public function propositions(){
		$this->ion_auth->restrict_access(array('admin','pnls','ministere','medecin'));
		$uid = $this->session->userdata('user_id');	
		$filters=array();
		if($this->ion_auth->in_group(array('medecin'))){
			$filters['user']=$uid;
		}
		$datas=array();
		$datas['table']="propositions";
		$datas['title']="propositions";
		$datas['datas']=$this->lg->get_datas('propositions',$filters,true);
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => false,
				'can_delete' => false,
				'hide_columns' => array('id')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}	

	public function produits(){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'medecin',
			'societe_pharma',
			'partenaire',
			'pharmacie',
			'regionsante',
			'zonesante'
		));
		$datas=array();
		$datas['table']="produits";
		$datas['title']="Produits";
		$datas['datas']=$this->lg->get_datas('produits');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','dosage','specificite'),
				'links' => array(
					'assignment' => '/backend/produits/show'
					)
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}
	
	public function province(){
		$datas=array();
		$datas['table']="province";
		$datas['title']="Province";
		$datas['datas']=$this->lg->get_datas('province');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('lgedit/show',$datas);
	}	
	
	public function ville(){
		$datas=array();
		$datas['table']="ville";
		$datas['title']="Ville";
		$datas['datas']=$this->lg->get_datas('ville');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('lgedit/show',$datas);
	}	
	
	public function regionsante(){
		$datas=array();
		$datas['table']="regionsante";
		$datas['title']="Centre de Distribution R&eacute;gional";
		$datas['datas']=$this->lg->get_datas('regionsante');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','username','password','password_confirm','email','telephone','nom','prenom','adresse')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('lgedit/show',$datas);
	}	
	
	public function zonesante(){
		$datas=array();
		$datas['table']="zonesante";
		$datas['title']="Zone de sant&eacute;";
		$datas['datas']=$this->lg->get_datas('zonesante');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','username','password','password_confirm','adresse','email','telephone','nom','prenom')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('lgedit/show',$datas);
	}	

	public function educateur(){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'agent',
			'medecin',
			'ministere'
		));
		$datas=array();
		$datas['table']="educateur";
		$datas['title']="Educateur";
		$datas['datas']=$this->lg->get_datas('educateur');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','username','password','password_confirm','cnib')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('lgedit/show',$datas);
	}	

	public function societe_pharma(){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere'
		));
		$datas=array();
		$datas['table']="societe_pharma";
		$datas['title']="Societe Pharmacetique";
		$datas['datas']=$this->lg->get_datas('societe_pharma');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','username','password','password_confirm')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}	
	
	public function pharmacie(){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'pointfocal'
		));
		$datas=array();
		$datas['table']="pharmacie";
		$datas['title']="Pharmacies";
		$datas['datas']=$this->lg->get_datas('pharmacie');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','type','username','email','telephone','contact')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}	
	
	public function partenaire(){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere'
		));
		$datas=array();
		$datas['table']="partenaire";
		$datas['title']="Partenaires";
		$datas['datas']=$this->lg->get_datas('partenaire');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','username','password','password_confirm')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}	
	
	public function medecin(){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'pointfocal'
		));
		$datas=array();
		$datas['table']="medecin";
		$datas['title']="M&eacute;decins";
		$datas['datas']=$this->lg->get_datas('medecin');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','username','password','password_confirm','telephone')
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}	

	public function formation_sanitaire(){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere'
		));
		$datas=array();
		$datas['table']="agent";
		$datas['title']="formation sanitaire";
		$datas['datas']=$this->lg->get_datas('agent');
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => false,
				'can_delete' => false,
				'hide_columns' => array('id','adresse','type','contact','telephone','username')
				//'dbclick' => '/taaps/projects'
				);
		if(!$this->ion_auth->in_group(array('partenaire'))){
			$datas['options']['can_edit']=true;
		}
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}	

	public function mail_alertes($stockId, $send=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'societe_pharma',
			'partenaire',
			'pharmacie',
			'regionsante',
			'zonesante'
		));
		if(!strpos($stockId, '_')){
			$stock=$this->lg->get_data('stock',array('id'=>$stockId),true);
		}else{
			$st = explode('_', $stockId);
			$stock['user'] = $st['0'];
			$stock['produit'] = $st['1'];
			$stock['quantite'] = $st['2'];
			$stock['id'] = $stockId;
			//$prdt['nom'] = $st['1'];
		}
		$prdt=$this->lg->get_data('produits',array('id'=>$stock['produit']),true);
		$senderId = $this->session->userdata('user_id');
		/*if ($this->ion_auth->in_group('pnls')) {
			$senderOrganisation = 'PNLS';
		}elseif ($this->ion_auth->in_group('lmsc')) {
			$senderOrganisation = 'LMSC';
		}*/
		//var_dump($senderId); exit;
		$stockOwners = array('pharmacie','zonesante','regionsante');
		foreach ($stockOwners as $owner) {
			$organisation=$this->lg->get_data('pharmacie',array('id'=>$stock['user']),true);
			if(!empty($organisation)) continue;
		}
		$received_alertes = $this->lg->get_datas('alertes_mail',array('receiver'=>$stock['user']),true);
		//var_dump($received_alertes);
		if ($send) {
			$msg = trim($this->input->post('message'));
			$receiverId = $stock['user'];
			$organisation['email'] = 'm.miguellao@gmail.com';

			if (isset($organisation['email'])) {
				$this->email->from('arsoonic@gmail.com', 'Landela');
				$this->email->to($organisation['email']);
				$this->email->subject('Alerte stock disponible : '.$prdt['nom']);
				$this->email->message($msg);
				$this->email->send();
			}
			$res = array(
				'sender'=>$senderId, 
				'receiver'=>$stock['user'], 
				'product'=>$prdt['nom'], 
				'message'=>$msg, 
				'date'=>time()
			);
			$id='alertes_mail';
			$this->lg->set_data('alertes_mail',$id,$res,false);
			redirect('/backend/mail_alertes/'.$stockId);
		}
		
		//$alerteSenders = array('lmsc','pnls');

		foreach($received_alertes as $key=>$alerte){
			//var_dump($alerte); echo "<br><br>";

			if(isset($alerte['produit'])){
				$received_alertes[$key]['produit_nom']=$this->lg->get_data('produits',array('id'=>$alerte['product']),true);
				/*foreach ($alerteSenders as $alerteSender) {
					$received_alertes[$key]['sender_nom']=$this->lg->get_data($alerteSender,array('id'=>$senderId),true);
					if(!empty($received_alertes[$key]['sender_nom'])) continue;
				}*/
			}else{
				$received_alertes[$key]['produit_nom']='';
				//$received_alertes[$key]['sender_nom']='';
			}
		}
		$datas=array();
		$datas['table']="alertes_mail";
		$datas['title']="Alertes e-mail";
		$datas['received_alertes']=$received_alertes;
		$datas['stock']=$stock;
		$datas['nom_organisation']=$organisation['nom'];
		$datas['nom_produit']=$prdt['nom'];
		//var_dump($datas['datas']); exit;
		$datas['datas']=$this->lg->get_datas('alerte_emails');
		/*if(!$this->ion_auth->in_group(array('partenaire'))){
			$datas['options']['can_edit']=true;
		}*/
		//$datas['hooks_add']=true;
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('alertes_email',$datas);
	}	

	public function alertes($param=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'societe_pharma',
			'partenaire',
			'pharmacie',
			'regionsante',
			'zonesante'
		));
		$filters=array();
		$uid = $this->session->userdata('user_id');	
		$filters['user']=$uid;

		$ss=get_warning(false);
		//echo "<pre>"; var_dump($ss); echo "</pre>"; exit;
		//print_r($ss);	
		if ($this->ion_auth->in_group($this->global_access)) {
			if(isset($param)){
				$datas['table']="pharmacie";
				$datas['can_add']=true;
				$datas['options']=array(
						'can_edit' => true,
						'can_delete' => false,
						'hide_columns' => array('id')
						//'dbclick' => '/taaps/projects'
					);
				$datas['hooks_add']=true;
				if($param=='peremption'){
					$perimes=$this->computeProduitsPerimes($ss['perimer']);
					$datas['title']="Preposes pharmacie";
					$datas['datas']=$perimes;
					$this->load->view('alertes_generic',$datas);
					return;
				}elseif($param=='outofstock'){//var_dump($ss['produits']); exit;
					$epuises=$this->computeProduitsStockEpuise($ss['produits']);
					$datas['title']="Preposes pharmacie";
					$datas['datas']=$epuises;
					$this->load->view('alertes_epuise',$datas);
					return;
				}elseif($param=='commandesnontraitees'){//var_dump($ss['produits']); exit;
					$filters['sent']="isset";
					//$filters['received']="!isset";
					//$filters['user']=$uid;
					unset($filters['user']);
					$commandes=$this->lg->get_datas('commandes',$filters,true);
					$datas=array();
					$datas['datas']=$this->computeCommandesNonTraitees($commandes);

					$datas['title']="Alertes commandes non trait&eacute;es";
					$datas['table']="commandes";
					$datas['options']=array(
							'can_edit' => true,
							'can_copy' => false,
							'can_add' => false,
							'can_delete' => false,
							'hide_columns' => array('id','produits','created'),
							'columns' => array(
								'created' => array(
									'label' => 'Cree',
									'type' => 'text'
									)
								),
							'buttons' => array(
								'Commander' => '/backend/commandes/send'
								),/**/
							'links' => array(
								'assignment' => '/backend/commandes/show'
								)
							//'dbclick' => '/taaps/projects'
							);
					$datas['options']['buttons']=array();
					$datas['options']['columns']['sent']=array(
							'label' => 'Envoyee',
							'type' => 'text'
							);
					$datas['options']['columns']['sent']['label']="Date";

					$this->load->view('lgedit/show',$datas);
					return;
				}	
			}	
		}/**/

		$res=array();
		foreach($ss['produits'] as $r){
			$res[]=array(
					'id' => '1',
					'produit' => $r['produit'],
					'quantite' => $r['quantite'],
					'peremption' => ''
					);	
		}
		//var_dump($ss['produits']); exit;

		$datas=array();
		$datas['table']="stock";
		$datas['title']="Stock";
		$datas['datas']=$res;
		$datas['can_add']=false;
		$datas['options']=array(
				'can_edit' => false,
				'can_copy' => false,
				'can_delete' => false,
				'hide_columns' => array('id','company','peremption')
				);
//var_dump($res);exit;
		$datas2=array();
		$datas2['table']="stock";
		$datas2['title']="Stock";
		$datas2['datas']=$ss['peremption'];
		$datas2['can_add']=false;
		$datas2['options']=array(
				'can_edit' => false,
				'can_copy' => false,
				'can_delete' => false,
				'hide_columns' => array('id','company','quantite')
				);

		$datas3=array();
		$datas3['table']="stock";
		$datas3['title']="Stock";
		$datas3['datas']=$ss['perimer'];
		$datas3['can_add']=false;
		$datas3['options']=array(
				'can_edit' => false,
				'can_copy' => false,
				'can_delete' => false,
				'hide_columns' => array('id','company','quantite')
				);
			
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('alertes',array('datas' => $datas,'datas2' => $datas2,'datas3' => $datas3,'hide_alert' => true));
	}

	public function acteurs($action=false,$type=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'societe_pharma',
			'partenaire',
			'pharmacie',
			'regionsante',
			'zonesante'
		));
		$filters=array();
		$uid = $this->session->userdata('user_id');	
		$cid = $this->session->userdata('organisation');
		if(!$this->ion_auth->in_group(array('pnls','admin'))){
			//$filters['user']=$cid;
		}	
		
		$ss=$this->lg->get_datas('pharmacie',$filters,true);
//var_dump($ss); exit;
		$res=array();
		foreach($ss as $s){
			if($this->ion_auth->in_group(array('pnls','admin'))){
				$company = $this->lg->get_company($s['user']);
				@$s['company'] = $company->nom;
			}	
			//var_dump($s); echo "<br>";
			if (isset($s['peremption'])){
				if(strtotime($s['peremption']) > strtotime(date('Y-m-d H:i:s'))){
					if($s['quantite'] > 0){
						$res[]=$s;
					}
				}
			}	
		}

		if($action == "show"){
			$res=$this->lg->get_data('produits',array('id' => $id),true);
			//$res2=$this->lg->get_data('pvv',array('id' => $res['pvv']),true);
			$this->load->view('ordonnance',array('ordonnance' => $res, 'pvv' => $res2));
			return;
		}

		$datas=array();
		$datas['table']="stock";
		$datas['title']="Stock";
		$datas['datas']=$res;
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => false,
				'can_delete' => false,
				'hide_columns' => array('id'),
				'links' => array(
					'assignment' => '/backend/produits/show'
					)
				//'dbclick' => '/taaps/projects'
				);
		if(!$this->ion_auth->in_group(array('pnls','admin'))){
			$datas['options']['hide_columns'][]='company';
		}else{
			$datas['can_add']=false;
			$datas['options']['links']['send']='/backend/mail_alertes';
		}
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}	

	public function stock($action=false,$id=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'societe_pharma',
			'partenaire',
			'pharmacie',
			'regionsante',
			'zonesante'
		));
		$filters=array();
			$uid = $this->session->userdata('user_id');	
			$cid = $this->session->userdata('organisation');			

		if(!$this->ion_auth->in_group(array('pnls','admin'))){
			$filters['user'] = $cid ;
		}else{
			if($action=='filter'){$filters['user'] = $id;}
		}	
		
		$ss=$this->lg->get_datas('stock',$filters,true);

		$res=array();
		foreach($ss as $s){
			if($this->ion_auth->in_group(array('pnls','admin'))){
				$company = $this->lg->get_company($s['user']);
				@$s['company'] = $company->nom;
			}	
			//var_dump($s); echo "<br>";
			if (isset($s['peremption'])){
				if(strtotime($s['peremption']) > strtotime(date('Y-m-d H:i:s'))){
					if($s['quantite'] > 0){
						$res[]=$s;
					}
				}
			}	
		}

		if($action == "show"){
			$res=$this->lg->get_data('produits',array('id' => $id),true);
			//$res2=$this->lg->get_data('pvv',array('id' => $res['pvv']),true);
			$this->load->view('ordonnance',array('ordonnance' => $res, 'pvv' => $res2));
			return;
		}

		$datas=array();
		$datas['table']="stock";
		$datas['title']="Stock";
		$datas['datas']=$res;
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => false,
				'can_delete' => false,
				'hide_columns' => array('id'),
				'links' => array(
					'assignment' => '/backend/produits/show'
					)
				//'dbclick' => '/taaps/projects'
				);
		if(!$this->ion_auth->in_group(array('pnls','admin'))){
			$datas['options']['hide_columns'][]='company';
		}else{
			$datas['can_add']=false;
			$datas['options']['links']['send']='/backend/mail_alertes';
		}
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$datas['hooks_add']=true;
		$this->load->view('lgedit/show',$datas);
	}	

	public function consultations($action=false,$id=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'medecin',
			'agent'
		));
		$datas=array();
		$res=$this->lg->get_datas('consultation',array('etat' => 'En attente'),true);
		if($this->ion_auth->in_group(array('agent'))){
			$user_group = 'agent';
		}elseif($this->ion_auth->in_group(array('medecin'))){
			$user_group = 'medecin';
		}
		$selectedconsultList = array();
		foreach ($res as $consult) {//$this->session->userdata('user_id')
			if(isset($consult[$user_group]) && 
				$consult[$user_group]==$this->session->userdata('user_id') && 
				($consult['etat']=='En attente')
				){			
				array_push($selectedconsultList, $this->lg->get_data('pvv',array('id' => $consult["pvv"])));
			}
		}
		
		$datas['table']="pvv";
		$datas['title']="Consultations en attente";
		$datas['datas']=$selectedconsultList;
		$datas['can_add']=true;
		$datas['options']=array(
				'consultation' => true,
				'can_edit' => false,
				'can_delete' => false,
				'links' => array(
					'person' => '/backend/profile_pvv'
					),
				'columns' => array(
					'code' => array(
						'label' => 'Code',
						'type' => 'text'
						)
					),
				
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('agent'))){
			$datas['options']['hide_columns']=array('id','cnib','regionsante','zonesante','nom','prenom','telephone','adresse','username','password','password_confirm','email');
		}elseif($this->ion_auth->in_group(array('medecin'))){
			$datas['options']['hide_columns']=array('id','cnib','regionsante','zonesante','username','password','password_confirm','email');
		}
						
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('pvv/consultations',$datas);

	}	
	
	public function ordonnances($action=false,$id=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'medecin',
			'pharmacie',
			'pvv'
		));
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

		if($action == "receive"){
			$datas = $this->lg->get_data('ordonnances',array('id' => $id),true);
			$this->lg->set_data('ordonnances',$id,array('etat' => 'Livree'),false);
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
					'created' => array(
						'label'  => 'Cr&eacute;e le',
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

	public function commandes($action=false,$id=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'societe_pharma',
			'partenaire',
			'pharmacie',
			'regionsante',
			'zonesante'
		));
		$datas=array();

		$filters=array();
		$uid = $this->session->userdata('user_id');	
		$cid = $this->session->userdata('organisation');	
		if($action == "add_societe_pharma"){
			$id = $this->input->post('id');
			$sc = $this->input->post('societe_pharma');
			$this->lg->set_data('commandes',$id,array('societe_pharma' => $sc,'sent_societe_pharma' => date('Y-m-d H:i:s')),false);
			return;
		}
		if($action == "show"){
			$res=$this->lg->get_data('commandes',array('id' => $id));
			if($res['acheteur']==$cid){
				$res['acheteur_self'] = true;
			}
			$this->load->view('commande',array('commande' => $res));
			return;
		}
		if($action == "send"){
			if($this->lg->get_data('commandes',array('id' => $id,'sent' => '!isset'))){
				$this->lg->set_data('commandes',$id,array('sent' => date('Y-m-d H:i:s')),false);
			}
			redirect('/backend/commandes');
		}
		if($action == "deliver"){
			/*if(isset($_POST)){
				$id = $_POST['id'];
				$peremption = array_unique($_POST['peremption']);
				$quantites = $_POST['quantites'];
				$produits = $_POST['produits'];
			}
			foreach ($produits as $key => $value) {
				$prdts[$key]['produit'] = $value;
			}
			foreach ($quantites as $key => $value) {
				$prdts[$key]['quantite'] = $value;
			}
			foreach ($peremption as $key => $value) {
				$prdts[$key]['peremption'] = $value;
			}*/
			if($this->lg->get_data('commandes',array('id' => $id,'delivered' => '!isset'))){
				$datas = $this->lg->get_data('commandes',array('id' => $id));
				$datas['produits'] = json_decode($datas['produits'],true);
				//var_dump($datas['produits']); exit;
				$r=stock_decrease($cid,$datas['produits'],true);
				if($this->ion_auth->in_group(array('societe_pharma'))){
					$r=true;
				}
				if($r){
					stock_decrease($cid,$datas['produits']);
					$this->lg->set_data('commandes',$id,array('delivered' => date('Y-m-d H:i:s')),false);
				}else{
					echo "<h1>Stock non disponible</h1>";
					return;
				}
			}
			redirect('/backend/commandes/filter/waiting_for_me');
		}
		if($action == "receipt"){
			if($this->lg->get_data('commandes',array('id' => $id,'received' => '!isset'))){
				$this->lg->set_data('commandes',$id,array('received' => date('Y-m-d H:i:s')),false);
				//redirect('/backend/commandes/filter/waiting');
				$datas = $this->lg->get_data('commandes',array('id' => $id));
				$datas['produits'] = json_decode($datas['produits'],true);
				foreach($datas['produits'] as $p){
					$datas = $this->lg->set_data('stock',false,$p);
				}
				//die();
			}
			redirect('/backend/commandes/filter/waiting_by_me');
		}

		if($action == "filter"){
			if($id == "waiting_by_me"){ 
				$title="Commandes en attente";
				$filters['sent']="isset";
				$filters['received']="!isset";
				$filters['user']=$uid;
				/*if($this->ion_auth->in_group($this->global_access)){
					unset($filters['user']);
				}*/
			}
			if($id == "waiting_for_me"){
				$title="Commandes &agrave; g&eacute;rer";
				$filters['sent']="isset";
				$filters['delivered']="!isset";
				$filters['destinataire']=$cid;
				/*if($this->ion_auth->in_group($this->global_access)){
					unset($filters['destinataire']);
				}*/
			}
			if($id == "received"){
				$title="Commandes re&ccedil;ues";
				$filters['received']="isset";
				$filters['user']=$cid;
				/*if($this->ion_auth->in_group($this->global_access)){
					unset($filters['user']);
				}*/
			}
			if($id == "delivered"){
				$title="Commandes Livr&eacute;es";
				$filters['delivered']="isset";
				$filters['destinataire']=$cid;
				/*if($this->ion_auth->in_group($this->global_access)){
					unset($filters['destinataire']);
				}*/
			}
		}else{
			$title="Commandes en cours";
			$filters['sent']="!isset";
			//if(!$this->ion_auth->in_group($this->global_access)){
				$filters['user']=$uid;
			//}
		}

		$datas['table']="commandes";
		$datas['title']=$title;
		$datas['datas']=$this->lg->get_datas('commandes',$filters,true);
//var_dump($datas['datas']);exit;		
		////if($this->ion_auth->in_group(array('pharmacie'))){
		//$table1='pharmacie';
		//}elseif($this->ion_auth->in_group(array('regionsante'))){
		//	$table1='regionsante';
		//}
		
		//if(isset($table1)){
//var_dump($datas['datas']);exit;
			foreach ($datas['datas'] as $key => $value) {
				if (isset($datas['datas'][$key]['acheteur'])){ 
					$organisation=false;		
					foreach ($this->can_command as $can) {
						if(!$organisation){
							$organisation=$this->lg->get_data($can,array('id'=>$value['acheteur']),true);
							$datas['datas'][$key]['acheteur']=$organisation['nom'];
						}
					}
					
					//$pharmacie=$this->lg->get_data($table1,array('id'=>$value['acheteur']),true);	
				}
			}
		//}
/*echo '<pre>';
	var_dump($datas['datas']['1']);
echo '</pre>';
exit;*/		
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_copy' => false,
				'can_delete' => false,
				'hide_columns' => array('id','produits','acheteur'),
				'columns' => array(
					'created' => array(
						'label' => 'Cree',
						'type' => 'text'
						)
					),
				'buttons' => array(
					'Commander' => '/backend/commandes/send'
					),/**/
				'links' => array(
					'assignment' => '/backend/commandes/show'
					)
				//'dbclick' => '/taaps/projects'
				);
		if($action == "filter"){
			$datas['options']['can_edit']=false;
			$datas['options']['hide_columns'][]="created";
			if($id == "waiting_for_me"){
				/*$datas['options']['buttons']=array(
						'envoyer' => '/backend/commandes/deliver'
						);*/
				$datas['options']['hide_columns'][]="destinataire";
				$datas['options']['buttons']=array();	
				$datas['options']['hide_columns'][]="user";
				$datas['options']['columns']['sent']=array(
						'label' => 'Effectu&eacute;e le',
						'type' => 'text'
						);
				$datas['options']['columns']['user']=array(
						'label' => 'Demandeur',
						'type' => 'select',
						'values' => 'get_all_destinataires_commandes'
						);
			}
			if($id == "waiting_by_me"){
				$datas['options']['hide_columns'][]="acheteur";
				$datas['options']['buttons']=array(
						'receptionner' => '/backend/commandes/receipt'
						);
				$datas['options']['columns']['sent']=array(
						'label' => 'Envoyee',
						'type' => 'text'
						);
				$datas['options']['columns']['sent']['label']="Date";
			}
			if($id == "delivered"){
				$datas['options']['hide_columns'][]="destinataire";
				$datas['options']['buttons']=array();
				$datas['options']['columns']['sent']=array(
						'label' => 'Effectu&eacute;e le',
						'type' => 'text'
						);
				$datas['options']['columns']['delivered']=array(
						'label' => 'Livr&eacute;e le',
						'type' => 'text'
						);
			}
			if($id == "received"){
				$datas['options']['hide_columns'][]="acheteur";
				$datas['options']['buttons']=array();
				$datas['options']['columns']['sent']=array(
						'label' => 'Effectu&eacute;e le',
						'type' => 'text'
						);
				$datas['options']['columns']['received']=array(
						'label' => 'Re&ccedil;ue le',
						'type' => 'text'
						);
			}
		}

		//var_dump($datas['datas']);exit;
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('lgedit/show',$datas);
	}	

	public function suivicommandes($action=false,$id=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere'
		));
		$datas=array();
		$filters=array();
		$uid = $this->session->userdata('user_id');	
		$cid = $this->session->userdata('organisation');	
		if($action == "add_societe_pharma"){
			$id = $this->input->post('id');
			$sc = $this->input->post('societe_pharma');
			$this->lg->set_data('commandes',$id,array('societe_pharma' => $sc,'sent_societe_pharma' => date('Y-m-d H:i:s')),false);
			return;
		}
		if($action == "show"){
			$res=$this->lg->get_data('commandes',array('id' => $id));
			if($res['acheteur']==$cid){
				$res['acheteur_self'] = true;
			}
			$this->load->view('commande',array('commande' => $res));
			return;
		}
		if($action == "send"){
			if($this->lg->get_data('commandes',array('id' => $id,'sent' => '!isset'))){
				$this->lg->set_data('commandes',$id,array('sent' => date('Y-m-d H:i:s')),false);
			}
			redirect('/backend/commandes');
		}
		if($action == "deliver"){
			/*if(isset($_POST)){
				$id = $_POST['id'];
				$peremption = array_unique($_POST['peremption']);
				$quantites = $_POST['quantites'];
				$produits = $_POST['produits'];
			}
			foreach ($produits as $key => $value) {
				$prdts[$key]['produit'] = $value;
			}
			foreach ($quantites as $key => $value) {
				$prdts[$key]['quantite'] = $value;
			}
			foreach ($peremption as $key => $value) {
				$prdts[$key]['peremption'] = $value;
			}*/
			if($this->lg->get_data('commandes',array('id' => $id,'delivered' => '!isset'))){
				$datas = $this->lg->get_data('commandes',array('id' => $id));
				$datas['produits'] = json_decode($datas['produits'],true);
				//var_dump($datas['produits']); exit;
				$r=stock_decrease($cid,$datas['produits'],true);
				if($this->ion_auth->in_group(array('societe_pharma'))){
					$r=true;
				}
				if($r){
					stock_decrease($cid,$datas['produits']);
					$this->lg->set_data('commandes',$id,array('delivered' => date('Y-m-d H:i:s')),false);
				}else{
					echo "<h1>Stock non disponible</h1>";
					return;
				}
			}
			redirect('/backend/commandes/filter/waiting_for_me');
		}
		if($action == "receipt"){
			if($this->lg->get_data('commandes',array('id' => $id,'received' => '!isset'))){
				$this->lg->set_data('commandes',$id,array('received' => date('Y-m-d H:i:s')),false);
				//redirect('/backend/commandes/filter/waiting');
				$datas = $this->lg->get_data('commandes',array('id' => $id));
				$datas['produits'] = json_decode($datas['produits'],true);
				foreach($datas['produits'] as $p){
					$datas = $this->lg->set_data('stock',false,$p);
				}
				//die();
			}
			redirect('/backend/commandes/filter/waiting_by_me');
		}

		if($action == "filter"){
			if($id == "waiting_by_me"){ 
				$title="Commandes en attente";
				$filters['sent']="isset";
				$filters['received']="!isset";
				$filters['user']=$uid;
				if($this->ion_auth->in_group($this->global_access)){
					unset($filters['user']);
				}
			}
			if($id == "waiting_for_me"){
				$title="Commandes &agrave; g&eacute;rer";
				$filters['sent']="isset";
				$filters['delivered']="!isset";
				$filters['destinataire']=$cid;
				if($this->ion_auth->in_group($this->global_access)){
					unset($filters['destinataire']);
				}
			}
			if($id == "received"){
				$title="Commandes re&ccedil;ues";
				$filters['received']="isset";
				$filters['user']=$cid;
				if($this->ion_auth->in_group($this->global_access)){
					unset($filters['user']);
				}
			}
			if($id == "delivered"){
				$title="Commandes Livr&eacute;es";
				$filters['delivered']="isset";
				$filters['destinataire']=$cid;
				if($this->ion_auth->in_group($this->global_access)){
					unset($filters['destinataire']);
				}
			}
		}else{
			$title="Commandes en cours";
			$filters['sent']="!isset";
			if(!$this->ion_auth->in_group($this->global_access)){
				$filters['user']=$uid;
			}
		}

		$datas['table']="commandes";
		$datas['title']=$title;
		$datas['datas']=$this->lg->get_datas('commandes',$filters,true);
//var_dump($datas['datas']);exit;		
		////if($this->ion_auth->in_group(array('pharmacie'))){
		//$table1='pharmacie';
		//}elseif($this->ion_auth->in_group(array('regionsante'))){
		//	$table1='regionsante';
		//}
		
		//if(isset($table1)){
//var_dump($datas['datas']);exit;
			foreach ($datas['datas'] as $key => $value) {
				if (isset($datas['datas'][$key]['acheteur'])){ 
					$organisation=false;		
					foreach ($this->can_command as $can) {
						if(!$organisation){
							$organisation=$this->lg->get_data($can,array('id'=>$value['acheteur']),true);
							$datas['datas'][$key]['acheteur']=$organisation['nom'];
						}
					}
					
					//$pharmacie=$this->lg->get_data($table1,array('id'=>$value['acheteur']),true);	
				}
			}
		//}
/*echo '<pre>';
	var_dump($datas['datas']['1']);
echo '</pre>';
exit;*/		
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_copy' => false,
				'can_delete' => false,
				'hide_columns' => array('id','produits'),
				'columns' => array(
					'created' => array(
						'label' => 'Cree',
						'type' => 'text'
						)
					),
				'buttons' => array(
					'Commander' => '/backend/commandes/send'
					),/**/
				'links' => array(
					'assignment' => '/backend/commandes/show'
					)
				//'dbclick' => '/taaps/projects'
				);

		if($action == "filter"){
			$datas['options']['can_edit']=false;
			$datas['options']['hide_columns'][]="created";
			if($id == "waiting_for_me"){
				/*$datas['options']['buttons']=array(
						'envoyer' => '/backend/commandes/deliver'
						);*/
				if(!$this->ion_auth->in_group($this->global_access)){
					$datas['options']['hide_columns'][]="destinataire";
				}
				$datas['options']['buttons']=array();	
				$datas['options']['hide_columns'][]="user";
				$datas['options']['columns']['sent']=array(
						'label' => 'Effectu&eacute;e le',
						'type' => 'text'
						);
				$datas['options']['columns']['user']=array(
						'label' => 'Demandeur',
						'type' => 'select',
						'values' => 'get_all_destinataires_commandes'
						);
			}
			if($id == "waiting_by_me"){
				if(!$this->ion_auth->in_group($this->global_access)){
					$datas['options']['hide_columns'][]="acheteur";
				}
				if(!$this->ion_auth->in_group($this->global_access)){
					$datas['options']['buttons']=array(
						'receptionner' => '/backend/commandes/receipt'
						);
				}else{
					$datas['options']['buttons']=array();
				}
				$datas['options']['columns']['sent']=array(
						'label' => 'Envoyee',
						'type' => 'text'
						);
				$datas['options']['columns']['sent']['label']="Date";
			}
			if($id == "delivered"){
				if(!$this->ion_auth->in_group($this->global_access)){
					$datas['options']['hide_columns'][]="destinataire";
				}
				$datas['options']['buttons']=array();
				$datas['options']['columns']['sent']=array(
						'label' => 'Effectu&eacute;e le',
						'type' => 'text'
						);
				$datas['options']['columns']['delivered']=array(
						'label' => 'Livr&eacute;e le',
						'type' => 'text'
						);
			}
			if($id == "received"){
				if(!$this->ion_auth->in_group($this->global_access)){
					$datas['options']['hide_columns'][]="acheteur";
				}
				$datas['options']['buttons']=array();
				$datas['options']['columns']['sent']=array(
						'label' => 'Effectu&eacute;e le',
						'type' => 'text'
						);
				$datas['options']['columns']['received']=array(
						'label' => 'Re&ccedil;ue le',
						'type' => 'text'
						);
			}
		}
		
		if($this->ion_auth->in_group($this->global_access)){
			$datas['options']['can_edit']=false;
			$datas['can_add']=false;
		}

		//var_dump($datas['datas']);exit;
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('lgedit/show',$datas);
	}	

	public function profile_pvv($id=false, $param1=false,$id_consultation=false){
		$this->ion_auth->restrict_access(array(
			'admin',
			'pnls',
			'ministere',
			'agent',
			'medecin',
			'pvv'
		));
		$id2=$this->input->post('search');
		if($id == false && $id2 == false){
			$this->load->view("pvv/search");
			return;
		}

		if($id2){
			//$id = $ids2;
			$res=$this->lg->get_data('pvv',array('code' => $id2),true);
			$id=$res['id'];
			redirect('/backend/profile_pvv/'.$id.'/'.strtolower($id2));
		}else{ 
			$res=$this->lg->get_data('pvv',array('id' => $id));
		}

		$obs=$this->lg->get_datas('observations',array('pvv' => $id),true);

		$consult=$this->lg->get_data('consultation',array('pvv' => $id, 'etat' => 'En attente'));
		//var_dump($consult); exit;
		//if($this->session->userdata('user_id')=$consult['medecin']){

		/************************************************/
		/** FINGERPRINT SCANNING ***/

		$finger = $this->getUserFinger($res['username']);

		$filters=array('pvv' => $res['id']);

		$datas=array();
		$datas['table']="ordonnances";
		$datas['datas']=$this->lg->get_datas('ordonnances',$filters,true);
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => false,
				'can_copy' => false,
				'can_delete' => false,
				'hide_columns' => array('pvv','produits','commentaires','consultation','etat'),
				'columns' => array(
					'id' => array(
						'label'  => 'Ordonnance N&deg;',
						'type' => 'text'
					),
					'created' => array(
						'label'  => 'Cr&eacute;e le',
						'type' => 'text'
					),
					'delivered' => array(
						'label' => 'Livr&eacute;e le',
						'type' => 'text'
						)
					),
				'buttons' => array(
					),
				'links' => array(
					'assignment' => '/backend/ordonnances/show'
					)
				//'dbclick' => '/taaps/projects'
					);

					if($id == false && $id2 == false){
						$this->load->view("pvv/search");
						return;
					}

		if($param1 && $param1=="qrprint"){
			generatePdf($res);
			return;
		}
		elseif($param1=="consultation"){
			if($this->ion_auth->in_group(array('medecin'))){
				$usergroup = 'medecin';
			}
			elseif($this->ion_auth->in_group(array('agent'))){
				$usergroup = 'agent';
			}
			elseif($this->ion_auth->in_group(array('lmsc'))){
				$usergroup = 'lmsc';
			}
			elseif($this->ion_auth->in_group(array('pnls'))){
				$usergroup = 'pnls';
			}
			elseif($this->ion_auth->in_group(array('ministere'))){
				$usergroup = 'ministere';
			}else{
				$usergroup = 'lmsc';
			}
			if($id_consultation){
				$consult=$this->lg->get_data('consultation',array('id'=>$id_consultation));
			}

			$this->load->view('pvv/profil',array('infos' => $res, 'latestOrdonnance' => $datas['datas'][0], 'consultation' => $consult, 'observations' => $obs, 'usergroup' => $usergroup));
			return;
		}
		//var_dump($res); exit;
		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('pvv/profil',array('infos' => $res, 'ordonnances' => $datas, 'observations' => $obs, 'finger' => $finger));

	}

	public function pvv($action=false,$id=false){
		$this->ion_auth->restrict_access(array('admin','pnls',
			'ministere','medecin','educateur'));
		$datas=array();
		$filters=array();
		if($action == "educateur"){
			$id = $this->input->post('id');
			$edu = $this->input->post('educateur');
			$this->lg->set_data('pvv',$id,array('educateur' => $edu));
			return;
		}
		if($action == "note"){
			$id = $this->input->post('id');
			$id_consultation = $this->input->post('id_consultation');
			$obs = $this->input->post('observation');

			// Set consultation to "done"
			$res1=$this->lg->get_data('consultation',array('id' => $id_consultation),true);
			$res1['user'] = $res1['agent'];
			//$res1['etat'] = 'done';
			$this->lg->set_data('consultation',$id_consultation,$res1,false);
			
			// Save observations
			$this->lg->set_data('observations',false,array('pvv' => $id,'consultation' => $id_consultation,'observation' => $obs));
			redirect('/backend/profile_pvv/'.$id.'/consultation');
		}
		if($action == "validate"){
			if($this->lg->get_data('pvv',array('id' => $id,'validate' => '!isset'))){
				$edu='';
				if($this->ion_auth->in_group(array('educateur'))){
					$edu = $this->session->userdata('user_id');	
				}
				$this->lg->set_data('pvv',$id,array('validate' => date('Y-m-d H:i:s'),'educateur'=>$edu),false);
			}
			redirect('/backend/pvv/filter/tovalidate');
			//return;
		}
		if($action == "filter"){
			if($id == "tovalidate"){
				$filters['educateur']="tocheck";
			}
		}else{
			if($this->ion_auth->in_group(array('educateur'))){
				$uid = $this->session->userdata('user_id');	
				$filters['educateur']=$uid;
			}
			if($this->ion_auth->in_group(array('medecin'))){
				/*$uid = $this->session->userdata('user_id');	
				$res=$this->lg->get_datas('ordonnances',array('user' => $uid),true);
				$ids=array();
				foreach($res as $r){
					if(isset($r['pvv'])) $ids[] = $r['pvv'];
				}
				$filters['code']=$ids;*/
				//array_unique(array)
			}
		}

		$datas['table']="pvv";
		$datas['title']="pvv";
		$datas['datas']=$this->lg->get_datas('pvv',$filters,true);
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','nom','prenom','cnib','username','password','password_confirm','email','adresse','telephone'),
				'links' => array(
					'person' => '/backend/profile_pvv'
					),
				'columns' => array(
					'code' => array(
						'label' => 'Code',
						'type' => 'text'
						)
					)
				//'dbclick' => '/taaps/projects'
				);
		if($this->ion_auth->in_group(array('educateur'))){
			array_push($datas['options']['hide_columns'], 'educateur');
		}
		/*if($action == "ordonnances"){
			$datas['table']="ordonnances";
			$datas['title']="Ordonnances";
			$datas['options']['btn_ordonnances']=true;
			$datas['datas']=$this->lg->get_datas('ordonnances',$filters,true);
			//var_dump($datas['datas']); exit;
			//redirect('/backend/pvv');
			$this->load->view('pvv/ordonnances', $datas);
			//return;
		}*/
		if($action == "filter"){
			if($id == "tovalidate"){
				$datas['options']['can_edit']=false;
				$datas['options']['buttons']=array(
						'valider' => '/backend/pvv/validate'
						);
			}
		}
		if($this->ion_auth->in_group(array('medecin'))){
			//$datas['options']['btn_ordonnances']=true;
			$datas['options']['can_edit']=false;
		}

		if($this->ion_auth->in_group(array('ministere'))){
			$datas['can_add']=false;
			$datas['options']['can_edit']=false;
			$datas['options']['can_delete']=false;
		}
		$this->load->view('lgedit/show',$datas);
	}

	public function mypvv_listing($action=false,$id=false){
		$this->ion_auth->restrict_access(array('educateur'));
		$datas=array();
		$filters=array();
		if($action == "educateur"){
			$id = $this->input->post('id');
			$edu = $this->input->post('educateur');
			$this->lg->set_data('pvv',$id,array('educateur' => $edu));
			return;
		}
		if($action == "note"){
			$id = $this->input->post('id');
			$id_consultation = $this->input->post('id_consultation');
			$obs = $this->input->post('observation');

			// Set consultation to "done"
			$res1=$this->lg->get_data('consultation',array('id' => $id_consultation),true);
			$res1['user'] = $res1['agent'];
			$res1['etat'] = 'done';
			$this->lg->set_data('consultation',$id_consultation,$res1,false);
			
			// Save observations
			$this->lg->set_data('observations',false,array('pvv' => $id,'consultation' => $id_consultation,'observation' => $obs));
			redirect('/backend/profile_pvv/'.$id.'/consultation');
		}
		if($action == "validate"){
			if($this->lg->get_data('pvv',array('id' => $id,'validate' => '!isset'))){
				$edu='';
				if($this->ion_auth->in_group(array('educateur'))){
					$edu = $this->session->userdata('user_id');	
				}
				$this->lg->set_data('pvv',$id,array('validate' => date('Y-m-d H:i:s'),'educateur'=>$edu),false);
			}
			redirect('/backend/pvv/filter/tovalidate');
			//return;
		}
		$uid = $this->session->userdata('user_id');	
		$filters['educateur']=$uid;
		$datas['table']="pvv";
		$datas['title']="pvv";
		$datas['datas']=$this->lg->get_datas('pvv',$filters,true);
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','nom','prenom','cnib'),
				'links' => array(
					'person' => '/backend/profile_pvv'
					),
				'columns' => array(
					'code' => array(
						'label' => 'Code',
						'type' => 'text'
						)
					)
				//'dbclick' => '/taaps/projects'
				);
		/*if($action == "ordonnances"){
			$datas['table']="ordonnances";
			$datas['title']="Ordonnances";
			$datas['options']['btn_ordonnances']=true;
			$datas['datas']=$this->lg->get_datas('ordonnances',$filters,true);
			//var_dump($datas['datas']); exit;
			//redirect('/backend/pvv');
			$this->load->view('pvv/ordonnances', $datas);
			//return;
		}*/
		if($action == "filter"){
			if($id == "tovalidate"){
				$datas['options']['can_edit']=false;
				$datas['options']['buttons']=array(
						'valider' => '/backend/pvv/validate'
						);
			}
		}
		if($this->ion_auth->in_group(array('medecin'))){
			//$datas['options']['btn_ordonnances']=true;
			$datas['options']['can_edit']=false;
		}

		$this->load->view('lgedit/show',$datas);
	}

	public function diffusions($action=false,$id=false){
		$this->ion_auth->restrict_access(array('admin','pnls',
			'ministere','pvv','educateur'));
		$datas=array();
		$filters=array();
		if($action == "educateur"){
			$id = $this->input->post('id');
			$edu = $this->input->post('educateur');
			$this->lg->set_data('pvv',$id,array('educateur' => $edu));
			return;
		}
		if($action == "show"){
			$res=$this->lg->get_data('diffusions',array('id' => $id),true);
			//$res2=$this->lg->get_data('pvv',array('id' => $res['pvv']),true);
			$this->load->view('diffusion',array('diffusion' => $res));
			return;
		}
		if($action == "validate"){
			if($this->lg->get_data('diffusions',array('id' => $id,'visible' => '!isset'))){
				/*$edu='';
				if($this->ion_auth->in_group(array('educateur'))){
					$edu = $this->session->userdata('user_id');	
				}*/
				$this->lg->set_data('diffusions',$id,array('visible' => 'true'),false);
			}
			//redirect('/backend/pvv/filter/tovalidate');
			//return;
		}
		if($this->ion_auth->in_group(array('admin'))){
			$diffusions = $this->lg->get_datas('diffusions',array(),true);
		}else{
			$diffusions = $this->lg->get_datas('diffusions',array('visible'=>'true'),true);
		}
		
		foreach ($diffusions as $key=>$diffusion) {
			//$diffusion["exerp"]  = substr ($diffusion["message"], 0, 150);
			$diffusions[$key]["message"] = substr ($diffusion["message"], 0, 150);;
		}
		$datas['table']="diffusions";
		$datas['title']="Informations";
		$datas['datas']=$diffusions;
		//
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => false,
				'can_delete' => false,
				'hide_columns' => array('id','code'),
				'links' => array(
					'assignment' => '/backend/diffusions/show/'
					),
				'columns' => array(
					'code' => array(
						'label' => 'Code',
						'type' => 'text'
						)
					)
				//'dbclick' => '/taaps/projects'
				);

		if($action == "filter"){
			if($id == "tovalidate"){
				$datas['options']['can_edit']=false;
				$datas['options']['buttons']=array(
						'valider' => '/backend/pvv/validate'
						);
			}
		}
		if($this->ion_auth->in_group(array('lmsc','admin','pnls'))){
			//$datas['options']['btn_ordonnances']=true;
			$datas['options']['can_delete']=false;
			$datas['options']['can_edit']=true;
			$datas['options']['btn_validate_diffusion']=true;
		}

		$this->load->view('lgedit/show',$datas);
	}

	public function questions($action=false,$id=false){
		$this->ion_auth->restrict_access(array('admin','pnls',
			'ministere','pvv','educateur','medecin'));
		$datas=array();
		$filters=array();
		if($action == "educateur"){
			$id = $this->input->post('id');
			$edu = $this->input->post('educateur');
			$this->lg->set_data('pvv',$id,array('educateur' => $edu));
			return;
		}
		if($action == "show"){
			$res=$this->lg->get_data('questions',array('id' => $id),true);
			//$res2=$this->lg->get_data('pvv',array('id' => $res['pvv']),true);
			$this->load->view('question',array('question' => $res));
			return;
		}
		if($action == "validate"){
			if($this->lg->get_data('questions',array('id' => $id,'visible' => '!isset'))){
				/*$edu='';
				if($this->ion_auth->in_group(array('educateur'))){
					$edu = $this->session->userdata('user_id');	
				}*/
				$this->lg->set_data('questions',$id,array('visible' => 'true'),false);
			}
			//redirect('/backend/pvv/filter/tovalidate');
			//return;
		}
			$questions = $this->lg->get_datas('questions',array(),true);
		/*if($this->ion_auth->in_group(array('admin'))){
		}else{
			$questions = $this->lg->get_datas('questions',array('visible'=>'true'),true);
		}*/
		
		foreach ($questions as $key=>$question) {
			//$question["exerp"]  = substr ($question["message"], 0, 150);
			$questions[$key]["message"] = substr ($question["message"], 0, 150);;
		}
		$datas['table']="questions";
		$datas['title']="Questions";
		$datas['datas']=$questions;
		//
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => false,
				'can_delete' => false,
				'hide_columns' => array('id','code'),
				'links' => array(
					'assignment' => '/backend/questions/show/'
					),
				'columns' => array(
					'code' => array(
						'label' => 'Code',
						'type' => 'text'
						)
					)
				//'dbclick' => '/taaps/projects'
				);

		if($action == "filter"){
			if($id == "tovalidate"){
				$datas['options']['can_edit']=false;
				$datas['options']['buttons']=array(
						'valider' => '/backend/pvv/validate'
						);
			}
		}
		if($this->ion_auth->in_group(array('lmsc','admin','pnls'))){
			//$datas['options']['btn_ordonnances']=true;
			$datas['options']['can_delete']=false;
			$datas['options']['can_edit']=true;
			$datas['options']['btn_validate_diffusion']=true;
		}

		$this->load->view('lgedit/show',$datas);
	}

	public function fingerprint($action, $user_id=false){
		/*$this->ion_auth->restrict_access(array('admin','pnls',
			'ministere','medecin','agent','pharmacie'));*/
		$datas=array();
		/*$filters=array('id' => $id);
		$pvv=$this->lg->get_datas('pvv',$filters,true);
		var_dump($pvv);exit;
		$user=$this->lg->get_user_by_username($username);
		$user_id = $id;*/

		if($action=='fregister'){
			//$user_id = $_GET['user']; 
$ins0 = $this->db->insert('finger_finger',array('user_id' => '11000', 'finger_id' => '111200' , 'finger_data' => "$user_id;SecurityKey;".$this->time_limit_reg.";".base_url()."backend/fingerprint/fprocess_register;".base_url()."backend/fingerprint/getac"));
			/***********************************
			/** FINGERPRINT REGISTRATION */
			/** YOUR CODE HERE */
			/************************************/
			$enrollment_params = "$user_id;SecurityKey;".$this->time_limit_reg.";".base_url()."backend/fingerprint/fprocess_register;".base_url()."backend/fingerprint/getac";
			$datas['datas']=$enrollment_params;
		/*$device = $this->getDeviceBySn('C700F002328');
var_dump($device); exit;*/
			echo $enrollment_params; exit;
		}
		elseif($action=='fprocess_register'){
			/***********************************
			/** IDENTITY VERIFICATION */
			/** YOUR CODE HERE */
			/************************************/

			if (isset($_POST['RegTemp']) && !empty($_POST['RegTemp'])) {
				$this->process_register($_POST['RegTemp']);
			}
			exit;
		}
		elseif($action=='fverify'){
			/***********************************
			/** IDENTITY VERIFICATION */
			/** YOUR CODE HERE */
			/************************************/
			$finger = $this->getUserFingerByUserId($user_id);
			//var_dump($finger); exit;
			$verify_params = "$user_id;".$finger['finger_data'].";SecurityKey;".$this->time_limit_ver.";".base_url()."backend/fingerprint/fprocess_verification;".base_url()."backend/fingerprint/getac".";extraParams";
			$datas['datas']=$verify_params;
		}
		elseif($action=='fprocess_verification'){
			/***********************************
			/** IDENTITY VERIFICATION */
			/** YOUR CODE HERE */
			/************************************/
			if (isset($_POST['VerPas']) && !empty($_POST['VerPas'])) {
				$this->process_verification($_POST['VerPas']);
			}
		}
		elseif($action=='messages'){
			if (isset($_GET['msg']) && !empty($_GET['msg'])) {
				
				echo $_GET['msg'];

			} elseif (isset($_GET['user_name']) && !empty($_GET['user_name']) && isset($_GET['time']) && !empty($_GET['time'])) {
				
				$user_name	= $_GET['user_name'];
				$time		= date('Y-m-d H:i:s', strtotime($_GET['time']));
				
				echo $user_name." login success on ".date('Y-m-d H:i:s', strtotime($time));
				
			} else {
					
				$msg = "Parameter invalid..";
				
				echo "$msg";
				
			}
			exit;
		}
		elseif($action=='getac'){
			if (isset($_GET['vc']) && !empty($_GET['vc'])) {
				$data = $this->getDeviceByAcSn($_GET['vc']);
				echo $data['ac'].$data['sn'];
			}
			exit;
		}
		elseif($action=='checkreg'){
			$pvvid = $_GET['user_id'];
			$count = $this->lg->count_finger($pvvid); 
			
			if (intval($count) > intval($_GET['current'])) {
				$res['result'] = true;			
				$res['current'] = intval($count);			
			}
			else
			{
				$res['result'] = false;
			}
			echo json_encode($res);
			exit;
		} else {
			echo "Parameter invalid..";
			exit;
		}


		$datas['table']="pvv";
		$datas['title']="pvv";
		$datas['can_add']=true;
		$datas['options']=array(
				'can_edit' => true,
				'can_delete' => false,
				'hide_columns' => array('id','nom','prenom','cnib','username','password','password_confirm'),
				'links' => array(
					'person' => '/backend/profile_pvv'
					),
				'columns' => array(
					'code' => array(
						'label' => 'Code',
						'type' => 'text'
						)
					)
				//'dbclick' => '/taaps/projects'
				);

		$this->load->view($action,$datas);
	}

	public function process_register($RegTemp){
//$ins0 = $this->db->insert('finger_finger',array('user_id' => '1111', 'finger_id' => '1112' , 'finger_data' => $regTemp));

//echo 'THIS IS RegTemp '.$RegTemp;		
		
		$data 		= explode(";",$RegTemp);
		$vStamp 	= $data[0];
		$sn 		= $data[1];
		$user_id	= $data[2];
		$regTemp 	= $data[3];
		/*$vStamp 	= 'NXC1CDE9D676FDD97E033B7ND0BC39DBADED8DD08340A18793CC5E72rereereeQZ00E028603132';//$data[0];
		$sn 		= 'QZ00E028603';//$data[1];
		$user_id	= '132';//$data[2];
		$regTemp 	= 'rereeree';//$data[3];
		
		$vStamp = md5($vStamp);*/
		$device = $this->getDeviceBySn($sn);

		//$salt = md5($device['ac'].$device['vkey'].$regTemp.$sn.$user_id);
		$salt = md5($device['ac'].$device['vkey'].$regTemp.$sn.$user_id);
//echo $vStamp.'<br>'.$salt; exit;	
		if (strtoupper($vStamp) == strtoupper($salt)) {		

			$maxfinger = $this->lg->get_max_finger($user_id);
			$fid 		= $maxfinger['finger_id'];
			
			if ($fid == 0) {

				$ins = $this->db->insert('finger_finger',array('user_id' => $user_id, 'finger_id' => $fid+1 , 'finger_data' => $regTemp));
			
				if ($ins) {
					$res['result'] = true;	
					$msg='Enregsitrement reussi';			
				} else {
					$res['server'] = "Erreur lors de la sauvegarde!";
					$msg='Erreur lors de la sauvegarde!';			
				}
			} else {
				$res['result'] = false;
				$res['user_finger_'.$user_id] = "Ce template existe.";
				$msg='Ce template existe.';			
			}
			
			echo $msg;
			//redirect(base_url()."backend/fingerprint/messages?msg=$msg");
			
		} else {
			
			$msg = "Parameter invalid..";
			
			//echo base_url()."backend/fingerprint/messages?msg=$msg";
			echo $msg;
			//redirect(base_url()."backend/fingerprint/messages?msg=$msg");
		}

	}

	public function process_verification($VerPas){
		
		$data 		= explode(";",$VerPas);
		$user_id	= $data[0];
		$vStamp 	= $data[1];
		$time 		= $data[2];
		$sn 		= $data[3];
		
		$fingerData = $this->getUserFingerByUserId($user_id);
		$device 	= $this->getDeviceBySn($sn);
		
		//$this->db->where('user_id',$user_id);
		//$old = $this->db->get('lg_datas')->row_array();

		$pvv = $this->lg->get_data('pvv',array('id' => $user_id),true);
		$user_name	= $pvv['username'];
			
		$salt = md5($sn.$fingerData['finger_data'].$device['vc'].$time.$user_id.$device['vkey']);
		
		if (strtoupper($vStamp) == strtoupper($salt)) {
			
			$log = $this->createLog($user_name, $time, $sn);
			
			if ($log == 1) {
			
				echo $msg;
				//redirect(base_url()."backend/fingerprint/messages?user_name=$user_name&time=$time");
				//echo $base_path."backend/fingerprint/messages?";
			
			} else {
			
				echo $msg;
				//redirect(base_url()."backend/fingerprint/messages?msg=$log");
				//echo $base_path."backend/fingerprint/messages?msg=$log";
				
			}
		
		} else {
			
			$msg = "Parameter invalid..";
			
			echo $msg;
			//redirect(base_url()."backend/fingerprint/messages?msg=$msg");
			//echo $base_path."backend/fingerprint/messages?msg=$msg";
			
		}

	}

	public function test(){
		//echo 2;
		//$res=get_group_users('educateur');
		//print_r($res);
		//$datas=array();
		$res = get_destinataires_commandes(true);
		//$res=hook_before_add_pvv($datas);
		var_dump($res);
		/*	
			$id=32;
			$uid=11;
			$datas = $this->lg->get_data('ordonnances',array('id' => $id),true);
			$datas['produits'] = json_decode($datas['produits'],true);
			stock_decrease($uid,$datas['produits']);
		 */
	}	

	function syncUsers(){
		$users = array(
				'societe_pharma' => 16,
				'agent' => 10,
				'medecin' => 9,
				'partenaire' => 6,
				'pharmacie' => 8,
				'educateur' => 11,
				'regionsante' => 14,
				'zonesante' => 15,
				);

		$filters = array(
				'auth_user' => '!isset'
				);

		foreach($users as $table => $group){
			$datas=$this->lg->get_datas($table,$filters,true);
			foreach($datas as $data){
				$identity=$data['username'];
				$email=isset($data['email']) ? $data['email'] : "";
				$additional_data=array();
				$groups = array($group); 
				if($id=$this->ion_auth->register($identity, '12345678', $email, $additional_data,$groups)){
					$this->lg->set_data($table,$data['id'],array('auth_user' => $id));
				}
			}
		}
	}

	function computeProduitsPerimes($prdts_perimer){
		$perim_array = array();
		foreach ($prdts_perimer as $perim) {
			array_push($perim_array, $perim['user']);
		} 
		$perim_array = array_unique($perim_array);
		$perimPharmacies = array();
		foreach ($perim_array as $pharmaId) {
			$res=$this->lg->get_data('pharmacie',array('id' => $pharmaId),true);
			//if(!empty($res)) array_push($perimPharmacies, $res);
			//var_dump($ss['perimer']);exit;
			foreach ($prdts_perimer as $perim) {//
				if ($perim['user']==$pharmaId){
					//echo $perim['user'].'=='.$pharmaId.'<br>';
					$perimes['pharmacie'] =  $res;
					$perimes['produit'] = $this->lg->get_data('produits',array('id' => $perim['produit']),true);
					$perimes['quantite'] =  $perim['quantite'];
					$perimes['peremption'] =  isset($perim['peremption'])? $perim['peremption']:'';
					array_push($perimPharmacies, $perimes);
				}
			} 
		}//var_dump($perimPharmacies);exit;
		return $perimPharmacies;
	}

	function computeProduitsStockEpuise($prdt_epuises){
		//var_dump($prdt_epuises); exit;
		$perimPharmacies = array();
		foreach ($prdt_epuises as $k =>$epuise) { 
			/*echo $epuise['pharmacie']; echo "<br>";
			var_dump($this->haveStock); exit;*/
			foreach ($this->haveStock as $table) {
				$prdts_epuises[$k]['organisation'] = $this->lg->get_data($table,array('id' => $epuise['pharmacie']),true);
				if($prdts_epuises[$k]['organisation']['nom']) break;
			}
			//$prdts_epuises[$k]['pharmacie'] = $this->lg->get_data('pharmacie',array('id' => $epuise['pharmacie']),true);
			$prdts_epuises[$k]['produit'] = $this->lg->get_data('produits',array('id' => $epuise['produit']),true);
			$prdts_epuises[$k]['stock'] = $this->lg->get_data('stock',array('produit' => $epuise['produit']),true);
		} //echo '<pre>'; var_dump($prdts_epuises); echo '</pre>'; exit;
		return isset($prdts_epuises)?$prdts_epuises:array();
	}

	function computeCommandesNonTraitees($commandes){
		//var_dump($prdt_epuises); exit;
		$commandesNonTraitees = array();
		foreach ($commandes as $commande) {
			//var_dump($commande['acheteur']); echo "<br><br>";
			if ((time()-(60*60*24*3)) > strtotime($commande['sent'])) {
				foreach ($this->can_command as $actor) {
					if (isset($commande['acheteur'])) {
						$acheteur=$this->lg->get_data($actor,array('id' => $commande['acheteur']),true);
						if(!empty($acheteur)){
							$commande['acheteur'] = $acheteur['nom'];
						}
					}
				}
				array_push($commandesNonTraitees, $commande);
			}
		}
		return isset($commandesNonTraitees)?$commandesNonTraitees:array();
	}

	function exportPdf($module, $id){

		$datas=array();
		$filters=array();
		$uid = $this->session->userdata('user_id');	
		$cid = $this->session->userdata('organisation');	
		if($module == "commande"){
			$res=$this->lg->get_data('commandes',array('id' => $id));
			if($res['acheteur']==$cid){
				$res['acheteur_self'] = true;
			}
			$acheteur = $this->lg->get_company($res['acheteur']); 
			$destinataire = $this->lg->get_company($res['destinataire']); 

			//$prods = get_produits();
			//generateCommandePdf($res, $acheteur, $destinataire, $prods);
			//return;
			$this->load->view('pdf_template_commande',array('commande' => $res));
			return;
		}

	}

	/*function getCompany($id){
		$CI =& get_instance();
		$companies = array('societe_pharma','pharmacie','regionsante','zonesante','partenaire','agent');
		foreach ($companies as $company) {
			$datas=$CI->lg->get_datas($company,array('id'=>$id));
			if(!empty($datas)) return $datas[0]['nom'];
		}
	}*/

	function getUserFinger($username) {
		//$pvv = $this->lg->get_data('pvv',array('code' => $id2),true);
		//$user = $this->lg->get_user($user_id);
		$finger = $this->lg->get_finger($username);

		//var_dump($finger); exit;
		/*while($row = mysqli_fetch_array($result)) {

			$arr[$i] = array(
				'user_id'	=>$row['user_id'],
				"finger_id"	=>$row['finger_id'],
				"finger_data"	=>$row['finger_data']
				);
			$i++;

		}*/

		return $finger;

	}
	
	function getUserFingerByUserId($pvv_id) {
		
		$pvv = $this->lg->get_data('pvv',array('id' => $pvv_id),true);
	
		$finger = $this->lg->get_finger($pvv['username']);

		/*while($row = mysqli_fetch_array($result)) {

			$arr[$i] = array(
				'user_id'	=>$row['user_id'],
				"finger_id"	=>$row['finger_id'],
				"finger_data"	=>$row['finger_data']
				);
			$i++;

		}*/

		return $finger;

	}
	
	function getDeviceByAcSn($vc) {

		$device = $this->lg->get_device(array('vc'=>$vc));
		return $device;

	}
	
	function getDeviceBySn($sn) {

		$device = $this->lg->get_device(array('sn'=>$sn));
		return $device;

	}
	
	function createLog($user_name, $time, $sn) {
		global $conn;
		
		$ins = $this->db->insert('demo_log',array('user_name' => $user_name, 'data' => date('Y-m-d H:i:s', strtotime($time))." (PC Time) | ".$sn." (SN)"));
		if ($ins) {
			return 1;				
		} else {
			return "Error insert log data!";
		}
		
	}

}




