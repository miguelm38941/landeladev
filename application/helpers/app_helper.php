<?php

function randColor( $numColors ) {
    $chars = "ABCDEF0123456789";   
    $size = strlen( $chars );
    $str = array();
    for( $i = 0; $i < $numColors; $i++ ) {
		$str[$i]="#";
        for( $j = 0; $j < 6; $j++ ) {
            $str[$i] .= $chars[ rand( 0, $size - 1 ) ];
        }
    }
    return $str;
}

setlocale(LC_ALL, 'en_US.UTF8');
function toAscii($str, $replace=array(), $delimiter='-') {
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}

	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	return $clean;
}

function _updateStatus($res){
	//echo "converting ".$pdf.PHP_EOL;
	//error_log($n."pages ");
	//echo $n."pages ".PHP_EOL;
	$rcpus = get_cpu_core_numbers();

	$cpus = min($mcpus,$rcpus);
	//$cpus=7;
		
	require_once(APPPATH."/libraries/Thread.php");

	if(Thread::available() && $cpus > 1){
		echo "Thread".PHP_EOL;
		$threads = array();

		$res2 = array_chunk($res,ceil($n/$cpus));

		//print_r($pages);
		for($i=0;$i < $cpus;$i++){
			$r = $res2[$i];
			$thread = new Thread( '__updateStatus' );
			$thread->start($r);
			$threads[] = &$thread;
		}

		while(1){
			$finish=true;
			foreach($threads as &$thread){
				if($thread->isAlive()){
					$finish=false;
					break;
				}
			}

			if($finish==false){
				//echo "thread still actives".PHP_EOL;
				sleep(2);
			}else{
				//echo "finish".PHP_EOL;
				break;
			}
		}
	}else{
		__updateStatus($res);
	}

	sleep(5);

}

function __updateStatus(&$res){
	$CI =& get_instance();
	foreach($res as $r){
		$res2 = $CI->smssender->get_infos($r['provider'],$r['provider_id']);
		print_r($res2);
		//$r['state']=$res2['message_state'];
		if($res2['message_state'] != 'sent'){
			$CI->msms->set_status($r['provider'],$r['provider_id'],$res2['message_state']);
		}
	}
}



?>
