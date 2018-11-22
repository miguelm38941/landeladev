<?php

function convert_pdf($file,$folder,$quality=300){
	//echo "converting ".$pdf.PHP_EOL;
	$n=get_pdf_pages_number($file);
	$ns = range(1,$n,1);

	$mcpus = ceil($n/10);
	//error_log($n."pages ");
	//echo $n."pages ".PHP_EOL;
	$rcpus = get_cpu_core_numbers();

	$cpus = min($mcpus,$rcpus);
	//$cpus=7;
		
	require_once(APPPATH."/libraries/Thread.php");

	if(Thread::available() && $cpus > 1){
		$threads = array();

		$pages = array_chunk($ns,ceil($n/$cpus));

		//print_r($pages);
		for($i=0;$i < $cpus;$i++){
			$ps = $pages[$i];
			$thread = new Thread( 'convert_pdf_cmd' );
			$thread->start($i,$file,$folder,$quality,reset($ps),end($ps));
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
		convert_pdf_cmd(0,$file,$folder,$quality);
	}

	sleep(5);

	$thumbsdir=$folder."/thumbs";
	mkdir($thumbsdir);
	//convert_pdf_cmd($file,$folder,$quality,floor($n/2),$n);

	exec("cp -r {$folder}/*.jpeg {$thumbsdir}/.",$out,$exit);
	exec("gm mogrify -thumbnail x300 -quality 100 {$thumbsdir}/*.jpeg",$out,$exit);

	sleep(5);
}


function convert_pdf_cmd($thread,$file,$folder,$quality,$from=false,$to=false){

	$cmd = "gs -q ";
	$cmd .= "-dQUIET -dSAFER -dBATCH -dNOPAUSE -dNOPROMPT ";
	$cmd .= "-sBandListStorage=memory ";
	$cmd .= "-dBufferSpace=1000000000 ";
	$cmd .= "-dBandHeight=100 ";
	$cmd .= "-dNumRenderingThreads=8 ";
	$cmd .= "-dMaxBitmap=500000000 ";
	$cmd .= "-dAlignToPixels=0 ";
	$cmd .= "-dGridFitTT=2 ";
	$cmd .= "-sDEVICE=jpeg ";
	//$cmd .= "-g1653x2339 ";
	$cmd .= "-r{$quality}x{$quality} ";
	$cmd .= "-sOutputFile={$folder}/image-{$thread}%08d.jpeg ";
	$cmd .= '-c "2000000000 setvmthreshold" ';
	if($from)
		$cmd .= "-dFirstPage=".$from." ";
	if($to)
		$cmd .= "-dLastPage=".$to." ";
	$cmd .= "-f{$file}";

	//echo $cmd.PHP_EOL;
	exec($cmd,$out,$exit);

}


function get_pdf_pages_number($f){

	$stream = fopen($f, "r");
	$content = fread ($stream, filesize($f));

	if(!$stream || !$content)
	    return 0;

	$count = 0;
	$regex = "/\/Count\s+([0-9]+)/s";
	// Other regular expressions found
	$regex2 = "/\/Page\W/";
	$regex3 = "/\/N\s+/";
	
	$count=0;
	if(preg_match_all($regex, $content, $matches)){
		if(!empty($matches)){
			$count = max($matches);
			if(is_array($count)){
				$count=max($count);
			}		
		}
	}
	
	if($count == 0 && preg_match_all($regex2, $content, $matches)){
		if(!empty($matches)){
			$count = $matches[0];
			$count=count($count);
		}
	}

	if(is_numeric($count)){
		return $count;
	}else{
		return 0;
	}

}

function get_cpu_core_numbers(){
	$cmd = "cat /proc/cpuinfo | grep processor | wc -l";
	$cpuCoreNo = intval(trim(shell_exec($cmd)));
	return $cpuCoreNo;
}

?>
