<html>
<head>
<?php
	include_once(__DIR__.'/../head.php');
?>
<script type="text/javascript">

	window.lgedit_form_reset=false;
$(document).ready(function(){
	$("#lgedit_form form").append('<input type="hidden" name="id" value="<?= $id ?>"/>');	
});

</script>
</head>
<body>
<?php
	include_once(__DIR__.'/../menu.php');
?>
<main>
<div class="container">
	<h5>Modifier Client</h5>
<?php
	echo lgedit_generate_form($table,$datas,true);
?>
</div>
</main>
</body>
</html>
