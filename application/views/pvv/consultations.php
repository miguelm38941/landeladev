<html>

<head>

<?php

	include_once(APPPATH.'/views/head.php');

?>
<script language="javascript">
$(document).ready(function() {
	var href = $('.links span a').attr('href');
	$('.links span a').attr('href', href+'/consultation');
});
</script>
</head>

<body>

<div class="wrapper">

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



</div>

</main>

</div>

<?php include_once(APPPATH.'/views/footer.php'); ?>

</body>

</html>

