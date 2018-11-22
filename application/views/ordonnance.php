<html>

<head>

<?php

	include_once(APPPATH.'/views/head.php');

?>

</head>

<body>

<div class="wrapper">

<?php

	include_once(APPPATH.'/views/menu.php');

?>

<br>

<main>

<div class="container">

<h4>Ordonnance N&deg; <?= $ordonnance['id'] ?></h4>

<br><br>

<div class="row">

	<div class="col s6">

		<table border="1" style="">

		<tr>

			<td style="font-weight:bold;">Date: </td>

			<td><?=  date(  "d/m/Y", strtotime( $ordonnance['created'] ) ) ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Consultation N&deg;: </td>

			<td><?= !empty($ordonnance['consultation']) ? $ordonnance['consultation'] : ''; ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">M&eacute;decin: </td>

			<td><?php echo get_single_user($ordonnance['user']); ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Code PVV: </td>

			<td><?= $pvv['code'] ?></td>

		</tr>

		<?php

			if(!$this->ion_auth->in_group(array('pharmacie'))){

		?>

		<tr>

			<td style="font-weight:bold;">PVV: </td>

			<td><?= $pvv['nom']." ".$pvv['prenom'] ?></td>

		</tr>

		<?php

			}

		?>

		<tr>

			<td style="font-weight:bold;">Date de la livraison: </td>

			<td><?= !empty($ordonnance['delivered']) ?  date(  "d/m/Y", strtotime( $ordonnance['delivered'] ) ):'N/A' ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Etat: </td>

			<td><?= !empty($ordonnance['etat']) ? $ordonnance['etat']:'Non livr&eacute;e' ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Pharmacie: </td>

			<td><?php if(!empty($ordonnance['prepose_pharmacie'])) echo get_single_user($ordonnance['prepose_pharmacie']); ?></td>

		</tr>

		</table>

	</div>

	<div class="col s6" style="border:1px solid #e2e2e2;">

		<table border=1>

		<thead style="background:#e2e2e2;">

			<th>M&eacute;dicaments</th>

			<th>Quantit&eacute;</th>

			<th>Posologie</th>

		</thead>

		<tbody>

		<?php

			$prods = get_produits();
			$ps = json_decode($ordonnance['produits'],true);
/*var_dump($ps); exit;
echo "<br><br>";
var_dump($prods); exit;*/

			foreach($ps as $p){

				echo "<tr>";

				echo "<td>".$prods[$p['produit']]."</td>";

				echo "<td>".$p['quantite']."</td>";

				echo "<td>".$p['posologie']."</td>";

				echo "</tr>";

			}

		?>

		</tbody>

		</table>

		<?php

			if($this->ion_auth->in_group(array('pharmacie')) && !isset($ordonnance['delivered'])){

		?>

		<div>

			<a class="btn" href="<?= site_url('/backend/ordonnances/deliver/'.$ordonnance['id']) ?>">LIVRER</a>

		</div>

		<?php

			//}

			//elseif($this->ion_auth->in_group(array('medecin'))){

		?>

		<!--div>

			<a class="btn" href="<?= site_url('/backend/ordonnances/deliver/'.$ordonnance['id']) ?>">OBSERVATIONS</a>

		</div-->

		<?php

			}

		?>

	</div>

</div>



</div>

</main>

</div>

<?php include_once(APPPATH.'/views/footer.php'); ?>

</body>

</html>

