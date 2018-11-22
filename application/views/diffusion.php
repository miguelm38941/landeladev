<html>

<head>

<?php

	include_once(APPPATH.'/views/head.php');

?>

<script type="text/javascript">

$(document).ready(function(){

	$("#societe_pharma").on('change',function(){

		var datas = {

			"id":<?= $commande['id'] ?>,

			"societe_pharma" : $(this).val()

		}

		$.post('<?= site_url('/backend/commandes/add_societe_pharma') ?>',datas,function(){

		});

	});

});

</script>
<style type="text/css" media="screen">
	#commande_summary caption { display: none; }
</style>

</head>

<body>

<div class="wrapper">

<?php

	include_once(APPPATH.'/views/menu.php');

?>

<main>

<div class="container">

<h2>Message N&deg;<?= str_pad($diffusion['id'], 8, "0", STR_PAD_LEFT) ?></h2>

<?php

	$dests = get_all_destinataires_commandes();

	$sc = get_societe_pharma();

	$can_save=false;

?>

<table id="commande_summary" border="1" style="width:95%">

<tr>

	<td>
		<h5 style="font-weight: bold;">Date:</h5>
		<p><?= $diffusion['created'] ?></p>
	</td>

</tr>
<tr>

	<td>
		<h5 style="font-weight: bold;">Sujet:</h5>
		<p><?= $diffusion['sujet'] ?></p>
	</td>

</tr>
<tr>

	<td>
		<h5 style="font-weight: bold;">Message:</h5>
		<p><?= $diffusion['message'] ?></p>
	</td>

</tr>

</table>

<div>


</div>

</main>

</div>

<?php include_once(APPPATH.'/views/footer.php'); ?>

</body>

</html>

