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
<main>
<div class="container">

<h1>Rechercher PVV</h1>
<form method="POST" action="<?= site_url('/backend/profile_pvv/') ?>">
          <input id="search" name="search" type="search" required>
          <label class="label-icon" for="search"><i class="material-icons">search</i></label>
          <i class="material-icons">close</i>
        </div>

	
      </form>

</div>
</main>
</body>
</html>
