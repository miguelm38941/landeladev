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

<h4><?= strtoupper($datas['examen']) ?> : R&eacute;sultats d'examen </h4>

<br><br>

<div class="row">

	<div class="col s6">

		<table border="1" style="">

		<tr>

			<td style="font-weight:bold;">Date: </td>

			<td><?=  $datas['created'] ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Examen: </td>

			<td><?= !empty($datas['examen']) ?strtoupper($datas['examen']) : ''; ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Prescris par: </td>

			<td><?= !empty($datas['medecin']) ? ucfirst($datas['medecin']) : ''; ?></td>

		</tr>

		<tr>

			<td style="font-weight:bold;">Code PVV: </td>

			<td><?= ucfirst($datas['pvv']) ?></td>

		</tr>

		</table>

	</div>

	<div id="result_form" class="col s6" style="margin-top: -30px;">

		<div class="col s12" style="margin: 2px;">
			<a class="" style="padding:3px 5px; background-color:rgb(185,36,54); display: inline-block;" href="/backend/profile_pvv/<?= $datas['pvvid'] ?>/consultation">Retourner au dossier du pvv</a>
		</div>

		<div class="col s12" style="margin: 2px;">
			<h4>R&eacute;sultats</h4>
			<div>		
			<?php
				foreach(json_decode($datas['resultats']) as $k=>$v):
					echo '<div class="col s6" style="padding:5px;border-bottom:1px solid #eee;font-weight: bold;">'.$k.'</div>';
					echo '<div class="col s6" style="padding:5px;border-bottom:1px solid #eee;">'.$v.'</div>';
				endforeach;
			?>
			</div>
		</div>

	</div>

</div>



</div>

</main>

</div>

<?php include_once(APPPATH.'/views/footer.php'); ?>

</body>

</html>

