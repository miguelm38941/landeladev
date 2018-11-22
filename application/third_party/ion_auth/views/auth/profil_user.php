<html>
<head>
<?php
	include_once(APPPATH.'/views/head.php');
?>
</head>
<body>

<?php
  include_once(APPPATH.'/views/menu.php');
?>
<!--nav>
	<div class="nav-wrapper">
		<a href="<?= site_url('/backend/') ?>" class="brand-logo"><img src="<?= base_url('/logo.png') ?>"/></a>
	</div>
</nav-->
<div class="container">
<h1><?php echo $title;?></h1>
<p><?php //echo lang('edit_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(uri_string());?>
      <p>
            <?php echo '<label for="username">Username</label>' ?><br />
            <p><?php echo $username['value'];?></p>
      </p>
      
	  <p>
            <?php echo '<label for="email">Email</label>' ?><br />
            <p><?php echo $email['value'];?></p>
      </p>

      <p>
            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
            <p><?php echo $first_name['value'];?></p>
      </p>

      <p>
            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
            <p><?php echo $last_name['value'];?></p>
      </p>

      <!--p>
            <?php //echo lang('create_user_company_label', 'organisation');?> <br />
            <p><?php //echo $organisation["options"][$organisation["selected"]];?></p>
      </p-->

      <p>
            <?php echo lang('edit_user_phone_label', 'phone');?> <br />
            <p><?php echo $phone['value'];?></p>
      </p>


<?php echo form_close();?>

</div>
