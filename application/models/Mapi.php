<?php

class Mapi extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function select_entry(){
		//Setup a database connection returning a single row value
		$this->db->select("*");
		$this->db->where("user_id", $user_id);
		$query = $this->db->get("finger_data",1,0);

		if($query->num_rows() > 0) {
		    $user_id = $query->row("user_id");
		    return $user_id;    
		} else {
		    return FALSE;
		}
	}

	function checkFingerExist($data){
		//Setup a database connection returning a single row value
		$this->db->select("*");
		$this->db->where("finger_data", $data);
		$query = $this->db->get("finger_data",1,0);

		if($query->num_rows() > 0) {
		    $user_id = $query->row("user_id");
		    return $user_id;    
		}
		return FALSE;
	}

	function getFinger($pvv_id){
		//Setup a database connection returning a single row value
		$this->db->select("*");
		$this->db->where("user_id", $pvv_id);
		$query = $this->db->get("finger_data",1,0);

		if($query->num_rows() > 0) {
		    $finger = $query->row("finger_data");
		    return $finger;    
		}
		return FALSE;
	}

	function get_all_entries(){
		return $this->db->get('finger_data')->result_array();
	}

}
?>
