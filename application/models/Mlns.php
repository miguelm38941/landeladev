<?php

class Mlns extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function get_client_from_userid($id){
		$this->db->where('user',$id);
		$res=$this->db->get('clients')->result_array();	
		if(count($res) > 1 || count($res) == 0){
			return false;
		}
		return $res[0]['id'];
	}
	
	function get_clients(){
		return $this->db->get('clients')->result_array();
	}
	
	function get_client($id){
		$this->db->where('id',$id);
		return $this->db->get('clients')->row_array();
	}

	function get_areas($client=false){
		$this->db->select('clients.id as client_id,clients.nom as client_name, areas.*');
		$this->db->from('clients');
		$this->db->join('areas','areas.client=clients.id','right');

		if($client){
			if(is_array($client)){
				$this->db->where_in('clients.id',$client);
			}else{
				$this->db->where('clients.id',$client);
			}
		}

		$this->db->order_by('clients.id');
		$this->db->order_by('areas.code','asc');
		$res = $this->db->get()->result_array();
		return $res;
	}
	
	function get_area($id){
		$this->db->select('clients.id as client_id,clients.nom as client_name, areas.*');
		$this->db->from('clients');
		$this->db->join('areas','areas.client=clients.id','right');
		$this->db->where('areas.id',$id);
		return $this->db->get()->row_array();
	}
	
	function get_machines($area=false){
		$this->db->select('clients.id as client_id,clients.nom as client_name, areas.id as area_id, areas.nom as area_name,areas.code as area_code,machines.*');
		$this->db->from('machines');
		$this->db->join('areas','machines.area=areas.id','right');
		$this->db->join('clients','areas.client=clients.id','right');
		if($area){
			if(is_array($area)){
				$this->db->where_in('areas.id',$area);
			}else{
				$this->db->where('areas.id',$area);
			}
		}
		return $this->db->get()->result_array();
	}
	
	function get_machines_by_client($client){
		$this->db->select('clients.id as client_id,clients.nom as client_name, areas.id as area_id, areas.nom as area_name, areas.code as area_code,machines.*');
		$this->db->from('machines');
		$this->db->join('areas','machines.area=areas.id','right');
		$this->db->join('clients','areas.client=clients.id','right');
		if($client){
			if(is_array($client)){
				$this->db->where_in('clients.id',$client);
			}else{
				$this->db->where('clients.id',$client);
			}
		}
		return $this->db->get()->result_array();
	}
	
	function get_checks($machine=false){
		if($machine){
			$this->db->where('machine',$machine);
		}
		$this->db->order_by('date','DESC');
		return $this->db->get('checks')->result_array();
	}
	
	function get_area_checks($area=false){

		$this->db->select('checks.*');
		$this->db->from('machines');
		$this->db->join('checks','checks.machine=machines.id');
		$this->db->where('area',$area);
		$this->db->order_by('date','DESC');
		return $this->db->get()->result_array();
	}
	
	function get_check($id=false){
		$this->db->where('id',$id);
		return $this->db->get('checks')->row_array();
	}
	
	function get_machine($id=false){
		$this->db->where('id',$id);
		return $this->db->get('machines')->row_array();
	}
	
	function get_machines_last_check($ids=false){
		$this->db->select('clients.id as client_id,clients.nom as client_name, areas.id as area_id, areas.nom as area_name, areas.code as area_code,checks.*');
		$this->db->from('checks');
		$this->db->join('machines','machines.id=checks.machine');
		$this->db->join('areas','machines.area=areas.id');
		$this->db->join('clients','areas.client=clients.id');
		$this->db->order_by('checks.date','DESC');
		$this->db->group_by('checks.machine');

		if($ids){
			$this->db->where_in('checks.machine',$ids);
		}

		return $this->db->get()->result_array();
	}

	function get_machine_last_check($machine){
		$this->db->where('machine',$machine);
		$this->db->order_by('date','DESC');
		$this->db->limit(1);
		return $this->db->get('checks')->row_array();
	}
	
	function get_client_area_name($id){
		$this->db->select('client');
		$this->db->where('id',$id);
		$res = $this->db->get('areas')->row_array();
		return $this->get_client_name($res['client']);
	}

	function get_client_name($id){
		$this->db->select('nom');
		$this->db->where('id',$id);
		$res = $this->db->get('clients')->row_array();
		return $res['nom'];
	}
	
	function get_area_name($id){
		$this->db->select('nom,code');
		$this->db->where('id',$id);
		$res = $this->db->get('areas')->row_array();
		return $res['nom']." ".$res['code'];
	}

	function convert_devis($id){
		$this->db->where('id',$id);
		$datas=$this->db->get('devis')->row_array();
		unset($datas['id']);
		$this->db->insert('factures',$datas);
		$nid = $this->db->insert_id();
		return $nid;
	}
	
	function get_devis($id=false){
		if($id){
			$this->db->where('id',$id);
			return $this->db->get('devis')->row_array();
		}else{
			$this->db->order_by('id','DESC');
			return $this->db->get('devis')->result_array();
		}
	}
	
	function get_facture($id=false){

		if($id){
			$this->db->where('id',$id);
			return $this->db->get('factures')->row_array();
		}else{
			$this->db->order_by('id','DESC');
			return $this->db->get('factures')->result_array();
		}
	}

	function get_checks_by_day($ids=false){
		$this->db->select("date,count(*) as total");
		if($ids){
			$this->db->where_in('machine',$ids);
		}
		$this->db->group_by('date');
		return $this->db->get('checks')->result_array();
	}

	function get_users(){
		return $this->db->get('users')->result_array();
	}	
}
?>
