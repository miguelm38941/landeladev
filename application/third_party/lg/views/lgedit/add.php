<html>
<head>
<?php
include_once(APPPATH.'/views/head.php');
//if($this->ion_auth->in_group(array('medecin'))){
$lgedit_peremption_hide=false;
if($table=='commandes'){
	$lgedit_peremption_hide=true;
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#lgedit_peremption").hide();
	});
	</script>
	<?php
}
?>

<script type="text/javascript">

$(document).ready(function(){
	//$('select[name=').
	$.fn.exists = function() { return this.length > 0; };
	//$("#lgedit_peremption").hide();

	// later ...
	$(".btn").click(function(e){
		var quantite_produit = $("#lgedit_quantite").val();
		var table= '<?php echo $table; ?>';

		if( table==='commandes'){ 
			if ( quantite_produit.exists() ) {
				if(quantite_produit!=''){
					alert('Ne peut etre vide');
					e.preventDefault(e);
				}else{
					alert(quantite_produit);
				}
			}		
		}
	})
});

</script>
</head>
<body>
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
	<h5><?= $title ?> <?php echo ($table=='ordonnances') ?' : Consultation '.$datas['consultation']:''; ?></h5>
	<br><br>
<?php
	echo lgedit_generate_form($table,$datas,false);
	if($referer){
?>
<a class="btn" href="<?= $referer ?>">BACK</a>
<?php
	}
?>
</div>
</main>
<br><br><br>
<?php include_once(APPPATH.'/views/footer.php'); ?>
</body>
</html>
