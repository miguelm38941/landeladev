<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
<script type="text/javascript">
$(document).ready(function(){
	var msg = $("#message").val();
	$("#message").keyup(function(event) {
		if( $("#message").val().length>0 ) { $("span#error").fadeOut(); }
	});
	$("#sendAlerteForm").submit(function(event) {
		if ( $("#message").val().length==0 ) { 
			event.preventDefault();
			$("span#error").html('Vous devez r&eacute;diger un message &agrave; envoyer.');
			$("span#error").fadeIn(); 
		}		
	});
	/*$("#societe_pharma").on('change',function(){
		var datas = {
			"id":<?= $commande['id'] ?>,
			"societe_pharma" : $(this).val()
		}
		$.post('<?= site_url('/backend/commandes/add_societe_pharma') ?>',datas,function(){
		});
	});*/
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
	<br><br>

<div class="row">
	<div class="col s8">
		<h5>Les derniers rappels</h5>
		<hr style="border:2px solid rgb(185,36,54);">

		<table border=1>
		<thead style="background:#e2e2e2;">
			<th style="width:30%;">Date</th>
			<!--th style="width:30%;">De</th-->
			<th style="width:40%;">Produit</th>
			<th style="width:30%;">Quantit&eacute;</th>
		</thead>
		<tbody>
		<?php
			//$prods = get_produits();
			//$ps = json_decode($ordonnance['produits'],true);
			if(count($received_alertes)){
				$i=0;
				foreach($received_alertes as $alerte){
					if($i<10){
						echo "<tr>";
						echo "<td>
								<span>".date('d-m-Y',$alerte['date'])."</span>
								&nbsp; 
								<span style='color:#aaa'>".date('h:i',$alerte['date'])."</span>
							</td>";
						//echo "<td>".$alerte['sender']." - ".$alerte['sender_nom']."</td>";
						echo "<td>".$alerte['product']."</td>";
						echo "<td>".$stock['quantite']."</td>";
						echo "</tr>";
					}
					$i++;
				}
			}else{
				echo "<tr>";
				echo "<td colspan='3'>Aucune alerte par e-mail n'a &eacute;t&eacute; trouv&eacute;e.</td>";
				echo "</tr>";
			}
		?>
		</tbody>
		</table>

	</div>
	<div class="col s4" style="border: 1px solid rgb(185,36,54);">
		<h5>Envoyer un rappel par e-mail</h5>
		<hr style="border:2px solid rgb(185,36,54);">

		<table border="1" style="">
		<tr>
			<td style=""><b>Envoyer &agrave; :</b> <?= $nom_organisation ?></td>
		</tr>
		<tr>
			<td style=""><b>Produit concern&eacute; :</b> <?= $nom_produit ?></td>
		</tr>
		<tr>
			<td style=""> 
				<form id="sendAlerteForm" action="<?= site_url('/backend/mail_alertes/'.isset($stock['id']) ? $stock['id']:$stock.'/send') ?>" method="post">
					<b>Message</b> <span id="error" style="color:#ff0000;display:none;"></span> <br>
					<textarea style="width:100%;height:80px;border:1px solid #ccc;" name="message" id="message"></textarea>
					<br><br>
					<div>
						<input class="btn" type="submit" value="Envoyer">
					</div>
				</form> 
			</td>
		</tr>
		</table>

	</div>
</div>


</div>
</main>
</div>
<?php include_once(APPPATH.'/views/footer.php'); ?>
</body>
</html>
