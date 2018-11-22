<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lgedit extends CI_Controller {

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
		$this->load->library('Pdf');
		$this->load->helper('lgpdf');
		//$this->check_db();
	}

	public function index(){
		echo "11";
	}

	public function add($t){
		$tables = $this->config->item('lgedit_tables');
		if(!isset($tables[$t])) die("table doesnt exists");
		$table = $tables[$t];
		
		$datas=$this->input->post();

		if(isset($datas['api'])){
			$datas['id'] = '';
			$datas['etat'] = 'En attente';
			if(isset($datas['api_pharmacie'])){
				$ordonnance = $this->lg->get_data('ordonnances',array('pvv' => $datas['pvv'], 'etat' => '', 'delivered' => ''),true);
				$ordonnance['prepose_pharmacie'] = $datas['prepose_pharmacie'];//$this->session->userdata('user_id');
				$prdts = json_decode($ordonnance["produits"]);
				foreach ($prdts as $prdt) {
					foreach ($prdt as $key => $value) {
						$ordonnance["produits_".$key] = $value;
					}
				}
				unset($ordonnance["produits"]);
				$datas = $ordonnance;
				//var_dump($ordonnance["produits"]); exit;
			}
		}
		//var_dump($datas); exit;
			//var_dump($datas); exit;

		$res = array();

		foreach($table['fields'] as $k => $f){
			if($f['type'] == "date"){
				$v = $datas[$k];
				$v = strtotime($v);
				$v = date('Y-m-d',$v);
				$res[$k]=$v;
			}else if($f['type'] == "list"){
				$keys = array_keys($f['values']);
				$rr = array();
				$c = count($datas[$k.'_'.$keys[0]]);
				for($i=0;$i<$c;$i++){
					$r=array();
					foreach($keys as $key){
						$r[$key]=$datas[$k.'_'.$key][$i];
					}
					$rr[]=$r;
				}		
				$v = json_encode($rr);
				$res[$k]=$v;
			}else{
				$v = isset($datas[$k]) ? $datas[$k] : '';
				if(is_array($v)){
					$v = json_encode($v);
				}
				$res[$k]=$v;
			}
		}
		$res['acheteur']=$this->lg->get_current_user_or_company_id();
		/*	
		foreach($datas as $k => &$v){
			if(is_array($v)){
				$v = json_encode($v);
			}
			if($table['fields'][$k]['type'] == "date"){
				$v = strtotime($v);
				$v = date('Y-m-d',$v);
			}	
		}
		*/
		$id = $table['id'];
		$id = isset($res[$id]) ? $res[$id] : false;

		if(isset($table['hooks']) && is_array($table['hooks'])){
			if(isset($table['hooks']['before_add'])){
				$res=call_user_func($table['hooks']['before_add'],$res);
				//print_r($res);
			}
		}

		if($t=='ordonnances') {
			$res1=$this->lg->get_data('consultation',array('id' => $res['consultation']),true);
			$res1['user'] = $res1['agent'];
			$res1['etat'] = 'done';
			$this->lg->set_data('consultation',$res['consultation'],$res1,false);
		}else{
			$return = $this->lg->set_data($t,$id,$res,false);
		}	

		if(isset($datas['api'])){
			echo (is_int($return))? 'DONE':'FAILED';
		}
		else{
			echo $return;
		}
		

		/*
		$id = $table['id'];
		if(isset($res[$id])){
			$this->db->where($id,$res[$id]);
			$this->db->where('table_name',$t);
			$old = $this->db->get('lg_datas')->row_array();
			if($old){
				$res=array_merge($old,$res);	
				$this->db->where($id,$res[$id]);
				$this->db->where('table_name',$t);
				$this->db->update('lg_datas',array('user' => $user, 'datas' => json_encode($res)));
				$this->db->insert('lg_datas_log',array('table_name' => $t, 'user' => $user , 'operation' => 'MOD', 'new_datas' => json_encode($res), 'old_datas' => json_encode($old)));
			}else{
				$this->db->insert('lg_datas',array('id' => $res[$id],'table_name'=> $t,'user' => $user,'datas' => json_encode($res), 'created' => date('Y-m-d H:i:s')));
				$this->db->insert('lg_datas_log',array('table_name' => $t, 'user' => $user , 'operation' => 'ADD', 'new_datas' => json_encode($res)));

			}
		}else{
			$this->db->insert('lg_datas',array('table_name'=> $t,'user' => $user,'datas' => json_encode($res),'created' => date('Y-m-d H:i:s')));
			$this->db->insert('lg_datas_log',array('table_name' => $t, 'user' => $user , 'operation' => 'ADD', 'new_datas' => json_encode($res)));
		}*/
	}

	public function duplicate($t){
		$user=0;
		if(isset($this->session)){
			$id = $this->session->userdata('user_id');	
			if(is_numeric($id)){
				$user=$id;
			}	
		}
		
		$tables = $this->config->item('lgedit_tables');
		if(!isset($tables[$t])) die("table doesnt exists");

		$table = $tables[$t];
		$datas=$this->input->post();
		$id = $table['id'];

		$this->db->where($id,$datas[$id]);
		$this->db->where('table_name',$t);
		$ds = $this->db->get('lg_datas')->row_array();
			
		$this->db->insert('lg_datas_log',array('table_name' => $t, 'user' => $user , 'operation' => 'ADD', 'new_datas' => json_encode($ds)));
		
		unset($ds[$id]);

		$ds['table_name']=$t;
		$this->db->insert('lg_datas',$ds);

	}

	public function mod($t){
		return;
		$tables = $this->config->item('lgedit_tables');
		if(!isset($tables[$t])) die("table doesnt exists");

		$table = $tables[$t];
		$datas=$this->input->post();
		$id = $table['id'];
		
		print_r($datas);die();
			
		$this->db->where($id,$datas[$id]);
		$this->db->where('table_name',$t);
		$this->db->update('lg_datas',array('datas' => json_encode($datas)));
	}

	public function del($t){
		$tables = $this->config->item('lgedit_tables');
		if(!isset($tables[$t])) die("table doesnt exists");

		$table = $tables[$t];
		$id=$this->input->post('id');
		
		$datas=$this->db->where($table['id'],$id);
		$this->db->where('table_name',$t);
		$old_datas = $this->db->get('lg_datas')->row_array();
		
		$datas=$this->db->where($table['id'],$id);
		$this->db->where('table_name',$t);
		$this->db->delete('lg_datas');
		
		$user=0;
		if(isset($this->session)){
			$id = $this->session->userdata('user_id');	
			if(is_numeric($id)){
				$user=$id;
			}	
		}
		$this->db->insert('lg_datas_log',array('table_name' => $t, 'user' => $user , 'operation' => 'DEL', 'old_datas' => json_encode($old_datas)));
	}
	

	public function modPage($t,$id){
		$tables = $this->config->item('lgedit_tables');
		if(!isset($tables[$t])) die("table doesnt exists");
		
		$table = $tables[$t];

		$datas['table']=$t;
		$k = $table['id'];
		$this->db->where('table_name',$t);
		$this->db->where($k,$id);
		$res=$this->db->get('lg_datas')->row_array();
		$datas['datas']=json_decode($res['datas'],true);
		$datas['id']=$id;
		$datas['referer']=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
		$this->load->view('lgedit/mod',$datas);
	}
	
	public function addPage($t,$param1=false,$value1=false){
		$tables = $this->config->item('lgedit_tables');
		if(!isset($tables[$t])) die("table doesnt exists");

		$table = $tables[$t];
		$datas['table']=$t;
		if($t=='pvv'){ $datas['title']='Inscrire un pvv'; }
		elseif($t=='societe_pharma'){ $datas['title']='Soci&eacute;t&eacute; pharmaceutique'; }
		elseif($t=='regionsante'){ $datas['title']='Centre de Distribution R&eacute;gional'; }
		elseif($t=='zonesante'){ $datas['title']='Zone sanitaire'; }
		else{ $datas['title']=$t; }
		$datas['title']=strtoupper($datas['title']);
		$datas['datas']=array();
		//$datas['type_destinataire']=$_GET['type_destinataire'];
		if($param1 && $value1){
			$params = explode('_', $param1);
			$values = explode('_', $value1);
			foreach ($params as $k => $v) {
				$v = ($v=='c') ? 'consultation' : $v;
				$datas['datas'][$v]=$values[$k];
			}
		}
		$datas['datas']['medecin']=$this->session->userdata('user_id');
		//var_dump($datas['datas']); exit;
		/*if( ($t=='ordonnance') && (!$value) ){
			$datas['pvv']=$value;
		}*/
		$datas['referer']=isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
		//var_dump($datas['datas']); exit;

		//$this->load->view('view_file');

		$this->load->view('lgedit/add',$datas);
	}

	public function checkDB(){
		return;	
		if (!$this->db->table_exists('lg_datas')){
			//echo "11";	
		}
	}

	public function createDB(){ 	
		return;
		$q = 'CREATE TABLE `lg_datas` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `user` int(11) NOT NULL,
 `table_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
 `datas` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
 `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `user` (`user`),
 KEY `table_name` (`table_name`)
) ENGINE=InnoDB AUTO_INCREMENT=739 DEFAULT CHARSET=utf8';

		$q2 = 'CREATE TABLE `lg_datas_log` (
 `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `table_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `user` int(11) NOT NULL,
 `operation` char(3) COLLATE utf8_unicode_ci NOT NULL,
 `old_datas` mediumtext COLLATE utf8_unicode_ci NOT NULL,
 `new_datas` mediumtext COLLATE utf8_unicode_ci NOT NULL,
 `date` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`),
 KEY `table_name` (`table_name`,`date`),
 KEY `date` (`date`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

		$this->db->query($q);
		$tables = $this->db->list_tables();
		foreach ($tables as $table){
			if(in_array($table,array('lg_datas'))) continue;
        	//echo $table.PHP_EOL;
			$res=$this->db->get($table)->result_array();
			foreach($res as $r){
				print_r($r);
				$datas = array(
					'table_name' => $table,
					'datas' => json_encode($r)
				);
				$this->db->insert('lg_datas',$datas);
			}
		}
		//sync ID	
	}
	public function syncIDs(){ 
		return;
		$tables = array('tarifs' => 'travaux','travaux' => 'project','projects' => 'client','clients' => false);
		$tables = array_reverse($tables);
		$nids = array(); 
		$ptable = false;
		foreach ($tables as $table => $key){
        	echo $table.PHP_EOL;
			$nids[$table]=array();

			$this->db->where('table_name',$table);
			$res=$this->db->get('lg_datas')->result_array();
			foreach($res as $r){
				$id = $r['id'];
				$datas = json_decode($r['datas'],true);
				echo "ID =>".$id.PHP_EOL;
				$nids[$table][$datas['id']]=$id;
				if($key){
					$datas[$key]=$nids[$ptable][$datas[$key]];
				}
				unset($datas['id']);
				print_r($datas);
				$this->db->where('id',$id);
				$this->db->update('lg_datas',array('datas' => json_encode($datas)));
			}
			$ptable=$table;
			//die();
		}
		//sync ID	
	}
}
