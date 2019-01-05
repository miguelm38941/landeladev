<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Ordonnances extends CI_Controller {



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

		//$this->load->library('Pdf');

		//$this->load->helper('db');

		//$this->check_db();
		
        $CI =& get_instance();
		$CI->load->model('mlg');
		//$this->load->database();

	}



	public function index(){

		echo "11";

	}

	public function mes_ordonnances($pvv){

		$filter = array('pvv'=>$pvv);
        $ordonnances = $this->lg->get_datas('ordonnances',$filter,true);
        $ordonn = array();
        foreach ($ordonnances as $y=>$ordonnance):
        	foreach ($ordonnance as $k=>$v):
        		if( ($k!='pvv')&&($k!='prepose_pharmacie')&&($k!='consultation')&&($k!='produits') ):
        			$ordonn[$y][$k] = $v;
        		endif;
        	endforeach;
        	foreach ($ordonnance['produits'] as $k=>$prod):
        		$prdt = $this->lg->get_data('produits',array('id'=>$prod['produit']),true);
	        	$ordonn[$y]['produits'][$k]['produit'] = $prdt['nom'];
	        	$ordonn[$y]['produits'][$k]['quantite'] = $prod['quantite'];
	        	$ordonn[$y]['produits'][$k]['posologie'] = $prod['posologie'];
        	endforeach;

        	$pvvdata = $this->lg->get_user_by_entityid($pvv);//$this->lg->get_data('pvv',array('id'=>$pvv),true);
        	if($pvvdata){
        		$ordonn[$y]['pvv'] = $pvvdata['last_name']. ' '.$pvvdata['first_name'];
        	}else{
        		$ordonn[$y]['pvv'] = null;
        	}
        	if(isset($ordonnance['prepose_pharmacie'])):
        		//$ordonn[$y]['prepose_pharmacie'] = $this->getModelPrepose($ordonnance['prepose_pharmacie']);
	        	$prepo = $this->getModelPrepose($ordonnance['prepose_pharmacie']);
        		if(!empty($prepo)){    			
		        	$ordonn[$y]['prepose_pharmacie'] = $prepo['prepose'];
		        	$ordonn[$y]['prepose_hopital'] = $prepo['prepose_company'];
	        	}
        	endif;
        	//Model consultation
        	$consultation = $this->lg->get_data('consultation',array('id'=>$ordonnance['consultation']),true);
        	foreach ($consultation as $k=>$v):
        		if( ($k!='pvv')&&($k!='infirmier')&&($k!='medecin')&&($k!='agent') ):
        			$ordonn[$y]['consultation'][$k] = $v;
        		endif;
        	endforeach;
        	$pvvdata = $this->lg->get_user_by_entityid($consultation['pvv']);//$this->lg->get_data('pvv',array('id'=>$consultation['pvv']),true);
        	if($pvvdata){
        		$ordonn[$y]['consultation']['pvv'] = $pvvdata['last_name']. ' '.$pvvdata['first_name'];
        	}else{
        		$ordonn[$y]['pvv'] = null;
        	}
        	$agent = $this->lg->get_user($consultation['agent']);//$this->lg->get_data('agent',array('id'=>$consultation['agent']),true);
        	if($agent){
        		$ordonn[$y]['consultation']['agent'] = $agent['last_name']. ' '.$agent['first_name'];
        	}else{
        		$ordonn[$y]['consultation']['agent'] = null;
        	}
        	if(isset($consultation['infirmier']) && !empty($consultation['infirmier'])):
        		$infir = $this->getModelInfirmier($consultation['infirmier']);
        		if(!empty($infirmier)){    			
		        	$ordonn[$y]['infirmier'] = $infir['infirmier'];
		        	$ordonn[$y]['infirmier_hopital'] = $infir['infirmier_company'];
        		}
 	        	$prepo = $this->getModelPrepose($ordonnance['prepose_pharmacie']);
        		if(!empty($prepo)){    			
	        		$ordonn[$y]['prepose_pharmacie'] = $prepo['prepose'];
	        		$ordonn[$y]['prepose_hopital'] = $prepo['prepose_company'];
	        	}
        	endif;
        	if(isset($consultation['medecin']) && !empty($consultation['medecin'])):
        		//$ordonn[$y]['consultation']['medecin'] = $this->getModelInfirmier($consultation['medecin']);
	        	$prepo = $this->getModelMedecin($consultation['medecin']);
	        	$ordonn[$y]['consultation']['medecin'] = $prepo['medecin'];
	        	$ordonn[$y]['consultation']['medecin_hopital'] = $prepo['medecin_company'];
		    endif;
        endforeach;
        unset($ordonnances);
        header('Content-type: application/json');
        $responseData['success'] = true;
        $responseData['result'] = $ordonn;
        echo json_encode($responseData); 
        //header('Content-type: application/json');
		/*echo json_encode(array(
								'success'=>true,
								'result'=>$ordonnances
							)
						);*/ 

	}

	public function get_medicaments($ordonnance){

		$filter = array('id'=>$ordonnance);
        $ordonnance = $this->lg->get_data('ordonnances',$filter,true);

        $prod = array();
        foreach ($ordonnance['produits'] as $k=>$p): 
        	$produit = $this->lg->get_data('produits',array('id'=>$p['produit']),true);
        	$prod[$k]['nom'] = $produit['nom'];
        	$prod[$k]['quantite'] = $p['quantite'];
        	$prod[$k]['posologie'] = $p['posologie'];
        endforeach;

        unset($ordonnance);
        header('Content-type: application/json');
        $responseData['success'] = true;
        $responseData['result'] = $prod;
        echo json_encode($responseData); 

	}

	public function mes_consultations($pvv){

        $consultations = $this->lg->get_datas('consultation',array('pvv'=>$pvv),true);
        $consult = array();
        foreach ($consultations as $y=>$consultation):
        	foreach ($consultation as $k=>$v):
        		if( ($k!='pvv')&&($k!='infirmier')&&($k!='medecin') ):
        			$consult[$y][$k] = $v;
        		endif;
        	endforeach;
        	$pvvdata = $this->lg->get_user_by_entityid($consultation['pvv']);//$this->lg->get_data('pvv',array('id'=>$pvv),true);
        	if($pvvdata){
        		$consult[$y]['pvv'] = $pvvdata['last_name']. ' '.$pvvdata['first_name'];
        	}else{
        		$consult[$y]['pvv'] = null;
        	}
        	
        	$agent = $this->lg->get_user($consultation['agent']);//$this->lg->get_data('agent',array('id'=>$consultation['agent']),true);
        	if($agent){
        		$consult[$y]['agent'] = $agent['last_name']. ' '.$agent['first_name'];
        	}else{
        		$consult[$y]['agent'] = null;
        	}
        	if(isset($consultation['infirmier']) && !empty($consultation['infirmier'])):
        		$infir = $this->getModelInfirmier($consultation['infirmier']);
        		if(!empty($infir)){
		        	$consult[$y]['infirmier'] = $infir['infirmier'];
		        	$consult[$y]['infirmier_hopital'] = $infir['infirmier_company'];
		        }
        	endif;
        	if(isset($consultation['medecin']) && !empty($consultation['medecin'])):
        		$infir = $this->getModelMedecin($consultation['medecin']);
        		if(!empty($infir)){
		        	$consult[$y]['medecin'] = $infir['medecin'];
		        	$consult[$y]['medecin_hopital'] = $infir['medecin_company'];
		        }
		    endif;
        endforeach; 
        unset($consultations);
        header('Content-type: application/json');
        if(!empty($consult)):
	        $responseData['success'] = true;
	        $responseData['result'] = $consult;
        else:
	        $responseData['success'] = false;
	        $responseData['message'] = 'Aucune consultation trouvée';
        endif;
        echo json_encode($responseData); 
        /*header('Content-type: application/json');
		echo json_encode(array(
								'success'=>true,
								'result'=>$consultations
							)
						);*/

	}

	public function consultations_crees($agent){

        $consultations = $this->lg->get_datas('consultation',array('agent'=>$agent),true);
        $consult = array();
        foreach ($consultations as $y=>$consultation):
        	foreach ($consultation as $k=>$v):
        		if( ($k!='pvv')&&($k!='infirmier')&&($k!='medecin')&&($k!='agent') ):
        			$consult[$y][$k] = $v;
        		endif;
        	endforeach;
        	$pvvdata = $this->lg->get_user_by_entityid($consultation['pvv']);//$this->lg->get_data('pvv',array('id'=>$consultation['pvv']),true);
        	if($pvvdata){
        		$consult[$y]['pvv'] = $pvvdata['last_name']. ' '.$pvvdata['first_name'];
        	}else{
        		$consult[$y]['pvv'] = null;
        	}
        	$agent = $this->lg->get_user($consultation['agent']);//$this->lg->get_data('agent',array('id'=>$consultation['agent']),true);
        	if($agent){
        		$consult[$y]['agent'] = $agent['last_name']. ' '.$agent['first_name'];
        	}else{
        		$consult[$y]['agent'] = null;
        	}
        	if(isset($consultation['infirmier']) && !empty($consultation['infirmier'])):
        		$prepo = $this->getModelInfirmier($consultation['infirmier']);
	        	if(!empty($prepo)){
		        	$consult[$y]['infirmier'] = $prepo['infirmier'];
		        	$consult[$y]['infirmier_hopital'] = $prepo['infirmier_company'];
		        }
        	endif;
        	if(isset($consultation['medecin']) && !empty($consultation['medecin'])):
	        	$prepo = $this->getModelMedecin($consultation['medecin']);
	        	if(!empty($prepo)){
		        	$consult[$y]['medecin'] = $prepo['medecin'];
		        	$consult[$y]['medecin_hopital'] = $prepo['medecin_company'];
		        }
		    endif;
        endforeach; 
        unset($consultations);
		header('Content-type: application/json');
		echo json_encode(array(
								'success'=>true,
								'result'=>$consult
							)
						); 

	}

	public function mes_observations($pvv){

        $observations = $this->lg->get_datas('observations',array('pvv'=>$pvv),true);
		header('Content-type: application/json');
		echo json_encode(array(
								'success'=>true,
								'result'=>$observations
							)
						); 

	}

	public function ordonnance_a_recevoir($pvv){

        $ordonnance = $this->lg->get_datas('ordonnances',array('pvv'=>$pvv,'etat'=>'tobereceived'),true);
		header('Content-type: application/json');
		echo json_encode(array(
								'success'=>true,
								'result'=>$ordonnance
							)
						); 

	}

	public function recevoir_ordonnance($ordonnance){

        $ordonnance = $this->lg->get_data('ordonnances',array('id'=>$ordonnance),true);
        if(!empty($ordonnance)){
        	$ordonnance['etat'] = 'Livree';
			$res = $this->lg->set_data('ordonnances',$ordonnance['id'],$ordonnance,false);
			header('Content-type: application/json');
			echo json_encode(array(
									'success'=>true,
									'message'=>'L\'ordonnance a bien &eacute;t&eacute; accept&eacute;e. '
								)
							); 
        }else{
			header('Content-type: application/json');
			echo json_encode(array(
									'success'=>false,
									'message'=>'Aucune ordonnance correspondante trouvee.'
								)
							); 
        }

	}

	public function ordonnances_livrees($prepose){

        $ordonnances = $this->lg->get_datas('ordonnances',array('prepose_pharmacie'=>$prepose,'etat'=>'Livree'),true);

        $ordonn = array();
        foreach ($ordonnances as $y=>$ordonnance):
        	foreach ($ordonnance as $k=>$v):
        		if( ($k!='pvv')&&($k!='consultation')&&($k!='produits') ):
        			$ordonn[$y][$k] = $v;
        		endif;
        	endforeach;
        	//echo '<br>+++++++++++++++++++++++++++++++++++++++++++++++++++++++<br>';var_dump($ordonnance['produits']); echo '<br>*****<br>'; 
        	if(is_array($ordonnance['produits'])):
        	foreach ($ordonnance['produits'] as $k=>$prod):
        		$prdt = $this->lg->get_data('produits',array('id'=>$prod['produit']),true);
	        	$ordonn[$y]['produits'][$k]['produit'] = $prdt['nom'];
	        	$ordonn[$y]['produits'][$k]['quantite'] = $prod['quantite'];
	        	$ordonn[$y]['produits'][$k]['posologie'] = $prod['posologie'];
        	endforeach;
        	//echo '<br>-----------------------------------------------<br>';
        	endif;
        	$pvvdata = $this->lg->get_user_by_entityid($ordonnance['pvv']);//$this->lg->get_data('pvv',array('id'=>$consultation['pvv']),true);
        	if($pvvdata){
        		$ordonn[$y]['pvv'] = $pvvdata['last_name']. ' '.$pvvdata['first_name'];
        	}else{
        		$ordonn[$y]['pvv'] = null;
        	}
        	//$ordonn[$y]['pvv'] = $this->lg->get_data('pvv',array('id'=>$ordonnance['pvv']),true);
        	//Model consultation
        	$consultation = $this->lg->get_data('consultation',array('id'=>$ordonnance['consultation']),true);
        	foreach ($consultation as $k=>$v):
        		if( ($k!='pvv')&&($k!='infirmier')&&($k!='medecin')&&($k!='agent') ):
        			$ordonn[$y]['consultation'][$k] = $v;
        		endif;
        	endforeach;
        	$ordonn[$y]['consultation']['pvv'] = $this->lg->get_data('pvv',array('id'=>$consultation['pvv']),true);
        	$agent = $this->lg->get_user($consultation['agent']);//$this->lg->get_data('agent',array('id'=>$consultation['agent']),true);
        	if($agent){
        		$ordonn[$y]['consultation']['agent'] = $agent['last_name']. ' '.$agent['first_name'];
        	}else{
        		$ordonn[$y]['consultation']['agent'] = null;
        	}
        	if(isset($consultation['infirmier']) && !empty($consultation['infirmier'])):
        		$prepo = $this->getModelInfirmier($consultation['infirmier']);
	        	if(!empty($prepo)){
		        	$ordonn[$y]['consultation']['infirmier'] = $prepo['infirmier'];
		        	$ordonn[$y]['consultation']['infirmier_hopital'] = $prepo['infirmier_company'];
		        }
        	endif;
        	if(isset($consultation['medecin']) && !empty($consultation['medecin'])):
	        	$prepo = $this->getModelMedecin($consultation['medecin']);
	        	$consult[$y]['consultation']['medecin'] = $prepo['medecin'];
	        	$consult[$y]['consultation']['medecin_hopital'] = $prepo['medecin_company'];
		    endif;
        endforeach; 
        unset($ordonnances);
		header('Content-type: application/json');
		echo json_encode(array(
								'success'=>true,
								'result'=>$ordonn
							)
						); 

	}

	public function informations(){

        $informations = $this->lg->get_datas('diffusions',array('visible'=>'true'),true);
		header('Content-type: application/json');
		echo json_encode(array(
								'success'=>true,
								'result'=>$informations
							)
						); 

	}

	/**
	 * livrer_ordonnance 
	 * Appeler par le scan du preposé pharmacie
	 * @return [ordonnance] [description]
	 */
	public function livrer_ordonnance(){
		$qrcode = $this->input->post('qrcode');
		$expl = explode('|', $qrcode);
		$pvv = $expl[0];
		// Creer nouvelle consultation
		$content = http_build_query (array (
							'pvv' => $pvv,
							'prepose_pharmacie' => $this->input->post('prepose_pharmacie'),
							'api' => 'true',
							'api_pharmacie' => 'true'
		));

		$context = stream_context_create (array (
							'http' => array (
							'method' => 'POST',
						    'header' =>
						        "Content-Type: application/x-www-form-urlencoded\r\n".
						        "Authorization: Bearer sdf541gs6df51gsd1bsb16etb16teg1etr1ge61g\n",
        					'content' => $content,
			)
		));

		$result = file_get_contents(base_url().'lgedit/add/ordonnances', null, $context); 
		$selectedOrdonnance = json_decode($result); 

		$ordonn = array();
		if(isset($selectedOrdonnance) && !empty($selectedOrdonnance)):
	        $ordonnance = $this->lg->get_data('ordonnances',array('id'=>$selectedOrdonnance->id),true);
	        if(!empty($ordonnance)){
	        	foreach ($ordonnance as $k=>$v):
	        		if( ($k!='pvv')&&($k!='consultation')&&($k!='produits') ):
	        			$ordonn[$k] = $v;
	        		endif;
	        	endforeach;
	        	//if(is_array($ordonnance['produits'])):
	        	foreach ($ordonnance['produits'] as $k=>$prod):
	        		$prdt = $this->lg->get_data('produits',array('id'=>$prod['produit']),true);
		        	$ordonn['produits'][$k]['produit'] = $prdt['nom'];
		        	$ordonn['produits'][$k]['quantite'] = $prod['quantite'];
		        	$ordonn['produits'][$k]['posologie'] = $prod['posologie'];
	        	endforeach;
	        	//endif;
	        	$pvvdata = $this->lg->get_user_by_entityid($ordonnance['pvv']);//$this->lg->get_data('pvv',array('id'=>$consultation['pvv']),true);
	        	if($pvvdata){
	        		$ordonn['pvv'] = $pvvdata['last_name']. ' '.$pvvdata['first_name'];
	        	}else{
	        		$ordonn['pvv'] = null;
	        	}
	        	//$ordonn['pvv'] = $this->lg->get_data('pvv',array('id'=>$ordonnance['pvv']),true);
	        	if(isset($ordonnance['prepose_pharmacie'])):
	        		$prepo = $this->getModelPrepose($ordonnance['prepose_pharmacie']);
	        		$ordonn['prepose_pharmacie'] = $prepo['prepose'];
	        		$ordonn['prepose_hopital'] = $prepo['prepose_company'];
	        	endif;
	        	//Model consultation
	        	$consultation = $this->lg->get_data('consultation',array('id'=>$ordonnance['consultation']),true);
	        	foreach ($consultation as $k=>$v):
	        		if( ($k!='pvv')&&($k!='infirmier')&&($k!='medecin')&&($k!='agent') ):
	        			$ordonn['consultation'][$k] = $v;
	        		endif;
	        	endforeach;
	        	$ordonn['consultation']['pvv'] = $this->lg->get_data('pvv',array('id'=>$consultation['pvv']),true);
	        	$agent = $this->lg->get_user($consultation['agent']);//$this->lg->get_data('agent',array('id'=>$consultation['agent']),true);
	        	if($agent){
	        		$ordonn['consultation']['agent'] = $agent['last_name']. ' '.$agent['first_name'];
	        	}else{
	        		$ordonn['consultation']['agent'] = null;
	        	}
	        	if(isset($consultation['infirmier']) && !empty($consultation['infirmier'])):
	        		$ordonn['consultation']['infirmier'] = $this->getModelInfirmier($consultation['infirmier']);
	        	endif;
	        	if(isset($consultation['medecin']) && !empty($consultation['medecin'])):
		        	$prepo = $this->getModelMedecin($consultation['medecin']);
		        	$ordonn['consultation']['medecin'] = $prepo['medecin'];
		        	$ordonn['consultation']['medecin_hopital'] = $prepo['medecin_company'];
			    endif;
	        }
	        unset($ordonnance);
			header('Content-type: application/json');
			echo json_encode(array(
									'success'=>true,
									'result'=>array($ordonn)
								)
							); 
    	else:
	        unset($ordonnance);
			header('Content-type: application/json');
			echo json_encode(array(
									'success'=>false,
									'result'=>'Aucune ordonnance à accepter'
								)
							); 
    	endif;

		//echo json_encode($result);
	}

	/**
	 * livrer_medicaments
	 * Appeler lorsque le préposé clique pour livrer une ordonnance
	 * @return [type] [description]
	 */
	public function livrer_medicaments(){
		// Creer nouvelle consultation
		/*$content = http_build_query (array (
							'id' => $this->input->post('ordonnance'),
							'pvv' => $this->input->post('pvv'),
							'etat' => 'tobereceived',
							'api' => 'true',
							'api_pharmacie' => 'true',
							'api_medicament' => 'true'
		));*/

		// Sets our destination URL
		$endpoint_url = base_url().'lgedit/add/ordonnances';

		// Creates our data array that we want to post to the endpoint
		$data_to_post = [
									'ordonnance' => $this->input->post('ordonnance'),
									'etat' => 'tobereceived',
									'delivered' => date('Y-m-d'),
									'api' => 'true',
									'api_pharmacie' => 'true',
									'api_medicament' => 'true'
		];

		// Sets our options array so we can assign them all at once
		$options = [
		  	CURLOPT_URL        => $endpoint_url,
			CURLOPT_POST       => true,
			CURLOPT_POSTFIELDS => $data_to_post,
		];

		// Initiates the cURL object
		$curl = curl_init();

		// Assigns our options
		curl_setopt_array($curl, $options);

		// Executes the cURL POST
		$result = curl_exec($curl);

		// Be kind, tidy up!
		curl_close($curl);

		echo json_encode($result);
	}


	public function nouvelle_consultation(){
		$qrcode = $this->input->post('qrcode');
		$expl = explode('|', $qrcode);
		$pvv = $expl[0];
		// Creer nouvelle consultation
		$content = http_build_query (array (
							'pvv' => $pvv,
							'agent' => $this->input->post('agent'),
							'medecin' => '',
							'infirmier' => '',
							'api' => 'true'
		));

		$context = stream_context_create (array (
							'http' => array (
							'method' => 'POST',
						    'header' =>
						        "Content-Type: application/x-www-form-urlencoded\r\n".
						        "Authorization: Bearer sdf541gs6df51gsd1bsb16etb16teg1etr1ge61g\n",
        					'content' => $content,
			)
		));

		$result = file_get_contents(base_url().'lgedit/add/consultation', null, $context); 

		echo json_encode($result);
	}

	private function getModelInfirmier($id){
	    $infirmier = $this->lg->get_user($id);//$this->lg->get_data('infirmier',array('id'=>$id));
//var_dump($infirmier); echo '<br>';
	    //$infirmier = $this->lg->get_user($id);
	    if($infirmier!=null){
		    $infirm = array();
			/*foreach ($infirmier as $k=>$v):
		    	if( ($k!='company') ):
					$infirm[$k] = $v;
		    	endif;
			endforeach;*/
			$company = $this->lg->get_company($infirmier['company']);
			//var_dump($company); echo "<br>-------------<br>";
			$medec['infirmier'] = $infirmier['last_name'].' '.$infirmier['first_name'];
			$medec['infirmier_company'] = isset($company->nom)?$company->nom:null;
			return $infirm;
		}else{
			return null;
		}
	}

	private function getModelMedecin($id){
		$medecin = $this->lg->get_user($id);//$this->lg->get_data('medecin',array('id'=>$id));
		if($medecin!=null){
			$medeco = array();
			/*foreach ($medecin as $k=>$v):
				if( ($k!='company') ):
		        	$medeco[$k] = $v;
		    	endif;
			endforeach;*/
			//$medec['company'] = $this->lg->get_company($medecin['company']);
			$company = $this->lg->get_company($medecin['company']);
			$medec['medecin'] = $medecin['last_name'].' '.$medecin['first_name'];
			$medec['medecin_company'] = isset($company->nom)?$company->nom:null;
			return $medec;
		}else{
			return null;
		}
	}

	private function getModelPrepose($id){
		$prepose = $this->lg->get_user($id);//$this->lg->get_data('medecin',array('id'=>$id));
		if($prepose!=null){
			$medeco = array();
			/*foreach ($medecin as $k=>$v):
				if( ($k!='company') ):
		        	$medeco[$k] = $v;
		    	endif;
			endforeach;*/
			$company = $this->lg->get_company($prepose['company']);
			$medec['prepose'] = $prepose['last_name'].' '.$prepose['first_name'];
			$medec['prepose_company'] = $company->nom;
			return $medec;
		}else{
			return null;
		}
	}

	private function getModelPvv($id){
		$pvv = $this->lg->get_user($id);//$this->lg->get_data('medecin',array('id'=>$id));
		if($pvv!=null){
			$medec = array();
			foreach ($pvv as $k=>$v):
				//if( ($k!='educteur') ):
		        	$medec[$k] = $v;
		    	//endif;
			endforeach;
			//$medec['e'] = $this->lg->get_user($pvv['educateur']);
			return $medec;
		}else{
			return null;
		}
	}
}

