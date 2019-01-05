<html>

<head>

<?php

	include_once(APPPATH.'/views/head.php');

?>
<style>
.valeurnormale {
  margin-top: 20px;
}
</style>
<script type="text/javascript">

$(document).ready(function(){

    // run the currently selected effect
    function runEffect(examen) {
      // get effect type from
      var selectedEffect = 'slide';

      // Most effect types need no options passed by default
      var options = {};
 
      // Run the effect
      $( "#form_"+examen ).fadeToggle({
	    opacity: 1,
	    height: "toggle"
	  }, 1000, function() {
	    // Animation complete.
	  });
	};
 
    // Callback function to bring a hidden box back
    function callback() {
      setTimeout(function() {
        $( "#effect" ).removeAttr( "style" ).hide().fadeIn();
      }, 1000 );
    };
 
    // Set effect from select menu value
    $( "#btn_ge" ).on( "click", function() {
      $( "#form_nfs" ).fadeOut();
      runEffect('ge');
      return false;
    });
    // Set effect from select menu value
    $( "#btn_nfs" ).on( "click", function() {
      $( "#form_ge" ).fadeOut();
      runEffect('nfs');
      return false;
    });
    $( "#form_ge #btn_submit" ).click(function(e) {
    	/* Act on the event */
    	e.preventDefault();
		$.post(window.base_url+'/lgedit/add/resultat_examens',
		{
	    	pvv: $( "#form_ge .pvv" ).val(),
	    	consultation: $( "#form_ge .consultation" ).val(),
	    	prescription: $( "#form_ge .prescription" ).val(),
	    	medecin: $( "#form_ge .medecin" ).val(),
	    	examen: $( "#form_ge .examen" ).val(),
	    	criteria1: $( "#form_ge .criteria1" ).val(),
	    	criteria2: $( "#form_ge .criteria2" ).val(),
	    	criteria3: $( "#form_ge .criteria3" ).val(),
		},
		function(data, status){
	    	console.log(status);
		}).fail(function(){
			Materialize.toast('Echec attribution de la consultation', 3000);
		});    	
    });
    $( "#form_nfs #btn_submit" ).click(function(e) {
    	/* Act on the event */
    	e.preventDefault();
		$.post(window.base_url+'/lgedit/add/resultat_examens',
		{
	    	pvv: $( "#form_nfs .pvv" ).val(),
	    	consultation: $( "#form_nfs .consultation" ).val(),
	    	prescription: $( "#form_nfs .prescription" ).val(),
	    	medecin: $( "#form_nfs .medecin" ).val(),
	    	examen: $( "#form_nfs .examen" ).val(),
	    	criteria1: $( "#form_nfs .criteria1" ).val(),
	    	criteria2: $( "#form_nfs .criteria2" ).val(),
	    	criteria3: $( "#form_nfs .criteria3" ).val(),
		},
		function(data, status){
	    	console.log(status);
		}).fail(function(){
			Materialize.toast('Echec attribution de la consultation', 3000);
		});    	
    });

});
</script>

</head>

<body>

<div class="wrapper">

<?php

	include_once(APPPATH.'/views/menu.php');

?>

<br>

<main>

<div class="container">

<h4>Ordonnance N&deg; <?= $datas['id'] ?></h4>

<br><br>

<div class="row">

	<div class="col s6">

		<table border="1" style="">

		<tr>

			<td style="font-weight:bold;">Date: </td>

			<td><?=  date(  "d/m/Y" ) ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Consultation N&deg;: </td>

			<td><?= !empty($datas['consultation']) ? $datas['consultation'] : ''; ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">M&eacute;decin: </td>

			<td><?php //echo get_single_user($datas['user']); ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Code PVV: </td>

			<td><?= $datas['pvv'] ?></td>

		</tr>

		<?php

			if($datas['ge']='checked'){

		?>

		<tr>

			<td style="font-weight:bold;">Goute &eacute;paisse: </td>

			<td><button id="btn_ge" class="btn">Enregistrer les résultats</button></td>

		</tr>

		<?php

			}

		?>

		<?php

			if($datas['nfs']='checked'){

		?>

		<tr>

			<td style="font-weight:bold;">Num&eacute;ration: </td>

			<td><button id="btn_nfs" class="btn">Enregistrer les résultats</button></td>

		</tr>

		<?php

			}

		?>

		</table>

	</div>

	<div id="result_form" class="col s6" style="margin-top: -30px;">

		
		<form id="form_ge" action="#" style="display: none;">
		<h4>R&eacute;diger le bulletin : Goutte &eacute;paisse</h4>
			
		<input type="hidden" class="examen" name="examen" value="ge">
		<input type="hidden" class="pvv" name="pvv" value="<?= $datas['pvvid'] ?>">
		<input type="hidden" class="medecin" name="medecin" value="<?= $datas['medecinid'] ?>">
		<input type="hidden" class="consultation" name="consultation" value="<?= $datas['consultation'] ?>">
		<input type="hidden" class="prescription" name="prescription" value="<?= $datas['id'] ?>">

		<fieldset>
			<div class="col s12">
				<div class="input-field col s6">
					<label for="criteria1">Criteria 1</label>
					<input type="text" class="criteria1" name="criteria1">
				</div>
				<div class="col s6 valeurnormale">Valuer normale 1</div>
			</div>
			<div class="col s12">
				<div class="input-field col s6">
					<label for="criteria2">Criteria 2</label>
					<input type="text" class="criteria2" name="criteria2">
				</div>
				<div class="col s6 valeurnormale">Valuer normale 2</div>
			</div>
			<div class="col s12">
				<div class="input-field col s6">
					<label for="criteria3">Criteria 3</label>
					<input type="text" class="criteria3" name="criteria3">
				</div>
				<div class="col s6 valeurnormale">Valuer normale 3</div>
			</div>
			<br>
			<div>
				<button id="btn_submit" class="btn waves-effect waves-light btn-small">
					Enregistrer les résultats
				</button>
			</div>
		</fieldset>
		</form>

		<form id="form_nfs" action="#" style="display: none;">
		<h4>R&eacute;diger le bulletin : Num&eacute;ration</h4>
			
		<input type="hidden" class="examen" name="examen" value="nfs">
		<input type="hidden" class="pvv" name="pvv" value="<?= $datas['pvvid'] ?>">
		<input type="hidden" class="medecin" name="medecin" value="<?= $datas['medecinid'] ?>">
		<input type="hidden" class="consultation" name="consultation" value="<?= $datas['consultation'] ?>">
		<input type="hidden" class="prescription" name="prescription" value="<?= $datas['id'] ?>">

		<fieldset>
			<div class="col s12">
				<div class="input-field col s6">
					<label for="criteria1">Criteria 1</label>
					<input type="text" class="criteria1" name="criteria1">
				</div>
				<div class="col s6 valeurnormale">Valuer normale 1</div>
			</div>
			<div class="col s12">
				<div class="input-field col s6">
					<label for="criteria2">Criteria 2</label>
					<input type="text" class="criteria2" name="criteria2">
				</div>
				<div class="col s6 valeurnormale">Valuer normale 2</div>
			</div>
			<div class="col s12">
				<div class="input-field col s6">
					<label for="criteria3">Criteria 3</label>
					<input type="text" class="criteria3" name="criteria3">
				</div>
				<div class="col s6 valeurnormale">Valuer normale 3</div>
			</div>
			<br>
			<div>
				<button id="btn_submit" class="btn waves-effect waves-light btn-small">
					Enregistrer les résultats
				</button>
			</div>
		</fieldset>
		</form>


	</div>

</div>



</div>

</main>

</div>

<?php include_once(APPPATH.'/views/footer.php'); ?>

</body>

</html>

