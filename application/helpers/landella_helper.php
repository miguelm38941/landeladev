<?php

function stock_decrease($user,$produits,$test=false){
	$CI =& get_instance();

	if(!is_array($produits)){
		return false;
	}

	$datas = $CI->lg->get_datas('stock',array('user' => $user),true);

	$now = date('Y-m-d');
	$exp = date('Y-m-d',strtotime('+30 days'));
	$datas2 = array();
	foreach($datas as $d){
		if(isset($d['peremption']) && $d['quantite'] > 0 && $d['peremption'] >= $now){
		//if($d['quantite'] > 0)
			$datas2[]=$d;
		}
	}
	//var_dump($datas);
//	unset($d);
	$ps = array();
	foreach($datas2 as $d){
		if(!isset($ps[$d['produit']])){
			$ps[$d['produit']]=array();
		}
		$ps[$d['produit']][]=$d;
	}
		
	//echo '<pre>';
	//var_dump($ps);
	
	foreach($produits as $pr){
		$p=$pr['produit'];
		$qt = $pr['quantite'];		

		if(!isset($ps[$p])){//var_dump($ps);

			return false;
		}

		$pps = $ps[$p];
		usort($pps,'stock_sort');		
		//echo $p."##";
		//var_dump($pps);
		foreach($pps as $pp){
			if($qt > 0){
				if($pp['quantite'] - $qt >= 0){
					$pp['quantite']-=$qt;
					$qt=0;
				}else{
					$qt -= $pp['quantite'];
					$pp['quantite']=0;
				}
				if($test == false)
					$CI->lg->set_data('stock',$pp['id'],array('quantite' => $pp['quantite']));
			}
		}
		if($qt > 0){
			return false;
		}
	}

	return true;

}

function stock_sort($a, $b)
{
	if(!isset($a['peremption'])){
		return -1;
	}
	if(!isset($b['peremption'])){
		return 1;
	}
    if ($a['peremption'] == $b['peremption']) {
        return 0;
    }
    return ($a['peremption'] < $b['peremption']) ? -1 : 1;
}

function get_warning($check=true){
	$CI =& get_instance();
	$now = date('Y-m-d');
	$exp = date('Y-m-d',strtotime("+30 days"));

	$limits=array();
	$uid = $CI->session->userdata('user_id');	
	$cid = $CI->session->userdata('organisation');	
	$datas=$CI->lg->get_datas('produits');
	//var_dump($datas); echo '<br><br>'; //exit;
	if ($CI->ion_auth->in_group(array('onusida','ministere','pnmls','pnls','admin'))) {
		$datas2=$CI->lg->get_datas('stock',array(),true);
		$generic_alertes = true;
		//var_dump($datas2); exit;
	}else{
		$datas2=$CI->lg->get_datas('stock',array('user' => $cid),true);
		$generic_alertes = false;
	}
	foreach($datas as $d){
		$limits[$d['id']]['min']=isset($d['min'])?$d['min']:'0';
		$limits[$d['id']]['min_pharmacie']=isset($d['min_pharmacie'])?$d['min_pharmacie']:'0';
		$limits[$d['id']]['min_zonesante']=isset($d['min_zonesante'])?$d['min_zonesante']:'0';
		$limits[$d['id']]['min_regionsante']=isset($d['min_regionsante'])?$d['min_regionsante']:'0';
		$limits[$d['id']]['min_pays']=isset($d['min_pays'])?$d['min_pays']:'0';
	}
	
	$ps = array();
	/*foreach($datas2 as $d){
		if(!isset($ps[$d['produit']])){
			$ps[$d['produit']]=0;
		}
		echo 'D: '.$d['produit'].' ||| '.$ps[$d['produit']].' --- '.$d['user'].' __ '.$d['quantite'].'<br>';
		foreach($datas2 as $dt){
			if($d['produit']==$dt['produit'] && $d['user']==$dt['user'] && isset($d['peremption']) && $d['quantite'] > 0 && $d['peremption'] > $now){
				$ps[$d['produit']]+=$d['quantite'];
				echo 'D: '.$dt['produit'].' ||| '.$ps[$d['produit']].' --- '.$dt['user'].' __ '.$dt['quantite'].'<br>---------------------<br>';
			}
		}
	}
	var_dump($ps); 
	echo '<br><br>';	
	var_dump($datas2); exit;*/	

	// Faire la somme tous les différents stocks
	$produits = array();
	foreach($datas2 as $d){
		if(!$generic_alertes){
			if(isset($d['peremption']) && $d['quantite'] > 0 && $d['peremption'] > $now){
				if(!isset($ps[$d['produit']])){
					$ps[$d['produit']]=0;
				}
				$ps[$d['produit']]+=$d['quantite'];
			}	
		}else{
			if(isset($d['peremption']) && $d['quantite'] > 0 && $d['peremption'] > $now){
				if(!isset($ps[$d['user']][$d['produit']])){
					$ps[$d['user']][$d['produit']]=0;
				}
				$ps[$d['user']][$d['produit']]+=$d['quantite'];
			}	
		}
	}
//var_dump($ps); exit;
	if(!$generic_alertes){
		$i=0;
		foreach($limits as $k => $v){
			if(!isset($ps[$k])){
				/*$produits[$i]['produit']=$k;
				$produits[$i]['quantite']=$v;*/
			}else{
				if($CI->ion_auth->in_group(array('regionsante'))){
					$limit = $limits[$k]['min_regionsante'];					
				}
				elseif($CI->ion_auth->in_group(array('zonesante'))){
					$limit = $limits[$k]['min_zonesante'];					
				}
				elseif($CI->ion_auth->in_group(array('pharmacie'))){
					$limit = $limits[$k]['min_pharmacie'];					
				}
				if($ps[$k] <= $limit){
					//var_dump($produits); exit;
					$produits[$i]['produit']=$k;
					$produits[$i]['quantite']=$ps[$k];
					$i++;//echo $i.'-';
				}		
			}	
		}
	}else{
		$i=0;
		foreach($ps as $pk => $pv){
			$table = get_table($pk);
			foreach($limits as $k => $v){
				if(!isset($pv[$k])){
					//$produits[$pk][]=$k;
				}else{
					$limit = isset($limits[$k]['min_'.$table])?$limits[$k]['min_'.$table]:$limits[$k]['min'];
					//$limit = $limits[$k]['min_'.$table];
					if($pv[$k] <= $limit){
						$produits[$i]['pharmacie']=$pk;
						$produits[$i]['produit']=$k;
						$produits[$i]['quantite']=$pv[$k];
						$i++;
					}		
				}	
			}
		}
	}
/*var_dump($ps);  
echo '<br><br>';	
var_dump($produits); exit;*/	

	//$produits = array();
	$res=array();
	$res2=array();
		
	foreach($datas2 as $d){
		if(!isset($d['peremption'])){
			$res[]=$d;
		}else if($d['quantite'] > 0 && $d['peremption'] <= $now){
			$res[]=$d;
		}else if($d['quantite'] > 0 && $d['peremption'] <= $exp){
			$res2[]=$d;
		}
		/*
		else if($d['quantite'] < $ps[$d['produit']]){
			$res[]=$d;
		}else if($d['quantite'] > 0 && $d['peremption'] <= $now){
			$res[]=$d;
		}*/
	}
	//var_dump($res);echo '----------------------------------------';// exit;	
	if($check == true){
		if(count($produits) > 0 || count($res) > 0 || count($res2) > 0){
			return true;
		}else{ 
			return false;
		}
	}else{
		return array('produits' => $produits,'peremption' => $res2,'perimer' => $res);
	} 
}

function get_produits(){
	$CI =& get_instance();
	$res=array();
	$datas=$CI->lg->get_datas('produits');
	foreach($datas as $d){
		$res[$d['id']]=$d['nom'];//." - ".$d['forme']." - ".$d['dosage'];
	}
	return $res;
}

function get_all_destinataires_commandes(){
	return get_destinataires_commandes(true);
}

function get_destinataires_commandes($all=false){
	$CI =& get_instance();

	$ps = get_entities_acteurs('partenaire');//get_partenaires_companies();
	$rs = get_entities_acteurs('regionsante');//get_region_sante_companies();
	$zs = get_entities_acteurs('zonesante');//get_zone_sante_companies();
	$sc = get_entities_acteurs('societe_pharma');//get_societe_pharma_companies();
	$ph = get_entities_acteurs('pharmacie');//get_pharmacies_companies();

	if($all){
		$res = $ps + $rs + $zs + $sc + $ph;
		return $res;
	}else{

	if($CI->ion_auth->in_group(array('pharmacie'))){
		//$res=$zs + $ph;
		///var_dump($zs); exit;
		$res=$rs + $zs + $ph + $ps;
	}else if($CI->ion_auth->in_group(array('zonesante'))){
		$res=$rs + $ps;
	}else if($CI->ion_auth->in_group(array('regionsante'))){
		$res=$ps;
	}else if($CI->ion_auth->in_group(array('partenaire'))){
		$res=$sc + $ps;
	}else{
		$res = $ps + $rs + $zs + $sc + $ph;
		//$res=$sc + $ps;
	}

	}

	$uid = $CI->session->userdata('user_id');
	$res2=array();
	foreach($res as $k => &$v){
		if($k != $uid){
			$res2[$k]=$v;
		}
	}	
	return $res2;
}

function get_pvv(){
	$CI =& get_instance();
	$res=array();
	$datas=$CI->lg->get_datas('pvv');
	foreach($datas as $d){
		$res[$d['id']]=$d['code'] . ' - ' . $d['nom'] . ' ' . $d['prenom'];
	}
	return $res;
}

function get_entities_acteurs($category){
	$CI =& get_instance();
	$res=array();
	$datas=$CI->lg->get_datas($category);
	foreach($datas as $d){
		$res[$d['id']]=$d['nom'];
	}
	return $res;
}

function get_single_pvv_by_code($code){
	$CI =& get_instance();
	$res=array();
	$datas=$CI->lg->get_data('pvv',array('code'=>$code),true);
	$pvv = array('id'=>$datas[0]['id'], 'name'=>$datas[0]['nom'] . ' ' . $datas[0]['prenom']);
	return $pvv;
}

function getCompany($id){
	$CI =& get_instance();
	$companies = array('societe_pharma','pharmacie','regionsante','zonesante','partenaire','agent');
	foreach ($companies as $company) {
		$datas=$CI->lg->get_datas($company,array('id'=>$id));
		if(!empty($datas)) return $datas[0]['nom'];
	}
}

function get_pvv_code(){
	$CI =& get_instance();
	$res=array();
	$datas=$CI->lg->get_datas('pvv');
	foreach($datas as $d){
		$res[$d['id']]=$d['code'];
	}
	return $res;
}

function get_societe_pharma(){
	return get_group_users('societe_pharma');
}

function get_societe_pharma_companies(){
	return get_group_users_companies('societe_pharma');
}

function get_pharmacies_companies(){
	return get_group_users_companies('pharmacie');
}

function get_region_sante_companies(){
	return get_group_users_companies('regionsante');
}

function get_zone_sante_companies(){
	return get_group_users_companies('zonesante');
}

function get_partenaires_companies(){
	return get_group_users_companies('partenaire');
}
function get_partenaires(){
	return get_group_users('partenaire');
}

function get_pharmacies(){
	return get_group_users('pharmacie');
}

function get_region_sante(){
	return get_group_users('regionsante');
}

function get_forma_sanitaire(){
	return get_group_users('agent');
}

function get_forma_sante_nom(){
	return get_entities_names('agent');
}

function get_region_sante_nom(){
	return get_entities_names('regionsante');
}

function get_zone_sante(){
	return get_group_users('zonesante');
}

function get_zone_sante_nom(){
	return get_entities_names('zonesante');
}

function get_province_nom(){
	return get_entities_names('province');
}

function get_ville_nom(){
	return get_entities_names('ville');
}

function get_educateurs(){
	return get_group_users('educateur');
}

function get_medecins(){
	return get_group_users('medecin');
}

function get_group_users($name){
	$CI =& get_instance();
	$res=$CI->db->query("SELECT id,username FROM users WHERE id IN (SELECT user_id FROM users_groups where group_id IN(SELECT id from groups where name='$name'))")->result_array();
	$res2=array();
	foreach($res as $r){
		$res2[$r['id']]=$r['username'];
	}
	return $res2;
}

function get_group_users_companies($name){
	$CI =& get_instance();
	$res=$CI->db->query("SELECT users.id,lg_datas.datas FROM users,lg_datas WHERE users.id IN (SELECT users_groups.user_id FROM users_groups where users_groups.group_id IN(SELECT groups.id from groups where groups.name='$name'))
										AND users.company=lg_datas.id")->result_array();
	//var_dump($res); echo 'echo'; exit;
	$res2=array();
	foreach($res as $r){
		$datas = json_decode($r['datas']);
		$res2[$r['id']]=$datas->nom;
	}
	return $res2;
}

function get_single_user($id){
	$CI =& get_instance();
	$res=$CI->db->query("SELECT id,first_name,last_name,company FROM users WHERE id='$id'")->result_array();
	return $res[0]['first_name']." ".$res[0]['last_name'];
}


function get_entities_names($name){
	$CI =& get_instance();
	$res=$CI->db->query("SELECT id,datas FROM lg_datas WHERE table_name='$name'")->result_array();
	$res2=array();
	foreach($res as $r){
		$data = json_decode($r['datas']);
		$res2[$r['id']]=isset($data->titre)?$data->titre:$data->nom;
	}
	return $res2;
}

function get_single_entity_name($name,$id){
	$CI =& get_instance();
	$res=$CI->db->query("SELECT datas FROM lg_datas WHERE table_name='$name' AND id='$id'")->result_array();
	if(count($res)>0) {
		$data = json_decode($res[0]['datas']);
		return $data->nom;
	}else{
		return '';
	}
}

function hook_before_add_pvv($datas){

	if(!isset($datas['code'])){
		$CI =& get_instance();
		$code = generate_cs();
		while($CI->lg->get_data('pvv',array('code' => $code))){
			$code = generate_cs();
		}
		$datas['code']=$code;
	}

	return $datas;	
}

function generate_cs(){
	$c1="CDVS";
	$c2=rand(1,99999);
	$c2=str_pad($c2, 5, '0', STR_PAD_LEFT);
	$c3=range('a','z');
	shuffle($c3);
	$c3=strtoupper($c3[0]);
	$c = $c1.$c2.$c3;
	return $c;
}

function generate_num(){
	$c1="C";
	$c2=rand(1,99999);
	$c2=str_pad($c2, 5, '0', STR_PAD_LEFT);
	$c3=range('a','z');
	shuffle($c3);
	$c3=strtoupper($c3[0]);
	$c = $c1.$c2.$c3;
	return $c;
}

function get_table($id){
	$CI =& get_instance();
	$tables = array_keys($CI->config->item('lgedit_tables'));
	foreach ($tables as $table) {
		$acteur = $CI->lg->get_data($table,array('id' => $id),true);
		if($acteur) return $table;
	}
}

?>
