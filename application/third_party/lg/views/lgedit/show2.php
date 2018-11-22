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
<div class="container">
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
</div>
</main>
<br><br><br>
<?php include_once(APPPATH.'/views/footer.php'); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#myTable').pageMe({
	    pagerSelector:'#myPager',
	    activeColor: 'blue',
	    prevText:'Anterior',
	    nextText:'Siguiente',
	    showPrevNext:true,
	    hidePageNumbers:false,
	    perPage:10
  	});
});
</script>
</body>
</html>
