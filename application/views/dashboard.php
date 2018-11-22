<html>
<head>
<?php
	include_once(__DIR__.'/head.php');
?>
<script type="text/javascript">
$(window).ready(function(){
	var ctx = document.getElementById("passages").getContext("2d");	
	var datas = {
		//labels: ["January", "February", "March", "April", "May", "June", "July"],
		labels: <?= json_encode(array_column($checks_by_date,'date')) ?>,
		datasets: [{
			label: "Passages",
			data: <?= json_encode(array_column($checks_by_date,'total')) ?>,
			fill: false
			}
		]		
	};

	var options = {
		scales: {
    		xAxes: [{
      			type: 'time',
      			unit: 'day',
      			unitStepSize: 1,
      			time: {
      				displayFormats: {
           				'day': 'MMM DD'
        			}
        		}
        	}]
		}
	};
	var myLineChart = new Chart(ctx, {
   		type: 'line',
    	data: datas,
   		options: options
	});
});
</script>
</head>
<body class='dashboard'>
<?php
	include_once(__DIR__.'/menu.php');
?>
<main>
<div class="container">
<?php
	
	$html ="<div class='row'>";

	$html .="<div class='col s12 m12 l6'>"; 
	$html .= "<h5>Etat Systeme</h5>";
	$html .="<div class='row'>";

	$found = false;
	$colors = array();
	foreach($datas as $data){

		$status = lns_get_machine_status($data['id']); 
		
		//if($status['status'] == 'good' || $status['status'] == 'unknow') continue;

		$found = true;
		$color = $status['color'];
		if(!isset($colors[$color])) $colors[$color]=0;
		$colors[$color]++;

	}
	if(!$found){
		$html.='<div class="card green"><div class="card-content white-text">
              <span class="card-title">Toutes les clims sont ok</span>
            </div></div>';
	}else{
		$cs = array('red','orange','yellow','green','grey');
		foreach($cs as $c){
			$html.='<div class="col s2">';

			$tot = isset($colors[$c]) ? $colors[$c] : 0;

			$html.='<div class="card '.$c.' darken-3"><div class="card-content white-text">
              <span class="card-title"><a href="'.site_url('/backend/machines/color/'.$c).'">'.$tot.'</a></span>
            </div></div>';
			$html .= "</div>";
		}
	}	
	$html .= "</div>";

	$html .= "<div>";
	$html .= "<h5>Passages</h5>";
	$html .= '<canvas id="passages" style="width:100%;height:75px" ></canvas>';
	$html .= "</div>";
	
	$html .= "</div>";
	$html .="<div class='col s12 m12 l6'>"; 
	$html .= "<h5>Prochains passages</h5>";

	$html .= "<div>";
	$datas = array_reverse($last_checks);
	$areas = array();
	$dat = strtotime("-3 months");
	$dat = date('Y-m-d',$dat);
	foreach($datas as $data){	
		if($data['date'] < $dat ){

			//date plus recente du dernier check
			if(!isset($areas[$data['area_id']]) || $areas[$data['area_id']]['date'] < $dat )
				$areas[$data['area_id']]=$data;
			//$html .= $data['machine']." -- ".$data['date']."<br/>";
		}
	}
	function lns_sort($a,$b){
		if($a['date'] == $b['date']) return 0;
		return $a['date'] > $b['date'] ? 1 : -1;
	}
	usort($areas,"lns_sort");
	/*
	foreach($areas as $a){
		$html.='<div class="card"><div class="card-content">';
		$html.='<span class="card-title">'.$a['area_name'].' '.$a['area_code'].'</span>';
		$html.='<p>'.$a['client_name'].'<br/> Dernier controlle : <a class="blue-text" href="'.site_url('/lns/checks/area/'.$a['area_id']).'">'.$a['date'].'</a></p>';
		$html.="</div></div>";
	}
*/
	$html .= "<table>";
	$html .= "<thead><tr><th>Lieu</th><th>Client</th><th>Dernier controle</th></tr></thead>";
	
	foreach($areas as $a){
		$html.='<tr><td>'.$a['area_name'].' '.$a['area_code'].'</td><td>'.$a['client_name'].'</td><td><a class="blue-text" href="'.site_url('/backend/checks/area/'.$a['area_id']).'">'.$a['date'].'</a></td><tr>';
	
	}
	$html .= "</table>";
	$html .= "</div>";
		
	$html .= "</div>";
	$html .= "</div>";
	echo $html;
?>
</div>
</main>
<br><br><br>
<?php include_once(APPPATH.'/views/footer.php'); ?>
</body>
</html>
