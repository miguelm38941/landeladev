<?php

class Mlg extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	function set_table_data_normal($table,$id,$datas,$replace=false){
		$res=false;
		if(is_numeric($id)){
			$this->db->where('id',$id);
			$res = $this->db->get($table)->row_array();
		}
		
		if($res){
			if($replace){
				$this->db->where('id',$id);
				$this->db->delete($table);
				$this->db->insert($table,$datas);
				return $this->db->insert_id();
			}else{
				$this->db->where('id',$id);
				$this->db->update($table,$datas);
			}
		}else{
			$this->db->insert($table,$datas);
			return $this->db->insert_id();
		}
						
	}
	
	function set_table_data($table,$id,$datas,$replace=false){ 
		$CI =& get_instance();
		if($this->db->table_exists($table)){
			return $this->set_table_data_normal($table,$id,$datas,$replace);
		}

		$user=0;
		if(isset($CI->session)){
			//if ($this->ion_auth->in_group(array('pharmacie'))) {
			if ($table=='stock') {
				$cid = $CI->session->userdata('organisation');
				$uid = $CI->session->userdata('user_id');
				if(is_numeric($cid)){ $user=$cid; }	
			}else{
				$uid = $CI->session->userdata('user_id');
				if(is_numeric($uid)){ $user=$uid; }	
			}		
		}
		if(isset($datas['api']) ){
			$uid=$this->get_api_user_id($datas);
			if (isset($datas['api_pharmacie'])) {
				$user = $CI->lg->get_user($uid);
				$cid = $user['company'];
				if(is_numeric($cid)){ $user=$cid; }	
				unset($datas['api_pharmacie']);
			}
			unset($datas['api']);
		}
//echo $uid; exit;
		$uid = ($uid=='') ? '2' : $uid;
		//var_dump($uid); exit;
		//var_dump($datas); exit;
		$res=false;
		if(is_numeric($id)){
			$this->db->where('id',$id);
			$this->db->where('table_name',$table);
			$res = $this->db->get('lg_datas')->row_array();
		}
		if($res && !empty($res)){
			if(!$replace){
				$old = json_decode($res['datas'],true);
				$datas=array_merge($old,$datas);
				$datas = json_encode($datas,JSON_PRETTY_PRINT);	
			}
			$this->db->where('id',$id);
			$this->db->where('table_name',$table);
			$this->db->update('lg_datas',array('datas' => $datas));
			$inserted = $this->db->insert_id();
			$this->db->insert('lg_datas_log',array('table_name' => $table, 'user' => $uid , 'operation' => 'MOD', 'new_datas' => $datas, 'old_datas' => json_encode($old)));
			return $inserted;	
		}else{
			$this->db->insert('lg_datas',array('table_name'=> $table,'user' => $user,'datas' => json_encode($datas), 'created' => date('Y-m-d H:i:s')));
			$inserted = $this->db->insert_id();
			$this->db->insert('lg_datas_log',array('table_name' => $table, 'user' => $uid , 'operation' => 'ADD', 'new_datas' => json_encode($datas), 'old_datas' => ''));
			return $inserted;	
		}
	}

	function get_table_datas($table,$filters=array(),$metadatas=false,&$exists=false){
		
		if(isset($filters['id'])){
			if(is_array($filters['id'])){ 
				$this->db->where_in('id',$filters['id']);
			}else{
				$this->db->where('id',$filters['id']);
			}
		}
		
		$ord = isset($GLOBALS['lg_order_by']) ?  $GLOBALS['lg_order_by'] : 'DESC';
		$this->db->order_by('id',$ord);
		
		if($this->db->table_exists($table)){
			$exists=true;
			foreach($filters as $k => $v){
				if(in_array($k,array('id','user'))) continue;
				$this->db->where($k,$v);
			}
			return $this->db->get($table)->result_array();
		}else{
			if(isset($filters['user'])){
				$this->db->where('user',$filters['user']);
			}
			$exists=false;
			$this->db->where('table_name',$table);
			//echo '---'.$table; var_dump($this->db->get('lg_datas')->result_array());
			return $this->db->get('lg_datas')->result_array();
		}
	}

	function get_user($id){
		$this->db->where('id',$id);
		return $this->db->get('users')->row_array();
	}

	function get_user_by_username($username){
		$this->db->where('username',$username);
		return $this->db->get('users')->row_array();
	}

	function get_users(){
		return $this->db->get('users')->result_array();
	}	

	function get_api_user_id($datas){
		if(isset($datas['agent'])){
			return $datas['agent'];
		}elseif (isset($datas['prepose_pharmacie'])) {
			return $datas['prepose_pharmacie'];
		}
	}

	function get_organisation($id){
		$this->db->where('id',$id);
		return $this->db->get('lg_datas')->row_array();
	}

	function get_device($param){
		foreach ($param as $k=>$v):
			$this->db->where($k,$v);
		endforeach;
		return $this->db->get('finger_device')->row_array();
	}

	function get_finger($userid){
		$this->db->where('user_id',$userid);
		return $this->db->get('finger_finger')->row_array();
	}

	function get_finger_count($userid){
		$this->db->where('user_id',$userid);
		return $this->db->count_all_results('finger_finger');
	}

	function get_max_finger($userid){
		$this->db->where('user_id',$userid);
		$this->db->order_by('finger_id','DESC');
		return $this->db->get('finger_finger')->row_array();
	}
}


?>
