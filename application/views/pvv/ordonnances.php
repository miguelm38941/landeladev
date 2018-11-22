<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA

<!--h1>Rechercher PVV</h1>
<form method="POST" action="<?= site_url('/backend/ordonnances/pvv') ?>">
        <div class="input-field">
          <input id="search" name="search" type="search" required>
          <label class="label-icon" for="search"><i class="material-icons">search</i></label>
          <i class="material-icons">close</i>
        </div>

	
</form-->

<h2><?= isset($title) ? $title : "" ?></h2>
<div class="row">
<?php
	echo lgedit_generate_table($table,$datas,$options);
?>
<?php
	if(isset($can_add) && $can_add){
		$url = '/lgedit/addPage/'.$table;
		if(isset($add_params) && is_array($add_params)){
			foreach($add_params as $k => $v){
				$url .= "/$k/$v";
			}
		}
?>
<a id="lgedit_add" href="<?= site_url($url) ?>" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">add</i></a>
<?php
	}
?>

</div>
</main>
</body>
</html>
