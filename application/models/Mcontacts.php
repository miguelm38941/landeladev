<?php

class Mcontacts extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	function get_all(){
		return $this->db->get('profile')->result_array();
	}

	function get_by_campaign($id){
		$this->db->where('phone IN (SELECT phone FROM sms_sent WHERE sms_id="'.$id.'")',NULL,FALSE);
		return $this->db->get('profile')->result_array();
	}

	function get_field_values($name){

		$this->db->select($name);
		$this->db->group_by($name);
		$res = $this->db->get('profile')->result_array();
		$res2=array();
		foreach($res as $r){
			$res2[]=$r[$name];
		}
		return $res2;
	}

	function update_profile($phone,$datas){
		$this->db->where('phone',$phone);
		$this->db->update('profile',$datas);
	}

	function filter($fields=false,$exclude_campaigns=false,$exclude_clients=false,$limit=false){

		if(is_array($fields) && !empty($fields)){
			foreach($fields as $k => $v){
				if(!is_array($v)){
					$v=array($v);
				}
				if(empty($v)) continue;

				if($k == "location"){
					$vv = implode("','",$v);
					
					$this->db->where("( work_location IN('$vv') OR home_location IN ('$vv') )");
				}else{
					$this->db->where_in($k,$v);
				}	
				
			}
		}
	
		if(is_array($exclude_campaigns) && !empty($exclude_campaigns)){
			if(count($exclude_campaigns) == 1 && empty($exclude_campaigns[0])){
			}else{
				$this->db->where('phone NOT IN (SELECT phone FROM sms_sent WHERE sms_id IN('.implode(",",$exclude_campaigns).'))',NULL,FALSE);
			}
		}
		
		if(is_array($exclude_clients) && !empty($exclude_clients)){
			if(count($exclude_clients) == 1 && empty($exclude_clients[0])){
			}else{
				$this->db->where("phone NOT IN (SELECT phone FROM sms_sent WHERE sms_id IN (SELECT id FROM sms WHERE client IN ('".implode("','",$exclude_clients)."')))",NULL,FALSE);
			}
		}

		$this->db->where('disabled',0);
		$this->db->order_by('sms_sent','ASC');
		if(is_numeric($limit)){
			$this->db->limit($limit);
		}
		$res=$this->db->get('profile')->result_array();
		return $res;
	}
	
	function exists($number){
		
		$this->db->where('phone',$number);
		return $this->db->count_all_results('profile') > 0;
	}

	function add_number($number,$infos=false){
		
		$datas=array(
			'phone' => $number
		);

		if(!is_array($infos)){
			$infos=array();
		}

		foreach($infos as $k => &$v){
			if(empty($v)){
				unset($infos[$k]);
			}
		}

		$this->db->where('phone',$number);
		if($this->db->count_all_results('profile') > 0){
			if(!empty($infos)){
				$this->db->where('phone',$number);
				$this->db->update('profile',$infos);
			}
		}else{
			$infos['phone']=$number;
			$this->db->insert('profile',$infos);
		}
	}

	function get_numbers($profiles=array()){
		$this->db->select('phone');
		$this->db->where_in('id',$profiles);

		$datas = $this->db->get('profile')->result_array();
		$res=array();
		foreach($datas as $data){
			$res[]=$data['phone'];
		}	
		return $res;
	}

	function fix(){

		//$q = str_replace('alias','`role`',$query);
		//$this->db->query($q);

		$fixes=array(
			array('role','etudient','etudiant'),
			array('role','"restauration','restauration'),
			array('name','nonguerma','nonguierma'),
			array('name','ouedraoga','ouedraoga')
		);

		foreach($fixes as $fix){
			$datas=array();
			$datas[$fix[0]]=$fix[2];
			$this->db->like($fix[0],$fix[1]);
			$this->db->update('profile',$datas);
		}
		
		$fixes=array(
			//array('',''),
			array('balkouy','balkui'),
			array('set30','sect30'),
			array('set27','sect27'),
			array('sectc30','sect30'),
			array('sect8','sect08'),
			array('sig-noghin','signonghin'),
			array('nokio i','nioko i'),
			array('nokio ii','nioko ii'),
			array('nioko 1','nokio i'),
			array('nioko 2','nokio ii'),
			array('nioko 02','nioko ii'),
			array('patt%oie%',"patte doie"),
			array('kamsaoghin','kansonghin'),
			array('kalgodin','kalgondin'),
			array('toudouweogo','toudougweogo'),
			array('song-naba','song-naaba'),
			array('song naaba','song-naaba'),
			array('sissin','cissin'),
			array('ouidi','widi'),
			array('wuigi','widi'),
			array('larlã©','larle'),
			array('dapoya','dapouya'),
			array('dag-noen','dagnoen'),
			array('dag noen','dagnoen'),
			array('dagn"eon','dagnoen'),
			array('bissiguy','bissigui'),
			array('bissigi','bissigui'),
			array('secrt 19','sect 19'),
			array('universitã© ouagadougou','universite ouagadougou'),
			array('zone1','zone 1'),
			array('zone i','zone 1'),
			array('zone 2','zone 1'),
			array('zone2','zone 1'),
			array('zogonaa','zogona'),
			array('wemtinga','wemtenga'),
			array('wentenga','wemtenga'),
			array('wayalgin','wayalghin'),
			array('wapasi','wapassi'),
			array('tabtenga','taabtenga'),
			array('samadin','samandin'),
			array('pissi','pissy'),
			array('nossin','nonsin'),
			array('nagre','nagrin'),
			array('kouri tinga','kouritenga'),
			array('kamsaonghin','kansonghin'),
			array('kalgonde','kalgondin'),
			array('kamboisin','kambouinsin'),
			array('kamboissin','kambouinsin'),
			array('%logement%','1200 logement'),
			array('bendogo','benogo'),
			array('benego','benogo'),
			array('cite en iii','cite an iii'),
			array('daguanain','dagnongo'),
			array('dass%o%','dassasgho'),
			array('gou%in','goughin')
		);

		foreach($fixes as $fix){
			$datas=array();
			$datas['work_location']=$fix[1];
			$this->db->where("work_location LIKE '".$fix[0]."' ");
			$this->db->update('profile',$datas);
			$datas=array();
			$datas['home_location']=$fix[1];
			$this->db->where("home_location LIKE '".$fix[0]."' ");
			$this->db->update('profile',$datas);
		}

		$this->db->query("UPDATE `profile` SET work_location=REPLACE(work_location,'sect ','sect')");	
		$this->db->query("UPDATE `profile` SET home_location=REPLACE(home_location,'sect ','sect')");	
			


		$fixes = array(
			//array('',''),
			array('serv%','serveur'),
			array('rest%','restaurateur'),
			array('reparateur%','reparateur'),
			array('menusier','menuisier'),
			array('mecano','mecanicien'),
			array('foncionnaire','fonctionnaire'),
			array('entepreneur','entrepreneur'),
			array('entepeneur','entrepreneur'),
			array('entrepeneur','entrepreneur'),
			array('enseign%','enseignant'),
			array('arstiste','artiste'),
			array('couture','couturier'),
			array('coututier','couturier'),
			array('eleve%','eleve'),
			array('employe%','employer'),
			array('coiff%','coiffeur'),
			array('maitresse','maitre'),
			array('maã§on','macon'),
			array('gã©rante de kiosque','gerant de kiosque'),
			array('gã©rant de kiosque','gerant de kiosque'),
			array('agent de santã©','agent de sante')
		);

		foreach($fixes as $fix){
			$datas=array();
			$datas['role']=$fix[1];
			$this->db->where("role LIKE '".$fix[0]."' ");
			$this->db->update('profile',$datas);
		}
	}

}
?>
