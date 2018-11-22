<?php

class SmsSender {

	var $context;
	var $cookie;
	var $headers;
	
	function __construct(){
		$CI =& get_instance();
		$CI->load->helper('plivo');
		$CI->load->model('msms');
	
	 	$auth_id = "MAMJAZMDUWZDA4NZRKOT";
    	$auth_token = "NDg5MTIwZGFmNWMxNTgzNjgwOGU4ZTYyZTEzMjNk";
    	$this->sender = new Plivo\RestAPI($auth_id, $auth_token);
	}

	function get_infos($provider,$provider_id){
		$params = array(
				'record_id' => $provider_id 
				);
		$response = $this->sender->get_message($params);
		// Print the response
		return $response['response'];
	}

	function send_sms($sms_id,$src,$dst,$msg){

		//$dst[]="0022670973984";	
		$cdsts = array_chunk($dst,100);
		$results=array();
		foreach($cdsts as $cdst){
			$res=$this->_send_sms($sms_id,$src,$cdst,$msg);
			//print_r($res);
			$results[]=$res;
		}

		return $results;
	}

	function _send_sms($sms_id,$src,$dst,$msg){
		$CI =& get_instance();
    
		if(is_array($dst)){
			$dst2 = implode("<",$dst);
		}else{
			$dst2 = $dst;
			$dst=array($dst);
		}
		
		$params = array(
            'src' => $src, // Sender's phone number with country code
            'dst' => $dst2, // Receiver's phone number with country code
            'text' => $msg // Your SMS text message
        );
   		// Send message
    	$response = $this->sender->send_message($params);
    	//print_r($response['response']);
    	// Print the Api ID
    	//echo "<br> Api ID : {$response['response']['api_id']} <br>";
    	// Print the Message UUID
    	//echo "Message UUID : {$response['response']['message_uuid'][0]} <br>";
		
		//$id=$response['response']['message_uuid'][0];
		/*
		$ids = array();
		foreach($response['response']['message_uuid'] as $msgid){
			$ids[]=$msgid;
		}
		*/

		if(isset($response['response']['message_uuid'])){
			$CI->msms->sent($sms_id,'plivo',$src,$dst,$response['response']['message_uuid']);
		}
		return $response;
	}	

}

?>
