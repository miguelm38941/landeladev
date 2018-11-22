<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
</head>
<body>
<nav>
	<div class="nav-wrapper">
		<a href="<?= site_url('/') ?>" class="brand-logo"><img src="<?= base_url('/logo.png') ?>"/></a>
	</div>
</nav>
<div class="container">
<h1><?php echo lang('login_heading');?></h1>
<p><?php echo lang('login_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/login");?>

  <p>
    <?php echo lang('login_group_label', 'groupe');?>
    <?php echo form_dropdown('groupe', $group);?>
  </p>

  <p>
    <?php echo lang('login_identity_label', 'identity');?>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <?php echo lang('login_password_label', 'password');?>
    <?php echo form_input($password);?>
  </p>

  <p>
    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
    <?php echo lang('login_remember_label', 'remember');?>
  </p>


  <p><?php echo form_submit('submit', lang('login_submit_btn'), array('class' => 'btn'));?></p>

<?php echo form_close();?>

<p><a class='btn' href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>

</div>
