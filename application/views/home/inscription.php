<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
<script type="text/javascript">

window.formredirect="<?= site_url('/welcome/thanks_registration') ?>";
$(document).ready(function(){
	$("select[name=educateur]").closest("div.row").remove();
	$("#lgedit_form form").append('<input type="hidden" name="educateur" value="tocheck"/>');	
});

</script>
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
	<h5></h5>
<?php
	$table='pvv';
	$datas=array();
	echo lgedit_generate_form($table,$datas,false);
?>
</div>
</main>
<br><br><br>
<?php include_once(APPPATH.'/views/footer.php'); ?>
</body>
</html>
