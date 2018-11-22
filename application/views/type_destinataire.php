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
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
<h5>Commande de medicament</h5>

<form action="<?php echo site_url('lgedit/addPage/commandes/'); ?>" method="GET" data-table="commandes"><div class="row "><div class="input-field col s12">
	<select id="lgedit_type_destinataire" name="type_destinataire" class="validate  initialized">	 
		<option value="" disabled="" selected="">Catégorie du destinataire de la commande</option>	  <option value="partenaires">Partenaires</option>
		<option value="zones">Zones</option>
	</select>        

	<div class="input-field">
		<input class="btn waves-effect waves-light" type="submit" name="action" value="Continuer">
</form>
</div>
</main>
</body>
</html>
