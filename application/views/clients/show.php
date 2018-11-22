<html>
<head>
<?php
	include_once(__DIR__.'/../head.php');
?>
</head>
<body>
<?php
	include_once(__DIR__.'/../menu.php');
?>
<main>
<div class="container">
	<h5>Clients</h5>
<?php
	$links = array(
		'input' => '/lns/areas/'
	);
	
	foreach($datas as &$data){
		$infos = lns_get_client_status($data['id']);
		$data['ccolor']=$infos['color'];		
		
		$data['ctitle'] = $data['nom'];
		
		$content = 'Tel : '.$data['tel'].'<br/>';
		$content .= 'Email : '.$data['email'].'<br/>';
		$reveal = 'IFU : '.$data['ifu'].'<br/>';
		$reveal .= 'Addresse : '.$data['cap'].'<br/>';
		$data['ccontent']=$content;
		$data['creveal']=$reveal;
	}

	echo lgedit_generate_form($table);
	echo lgedit_generate_cards($table,$datas,array('edit' => '/backend/client/edit/','lieux' => '/backend/areas/'));
//	echo lgedit_generate_table($table,$datas,true,false,$links['input']);
?>
<a id="lgedit_add" href="#" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">add</i></a>
</div>
</main>
</body>
</html>
