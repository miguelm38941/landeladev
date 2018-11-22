<html>
<head>
<?php
	include_once(__DIR__.'/head.php');
?>
</head>
<body>
<?php
	include_once(__DIR__.'/menu.php');
?>
<main>
<div class="container">
	<h5>Controles</h5>
<?php
	if($this->ion_auth->in_group('clients')){	
		$links = array();
	}else{
		$links = array('edit' => '/lns/check/mod');
	}
	foreach($datas as &$d){
		$infos = lns_get_check_status($d);
		$d['ccolor']=$infos['color'];		
	}
	echo lgedit_generate_table($table,$datas,false,$links);
?>
<a id="lgedit_add" href="#" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">add</i></a>
</div>
</main>
</body>
</html>
