<html>
<body>
	<!--p><?php //echo sprintf(lang('email_activate_heading'), $identity);?></p-->
	<p><?php echo sprintf(lang('email_activate_content'), $identity);?></p>
	<p><?php echo sprintf(lang('email_activate_username'), $identity);?></p>
	<p><?php echo sprintf(lang('email_activate_password'), $password);?></p>
	<p><?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link')));?></</body>
</html>