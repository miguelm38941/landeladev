<?php

function get_lns_users(){
	$CI =& get_instance();

	$CI->db->select('id,username');
	$clients =$CI->db->get('users')->result_array();

	$res = array('-1' => 'Aucun');
	foreach($clients as $cs){
		$res[$cs['id']]=$cs['username'];
	}
	return $res;
}

function get_lns_clients(){
	$CI =& get_instance();

	$clients = $CI->mlns->get_clients();
	$res = array();
	foreach($clients as $cs){
		$res[$cs['id']]=$cs['nom'];
	}
	return $res;
}

function get_lns_agents(){
	$CI =& get_instance();
	return $CI->config->item('lns_agents');
}

function get_lns_checks(){
	$CI =& get_instance();
	$lchecks=$CI->config->item('lns_checks');
	return $lchecks;
}

function get_internal_checks(){
	$CI =& get_instance();
	$lchecks=$CI->config->item('lns_checks');
	return $lchecks['interieur'];
}

function get_internal_notes_checks(){
	$CI =& get_instance();
	$lchecks=$CI->config->item('lns_checks');
	return $lchecks['interieur_notes'];
}

function get_external_checks(){
	$CI =& get_instance();
	$lchecks=$CI->config->item('lns_checks');
	return $lchecks['exterieur'];
}

function get_external_notes_checks(){
	$CI =& get_instance();
	$lchecks=$CI->config->item('lns_checks');
	return $lchecks['exterieur_notes'];
}

function get_general_checks(){
	$CI =& get_instance();
	$lchecks=$CI->config->item('lns_checks');
	return $lchecks['general'];
}

function get_general_notes_checks(){
	$CI =& get_instance();
	$lchecks=$CI->config->item('lns_checks');
	return $lchecks['general_notes'];
}

function get_options_checks(){
	$CI =& get_instance();
	$lchecks=$CI->config->item('lns_checks');
	return $lchecks['options'];
}

function lns_get_client_status($id){
	$CI =& get_instance();
	$machines=$CI->mlns->get_machines_by_client($id);
	return lns_get_worst_status($machines);
}

function lns_get_area_status($id){
	$CI =& get_instance();
	$machines = $CI->mlns->get_machines($id);
	return lns_get_worst_status($machines);
}

function lns_get_worst_status($machines){
	
	$res=array();
	foreach($machines as $m){
		$infos = lns_get_machine_status($m['id']);
		$res[$infos['level']]=$infos;	
	}
	arsort($res);
	return reset($res); 
	
}

function lns_get_machine_status($id){
	$CI =& get_instance();

	$checks = $CI->mlns->get_checks($id);

	if(count($checks) == 0){
		return lns_get_check_status(false);
	}
	
	$check = $checks[0];
	return lns_get_check_status($check);
}

function lns_get_check_status($check){
	$CI =& get_instance();
	
	$infos = array(
		'level' => 0,
		'color' => 'green',
		'status' => 'good',
		'errors' => array()
	);

	if(!is_array($check)){
		$infos['level']=1;
		$infos['color']='grey';
		$infos['status']='unknow';
		return $infos;
	}

	$lchecks=$CI->config->item('lns_checks');
	$lnotes = array();
	$lnotes = array_merge($lnotes,$lchecks['general_notes']);
	$lnotes = array_merge($lnotes,$lchecks['interieur_notes']);
	$lnotes = array_merge($lnotes,$lchecks['exterieur_notes']);

	$notes=array();
	$ns = json_decode($check['general_notes'],true);
	if($ns)
	$notes=array_merge($notes,$ns);
	$ns = json_decode($check['interieur_notes'],true);
	if($ns)
	$notes=array_merge($notes,$ns);
	$ns = json_decode($check['exterieur_note'],true);
	if($ns)
	$notes=array_merge($notes,$ns);

	foreach(array('INTN0','EXTN2') as $n){
		if(in_array($n,$notes)){
			$infos['level']=2;
			$infos['color'] = 'yellow';
			$infos['status'] = 'warning';
			$infos['errors'][]=$lnotes[$n];		
		}	
	}

	foreach(array('INTN1','EXTN1','GENN1') as $n){
		if(in_array($n,$notes)){
			$infos['level']=3;
			$infos['color'] = 'orange';
			$infos['status'] = 'warning';
			$infos['errors'][]=$lnotes[$n];		
		}	
	}
	
	foreach(array('GENN0','GENN2','GENN3','INTN2','INTN3','EXTN0') as $n){
		if(in_array($n,$notes)){
			$infos['level']=4;
			$infos['color'] = 'red';
			$infos['status'] = 'problem';
			$infos['errors'][]=$lnotes[$n];		
		}	
	}
		
	return $infos;
}



?>
