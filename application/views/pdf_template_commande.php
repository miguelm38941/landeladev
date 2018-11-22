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
	caption { display: none; }
</style>

</head>

<body>

<div class="wrapper">

<main>

<div class="container">
<div id="dvprinting">

<h2>Commande de medicament</h2>



<?php

	$dests = get_all_destinataires_commandes();
	$sc = get_societe_pharma();
	$can_save=false;
	$acheteur = getCompany($commande['acheteur']);

?>

<table id="commande_summary" class="marginleft" border="1" style="width:50%">

<tr>

	<td colspan="2"  style="">Commande N&deg;: <?= $commande['id']; ?></td>

</tr>
<tr>

	<td>De:</td>

	<td><?= $acheteur; ?></td>

</tr>
<tr>

	<td>Destinataire:</td>

	<td><?= $dests[$commande['destinataire']]?></td>

</tr>
<tr>

	<td>Date :</td>

	<td><?= (isset($commande['sent']))? $commande['sent'] : 'N/A' ?></td>

</tr>
<?php //if(isset($commande['delivered'])) { ?>
<tr>

	<td>Date de livraison :</td>

	<td><?= (isset($commande['delivered']))? $commande['delivered'] : 'En cours' ?></td>

</tr>
<?php //} ?>
<tr>

	<td colspan="2" style="height: 30px;">&nbsp;</td>

</tr>

<!--

<tr>

	<td>Societe :</td>

	<td>

	<?php 

			if(isset($commande['societe_pharma']) && !empty($commande['societe_pharma'])){

				 echo  $sc[$commande['societe_pharma']];

				$can_save=false;

			}else{

				echo '<select id="societe_pharma">';

				echo '<option value="">Selectioner</option>';

				foreach($sc as $k => $v){

					echo '<option value="'.$k.'">'.$v.'</option>';

				}

				echo '</select>';

			}

	?>

	</td>

</tr>http://127.0.0.1/landela/backend/commandes/deliver/

-->

</table>



<div id="" class="marginleft marginright">

<form action="<?= site_url('/lgedit/add/commandes/') ?>" method="post">

	<?php $ps = json_decode($commande['produits'],true); ?>

	<table border=1>

	<thead>

		<th>Designation</th>

		<th>Quantite</th>

		<?php if( (!isset($commande['delivered']) || $commande['delivered']=='') && !empty($ps[0]['peremption']) ) : ?>

			<th>Date de p&eacute;remption</th>

		<?php endif; ?>

	</thead>

	<tbody>

	<?php

		$prods = get_produits();

		foreach($ps as $p){

			echo "<tr>";

			echo "<td>".$prods[$p['produit']]."</td>";

			echo "<td>".$p['quantite']."</td>";

			if((!isset($commande['delivered']) || $commande['delivered']=='') && !empty($ps[0]['peremption'])){
				echo "<td>".$p['peremption']."</td>";
			}

			echo "</tr>";

		}

	?>

	</tbody>

	</table>

</form>

</div>

<div>
</div>
</div>

<button id="btnPrint" class="btn" type="button" style="margin-top:20px;" >Imprimer</button>
&nbsp;
<?php
	if(isset($referer)){
?>
<a class="btn" href="<?= $referer ?>">BACK</a>
<?php
	}
?>
</div>

</main>

</div>

</body>

</html>

