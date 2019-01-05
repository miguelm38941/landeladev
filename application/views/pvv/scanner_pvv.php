<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
    <script language="JavaScript">

			function user_delete(user_id, user_name) {

				var r = confirm("Delete user "+user_name+" ?");

				if (r == true) {

					push('user.php?action=delete&user_id='+user_id);

				}
			}
			
			function user_register(user_id, user_name) {
				
				//$('body').ajaxMask();
			
				regStats = 0;
				regCt = -1;
				try
				{
					timer_register.stop();
				}
				catch(err)	
				{
					console.log('Registration timer has been init');
				}
				
				
				var limit = 4;
				var ct = 1;
				var timeout = 5000;
				
				timer_register = $.timer(timeout, function() {					
					console.log("'"+user_name+"' registration checking...");
					//console.log("count : "+$("#user_finger").html());
					user_checkregister(user_id,$("#user_finger").html());
					if (ct>=limit || regStats==1) 
					{
						timer_register.stop();
						console.log("'"+user_name+"' registration checking end");
						if (ct>=limit && regStats==0)
						{
							alert("'"+user_name+"' Echec de l\'enregistrement!");
							//$('body').ajaxMask({ stop: true });
						}						
						if (regStats==1)
						{
							$("#user_finger").html(regCt);
							alert("'"+user_name+"' Enregistrement reussi!");
							//$('body').ajaxMask({ stop: true });
							//load('user.php?action=index');
						}
					}
					ct++;
				});
			}
			
			function user_checkregister(user_id, current) {
				console.log("backend/fingerprint/checkreg?user_id="+user_id+"&current="+current);
				var baseurl = "<?php echo base_url(); ?>";
				$.ajax({
					url			:	baseurl+"backend/fingerprint/checkreg?user_id="+user_id+"&current="+current,
					type		:	"GET",
					success		:	function(data)
									{
										console.log(data);
										try
										{
											var res = jQuery.parseJSON(data);	
											if (res.result)
											{
												regStats = 1;
												$.each(res, function(key, value){
													if (key=='current')
													{			
														regCt = value;
													}
												});
											}
										}
										catch(err)
										{
											alert(err.message);
										}
									}
				});
			}

</script>

</head>
<body>
<div class="wrapper">
<?php
	include_once(APPPATH.'/views/menu.php');
?>
<main>
<div class="container">
<h2>Profil PVV</h2>
<br>
<div class="row">
	<div class="col s4">
		&nbsp;
	</div>
	<div class="col s4">
		<div style="display:inline-block;">
			<img src="../../../images/qrcode.png"  style="width:80px;" />
			<br>
		<a style="color:#000;font-weight:bold;border:1px solid #333;padding:5px;" href="<?php echo str_replace('index.php', '', $_SERVER['PHP_SELF']); ?>backend/profile_pvv/<?php echo $pvvdatas['id']; ?>/qrprint">
			Imprimer le Code QR
		</a>
		</div>
		<?php //if(!$this->ion_auth->in_group(array('pharmacie'))){?>
		<div style="display:inline-block;">
			<img src="../../../images/fingerprint.jpg"  style="width:80px;" />
			<br>
		<?php 		
//backend/fingerprint/fverify class='btn btn-xs btn-primary'
			$user_id = $pvvdatas['id'];
			$register = ''; 
			$verification = '';
			//if():
				//echo base_url()."backend/fingerprint/fregister/".$user_id; exit;
				$register			= '';
				$verification		= '';
				$url_register		= base64_encode(base_url()."backend/fingerprint/fregister/".$user_id);
				//$url_register		= base64_encode('http://landela.org/register.php?user_id=63');
				$url_verification	= base64_encode(base_url()."backend/fingerprint/fverify/".$user_id);
				
				if( (isset($finger) && count($finger) > 0) ) {

					$verification = "<a style='color:#000;font-weight:bold;border:1px solid #333;padding:5px;margin-left: 10px;text-align: center;' href='finspot:FingerspotVer;$url_verification'>V&eacute;rifier l'identit&eacute;</a>";
					echo $verification;
				} else {
					$register = "<a style='color:#000;font-weight:bold;border:1px solid #333;padding:5px;margin-left: 10px;text-align: center;' href='finspot:FingerspotReg;$url_register' onclick=\"user_register('".$user_id."','".$pvvdatas['username']."')\">Enregistrer l'empreinte</a>";
					echo $register;
				}
		?>
		</div>
		<?php //} ?>
		<div><code id="user_finger" style="visibility: hidden;"><?php if(isset($finger) && is_object($finger)){ echo count($finger);}else{echo '0';} ?></code></div>
		<br><br>
			
	</div>
	<div class="col s4">
		&nbsp;
	</div>
</div>
</div>
</main>
</div>
<?php include_once(APPPATH.'/views/footer.php'); ?>
</body>
</html>
