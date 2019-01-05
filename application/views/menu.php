<div class="navbar-fixed">
<nav id="menu">
	<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
	<div class="nav-wrapper">
		<a href="<?= site_url('/backend/') ?>" class="brand-logo"><img src="<?= base_url('/logo.png') ?>"/></a>

		<ul id="nav-mobile" class="right hide-on-med-and-down">
<?php	
	if($this->ion_auth->in_group(array('admin'))){	
?>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown1" >PVV<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdownProduits" >Produits<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown_suivicommandes" >Journal des commandes<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdownAlertes" >Alertes<i class="material-icons right">arrow_drop_down</i></a></li>
			<!--li><a href="<?= site_url('/backend/alertes') ?>">Alertes</a></li-->
			<li><a href="<?= site_url('/backend/diffusions') ?>">Informations</a></li>
			<li><a href="<?= site_url('/backend/questions') ?>">Questions</a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown4" >Acteurs<i class="material-icons right">arrow_drop_down</i></a></li>
<?php
	}else if($this->ion_auth->in_group(array('pnls'))){
?>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown4" >Acteurs<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown_suivicommandes" >Journal des commandes<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown3" >Commandes<i class="material-icons right">arrow_drop_down</i></a></li>	
			<li><a href="<?= site_url('/backend/ordonnances/all') ?>">Ordonnances</a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdownAlertes" >Alertes<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a href="<?= site_url('/backend/produits') ?>">Produits</a></li>
			<!--li><a href="<?= site_url('/backend/agent') ?>">Formation sanitaire</a></li>
			<li><a href="<?= site_url('/backend/medecin') ?>">Medecins</a></li>
			<li><a href="<?= site_url('/backend/societe_pharma') ?>">Societe Pharmaceutique</a></li>
			<li><a href="<?= site_url('/backend/partenaire') ?>">Partenaires</a></li>
			<li><a href="<?= site_url('/backend/pharmacie') ?>">Prepose pharmacie </a></li>
			<li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li-->
			
<?php
	}else if($this->ion_auth->in_group(array('ministere'))){
?>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown4" >Acteurs<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown_suivicommandes" >Journal des commandes<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown3" >Commandes<i class="material-icons right">arrow_drop_down</i></a></li>	
			<li><a href="<?= site_url('/backend/ordonnances/all') ?>">Ordonnances</a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdownAlertes" >Alertes<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a href="<?= site_url('/backend/produits') ?>">Produits</a></li>
			<!--li><a href="<?= site_url('/backend/agent') ?>">Formation sanitaire</a></li>
			<li><a href="<?= site_url('/backend/medecin') ?>">Medecins</a></li>
			<li><a href="<?= site_url('/backend/societe_pharma') ?>">Societe Pharmaceutique</a></li>
			<li><a href="<?= site_url('/backend/partenaire') ?>">Partenaires</a></li>
			<li><a href="<?= site_url('/backend/pharmacie') ?>">Prepose pharmacie </a></li>
			<li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li-->
			
<?php
	}else if($this->ion_auth->in_group(array('pharmacie'))){
?>
			<li><a  href="<?= site_url('/backend/scan_pvv') ?>">Scanner PVV</a></li>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown3" >Commandes<i class="material-icons right">arrow_drop_down</i></a></li>
			<li><a href="<?= site_url('/backend/alertes') ?>">Alertes</a></li>
			<li><a href="<?= site_url('/backend/stock') ?>">Stock</a></li>
			<!--li><a href="<?= site_url('/backend/pvv/ordonnances') ?>">Ordonnances</a></li-->
			<li><a href="<?= site_url('/backend/ordonnances') ?>">Ordonnances</a></li>
<?php
	}else if($this->ion_auth->in_group(array('medecin'))){
?>
		<?php if($this->ion_auth->in_group(array('pointfocal'))){ ?>
			<li><a href="<?= site_url('/backend/medecin') ?>">M&eacute;decins</a></li>
		<?php } ?>
			<li><a href="<?= site_url('/backend/consultations') ?>">Consultations</a></li>
			<li><a href="<?= site_url('/backend/ordonnances') ?>">Ordonnances</a></li>
			<li><a href="<?= site_url('/backend/prescription_examens') ?>">Prescriptions d'examens</a></li>
			<!--li><a href="<?= site_url('/backend/pvv') ?>">PVV</a></li-->
			<!--li><a href="<?= site_url('/backend/profile_pvv') ?>">Profil PVV</a></li-->
			<li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li>
			<li><a href="<?= site_url('/backend/questions') ?>">Questions</a></li>
<?php
	}else if($this->ion_auth->in_group(array('agent'))){
?>
			<li><a  href="<?= site_url('/backend/scan_pvv') ?>">Scanner PVV</a></li>
			<li><a href="<?= site_url('/backend/consultations') ?>">Consultations</a></li>
			<li><a href="<?= site_url('/lgedit/addPage/pvv') ?>">ajouter PVV</a></li>
			<!--li><a href="<?= site_url('/backend/profile_pvv') ?>">Profil PVV</a></li-->
			<!--li><a href="<?= site_url('/backend/medecin') ?>">M&eacute;decins</a></li-->
			<li><a href="<?= site_url('/backend/educateur') ?>">Educateurs</a></li>
<?php
	}else if($this->ion_auth->in_group(array('educateur'))){
?>
			<li><a href="<?= site_url('/backend/pvv') ?>">Mes PVV</a></li>
			<li><a href="<?= site_url('/lgedit/addPage/pvv') ?>">ajouter PVV</a></li>
			<li><a href="<?= site_url('/backend/pvv/filter/tovalidate') ?>">PVV &agrave; valider</a></li>
			<li><a href="<?= site_url('/backend/questions') ?>">Questions</a></li>
<?php
	}else if($this->ion_auth->in_group(array('regionsante','zonesante','partenaire'))){
?>
		<li><a href="<?= site_url('/backend/stock') ?>">Stock</a></li>
		<li><a class="dropdown-button" href="#!" data-activates="dropdown3" >Commandes<i class="material-icons right">arrow_drop_down</i></a></li>
<?php
		if($this->ion_auth->in_group(array('partenaire'))){
			?>
			<li><a href="<?= site_url('/backend/agent') ?>">Formations sanitaires</a></li>
			<?php
		}
	}else if($this->ion_auth->in_group(array('societe_pharma'))){
?>
	<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">Commandes</a></li>
	<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">Commandes g&eacute;r&eacute;es</a></li>
<?php
	}else if($this->ion_auth->in_group(array('pvv'))){
?>
	<li><a href="<?= site_url('/backend/diffusions') ?>">Informations</a></li>
	<li><a href="<?= site_url('/backend/questions') ?>">Questions</a></li>
	<li><a href="<?= site_url('/backend/ordonnances') ?>">Ordonnances</a></li>
<?php
	}else if($this->ion_auth->in_group(array('infirmier'))){
?>
	<li><a href="<?= site_url('/backend/consultations') ?>">Consultations</a></li>
	<li><a href="<?= site_url('/backend/diffusions') ?>">Informations</a></li>
<?php
	}else if($this->ion_auth->in_group(array('laborantin'))){
?>
	<li><a  href="<?= site_url('/backend/scan_pvv') ?>">Scanner PVV</a></li>
	<li><a href="<?= site_url('/backend/prescription_examens') ?>">Prescriptions d'examens</a></li>
	<li><a href="<?= site_url('/backend/diffusions') ?>">Informations</a></li>
<?php
	}
?>
			<li><a class="dropdown-button" href="#!" data-activates="dropdown2">Utilisateur<i class="material-icons right">arrow_drop_down</i></a></li>
		</ul>

	</div>
	<div style="text-align:right;padding:0px 40px;font-size:12px;font-weight:bold;color:#333;">
		<?php 
			$CI =& get_instance(); 
			$user = $this->lg->get_user($CI->session->userdata('user_id'));
			echo ucfirst($user['first_name']).' '.ucfirst($user['last_name']);
		?>
	</div>
</nav>



<ul id="dropdown4" class="dropdown-content" style="margin-top:64px;">
	<li><a href="<?= site_url('/backend/educateur') ?>">Educateurs</a></li>
	<li><a href="<?= site_url('/backend/province') ?>">Provinces</a></li>
	<li><a href="<?= site_url('/backend/ville') ?>">Villes</a></li>
	<li><a href="<?= site_url('/backend/regionsante') ?>">Centre de Distribution r&eacute;gional</a></li>
	<li><a href="<?= site_url('/backend/zonesante') ?>">Zone de sant&eacute;</a></li>
	<li><a href="<?= site_url('/backend/formation_sanitaire') ?>">Formation sanitaire</a></li>
	<li><a href="<?= site_url('/backend/medecin') ?>">M&eacute;decins</a></li>
	<li><a href="<?= site_url('/backend/infirmier') ?>">Infirmier</a></li>
	<li><a href="<?= site_url('/backend/pharmacie') ?>">Pharmacie </a></li>
	<li><a href="<?= site_url('/backend/partenaire') ?>">Partenaires</a></li>
	<li><a href="<?= site_url('/backend/societe_pharma') ?>">Soci&eacute;t&eacute; Pharmaceutique</a></li>
</ul>

<ul id="dropdownAlertes" class="dropdown-content" style="margin-top:64px;">
	<li><a href="<?= site_url('/backend/stock') ?>">Stocks</a></li>
	<li><a href="<?= site_url('/backend/alertes/peremption') ?>">P&eacute;remption</a></li>
	<li><a href="<?= site_url('/backend/alertes/outofstock') ?>">Rupture de stock</a></li>
	<li><a href="<?= site_url('/backend/alertes/commandesnontraitees') ?>">Commandes non trait&eacute;es</a></li>
</ul>

<ul id="dropdown1" class="dropdown-content" style="margin-top:64px;">
	<li><a href="<?= site_url('/backend/pvv') ?>">TOUS</a></li>
<?php	
	if(!$this->ion_auth->in_group(array('agent','pharmacie'))){	
?>
	<li><a href="<?= site_url('/backend/pvv/filter/tovalidate') ?>">a valider</a></li>
<?php	
	}	
?>
</ul>

	<ul id="dropdown_suivicommandes" class="dropdown-content" style="margin-top:64px;">
		<li><a href="<?= site_url('/backend/suivicommandes/filter/waiting_by_me') ?>">En attente</a></li>
		<li><a href="<?= site_url('/backend/suivicommandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
		<li><a href="<?= site_url('/backend/suivicommandes/filter/received') ?>">Recues</a></li>
	</ul>

	<ul id="dropdown3" class="dropdown-content" style="margin-top:64px;">
		<li><a href="<?= site_url('/backend/commandes') ?>">A lancer</a></li>
		<li><a href="<?= site_url('/backend/commandes/filter/waiting_by_me') ?>">En attente</a></li>
		<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">A traiter</a></li>
		<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
		<li><a href="<?= site_url('/backend/commandes/filter/received') ?>">Recues</a></li>
	</ul>

	<ul id="dropdownProduits" class="dropdown-content" style="margin-top:64px;">
		<li><a href="<?= site_url('/backend/produits') ?>">Produits</a></li>
		<li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li>
	</ul>

	<ul id="dropdown2" class="dropdown-content" style="margin-top:64px;">
	<?php	
		$id = $this->session->userdata('user_id');
		if($this->ion_auth->is_admin()){
	?>
	 	<li><a href="<?= site_url('/auth/') ?>">Utilisateurs</a></li>
	<?php
		}
	?>
	<?php
		if($this->ion_auth->in_group(array('pvv'))){
	?>
	  <li><a href="<?= site_url('/auth/profil_user/'.$id) ?>">Mon profil</a></li>
	<?php
		}else{
	?>
	  <li><a href="<?= site_url('/auth/edit_user/'.$id) ?>">Mon profil</a></li>
	<?php
		}
	?>
	  <li><a href="<?= site_url('/auth/change_password') ?>">Mot de passe</a></li>
	  <li><a href="<?= site_url('/auth/logout') ?>">Logout</a></li>
	</ul>
</div>



<!-- THE MOBILE MENU -------------------------------------------------->
<!-- THE MOBILE MENU -------------------------------------------------->
<!-- THE MOBILE MENU -------------------------------------------------->
<ul class="side-nav" id="mobile-demo">
	<?php	
		if($this->ion_auth->in_group(array('admin'))){	
	?>
				<li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">PVV<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="<?= site_url('/backend/pvv') ?>">TOUS</a></li>
				<?php	
					if(!$this->ion_auth->in_group(array('agent','pharmacie'))){	
				?>
	                <li><a href="<?= site_url('/backend/pvv/filter/tovalidate') ?>">a valider</a></li>
				<?php	
					}	
				?>
              </ul>
            </div>
          </li>
        </ul>
				</li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Produits<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="<?= site_url('/backend/produits') ?>">Produits</a></li>
	            <li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li>
			  </ul>
            </div>
          </li>
        </ul>
				</li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Journal des commandes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/waiting_by_me') ?>">En attente</a></li>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/received') ?>">Recues</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Alertes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/stock') ?>">Stocks</a></li>
					<li><a href="<?= site_url('/backend/alertes/peremption') ?>">P&eacute;remption</a></li>
					<li><a href="<?= site_url('/backend/alertes/outofstock') ?>">Rupture de stock</a></li>
					<li><a href="<?= site_url('/backend/alertes/commandesnontraitees') ?>">Commandes non trait&eacute;es</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
				<!--li><a href="<?= site_url('/backend/alertes') ?>">Alertes</a></li-->
				<li>
					<a href="<?= site_url('/backend/diffusions') ?>">Informations</a>
				</li>
				<li><a href="<?= site_url('/backend/questions') ?>">Questions</a></li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Acteurs<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/educateur') ?>">Educateurs</a></li>
					<li><a href="<?= site_url('/backend/province') ?>">Provinces</a></li>
					<li><a href="<?= site_url('/backend/ville') ?>">Villes</a></li>
					<li><a href="<?= site_url('/backend/regionsante') ?>">Centre de Distribution r&eacute;gional</a></li>
					<li><a href="<?= site_url('/backend/zonesante') ?>">Zone de sant&eacute;</a></li>
					<li><a href="<?= site_url('/backend/formation_sanitaire') ?>">Formation sanitaire</a></li>
					<li><a href="<?= site_url('/backend/medecin') ?>">M&eacute;decins</a></li>
					<li><a href="<?= site_url('/backend/infirmier') ?>">Infirmier</a></li>
					<li><a href="<?= site_url('/backend/pharmacie') ?>">Pharmacie </a></li>
					<li><a href="<?= site_url('/backend/partenaire') ?>">Partenaires</a></li>
					<li><a href="<?= site_url('/backend/societe_pharma') ?>">Soci&eacute;t&eacute; Pharmaceutique</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
	<?php
		}else if($this->ion_auth->in_group(array('pnls'))){
	?>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Acteurs<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/educateur') ?>">Educateurs</a></li>
					<li><a href="<?= site_url('/backend/province') ?>">Provinces</a></li>
					<li><a href="<?= site_url('/backend/ville') ?>">Villes</a></li>
					<li><a href="<?= site_url('/backend/regionsante') ?>">Centre de Distribution r&eacute;gional</a></li>
					<li><a href="<?= site_url('/backend/zonesante') ?>">Zone de sant&eacute;</a></li>
					<li><a href="<?= site_url('/backend/formation_sanitaire') ?>">Formation sanitaire</a></li>
					<li><a href="<?= site_url('/backend/medecin') ?>">M&eacute;decins</a></li>
					<li><a href="<?= site_url('/backend/infirmier') ?>">Infirmier</a></li>
					<li><a href="<?= site_url('/backend/pharmacie') ?>">Pharmacie </a></li>
					<li><a href="<?= site_url('/backend/partenaire') ?>">Partenaires</a></li>
					<li><a href="<?= site_url('/backend/societe_pharma') ?>">Soci&eacute;t&eacute; Pharmaceutique</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Journal des commandes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/waiting_by_me') ?>">En attente</a></li>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/received') ?>">Recues</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Commandes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/commandes') ?>">A lancer</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/waiting_by_me') ?>">En attente</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">A traiter</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/received') ?>">Recues</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>	
				<li><a href="<?= site_url('/backend/ordonnances/all') ?>">Ordonnances</a></li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Alertes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/stock') ?>">Stocks</a></li>
					<li><a href="<?= site_url('/backend/alertes/peremption') ?>">P&eacute;remption</a></li>
					<li><a href="<?= site_url('/backend/alertes/outofstock') ?>">Rupture de stock</a></li>
					<li><a href="<?= site_url('/backend/alertes/commandesnontraitees') ?>">Commandes non trait&eacute;es</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Produits<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
              <ul>
                <li><a href="<?= site_url('/backend/produits') ?>">Produits</a></li>
	            <li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li>
			  </ul>
            </div>
          </li>
        </ul>
				</li>
	<?php
		}else if($this->ion_auth->in_group(array('ministere'))){
	?>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Acteurs<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/educateur') ?>">Educateurs</a></li>
					<li><a href="<?= site_url('/backend/province') ?>">Provinces</a></li>
					<li><a href="<?= site_url('/backend/ville') ?>">Villes</a></li>
					<li><a href="<?= site_url('/backend/regionsante') ?>">Centre de Distribution r&eacute;gional</a></li>
					<li><a href="<?= site_url('/backend/zonesante') ?>">Zone de sant&eacute;</a></li>
					<li><a href="<?= site_url('/backend/formation_sanitaire') ?>">Formation sanitaire</a></li>
					<li><a href="<?= site_url('/backend/medecin') ?>">M&eacute;decins</a></li>
					<li><a href="<?= site_url('/backend/infirmier') ?>">Infirmier</a></li>
					<li><a href="<?= site_url('/backend/pharmacie') ?>">Pharmacie </a></li>
					<li><a href="<?= site_url('/backend/partenaire') ?>">Partenaires</a></li>
					<li><a href="<?= site_url('/backend/societe_pharma') ?>">Soci&eacute;t&eacute; Pharmaceutique</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Journal des commandes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/waiting_by_me') ?>">En attente</a></li>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
					<li><a href="<?= site_url('/backend/suivicommandes/filter/received') ?>">Recues</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Commandes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/commandes') ?>">A lancer</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/waiting_by_me') ?>">En attente</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">A traiter</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/received') ?>">Recues</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>	
				<li><a href="<?= site_url('/backend/ordonnances/all') ?>">Ordonnances</a></li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Alertes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/stock') ?>">Stocks</a></li>
					<li><a href="<?= site_url('/backend/alertes/peremption') ?>">P&eacute;remption</a></li>
					<li><a href="<?= site_url('/backend/alertes/outofstock') ?>">Rupture de stock</a></li>
					<li><a href="<?= site_url('/backend/alertes/commandesnontraitees') ?>">Commandes non trait&eacute;es</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>
				<li><a href="<?= site_url('/backend/produits') ?>">Produits</a></li>				
	<?php
		}else if($this->ion_auth->in_group(array('pharmacie'))){
	?>
				<li><a  href="<?= site_url('/backend/scan_pvv') ?>">Scanner PVV</a></li>
				<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Commandes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/commandes') ?>">A lancer</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/waiting_by_me') ?>">En attente</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">A traiter</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/received') ?>">Recues</a></li>
				</ul>
            </div>
          </li>
        </ul>
				</li>	
				<li><a href="<?= site_url('/backend/alertes') ?>">Alertes</a></li>
				<li><a href="<?= site_url('/backend/stock') ?>">Stock</a></li>
				<!--li><a href="<?= site_url('/backend/pvv/ordonnances') ?>">Ordonnances</a></li-->
				<li><a href="<?= site_url('/backend/ordonnances') ?>">Ordonnances</a></li>
	<?php
		}else if($this->ion_auth->in_group(array('medecin'))){
	?>
				<li><a href="<?= site_url('/backend/consultations') ?>">Consultations</a></li>
				<li><a href="<?= site_url('/backend/ordonnances') ?>">Ordonnances</a></li>
				<!--li><a href="<?= site_url('/backend/pvv') ?>">PVV</a></li-->
				<!--li><a href="<?= site_url('/backend/profile_pvv') ?>">Profil PVV</a></li-->
				<li><a href="<?= site_url('/backend/propositions') ?>">Propositions</a></li>
				<li><a href="<?= site_url('/backend/questions') ?>">Questions</a></li>
	<?php
		}else if($this->ion_auth->in_group(array('agent'))){
	?>
				<li><a  href="<?= site_url('/backend/scan_pvv') ?>">Scanner PVV</a></li>
				<li><a href="<?= site_url('/backend/consultations') ?>">Consultations</a></li>
				<li><a href="<?= site_url('/lgedit/addPage/pvv') ?>">ajouter PVV</a></li>
				<!--li><a href="<?= site_url('/backend/profile_pvv') ?>">Profil PVV</a></li-->
				<!--li><a href="<?= site_url('/backend/medecin') ?>">M&eacute;decins</a></li-->
				<li><a href="<?= site_url('/backend/educateur') ?>">Educateurs</a></li>
	<?php
		}else if($this->ion_auth->in_group(array('educateur'))){
	?>
				<li><a href="<?= site_url('/backend/pvv') ?>">Mes PVV</a></li>
				<li><a href="<?= site_url('/lgedit/addPage/pvv') ?>">ajouter PVV</a></li>
				<li><a href="<?= site_url('/backend/pvv/filter/tovalidate') ?>">PVV &agrave; valider</a></li>
				<li><a href="<?= site_url('/backend/questions') ?>">Questions</a></li>
	<?php
		}else if($this->ion_auth->in_group(array('regionsante','zonesante','partenaire'))){
	?>
			<li><a href="<?= site_url('/backend/stock') ?>">Stock</a></li>
			<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Commandes<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
					<li><a href="<?= site_url('/backend/commandes') ?>">A lancer</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/waiting_by_me') ?>">En attente</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">A traiter</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">D&eacute;j&agrave; trait&eacute;e</a></li>
					<li><a href="<?= site_url('/backend/commandes/filter/received') ?>">Recues</a></li>
				</ul>
            </div>
          </li>
        </ul>
			</li>	
	<?php
			if($this->ion_auth->in_group(array('partenaire'))){
				?>
				<li><a href="<?= site_url('/backend/agent') ?>">Formations sanitaires</a></li>
				<?php
			}
		}else if($this->ion_auth->in_group(array('societe_pharma'))){
	?>
		<li><a href="<?= site_url('/backend/commandes/filter/waiting_for_me') ?>">Commandes</a></li>
		<li><a href="<?= site_url('/backend/commandes/filter/delivered') ?>">Commandes g&eacute;r&eacute;es</a></li>
	<?php
		}else if($this->ion_auth->in_group(array('pvv'))){
	?>
		<li><a href="<?= site_url('/backend/diffusions') ?>">Informations</a></li>
		<li><a href="<?= site_url('/backend/questions') ?>">Questions</a></li>
		<li><a href="<?= site_url('/backend/ordonnances') ?>">Ordonnances</a></li>
	<?php
		}else if($this->ion_auth->in_group(array('infirmier'))){
	?>
		<li><a href="<?= site_url('/backend/consultations') ?>">Consultations</a></li>
		<li><a href="<?= site_url('/backend/diffusions') ?>">Informations</a></li>
	<?php
		}
	?>
			<li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header">Utilisateur<i class="material-icons right">arrow_drop_down</i></a>
            <div class="collapsible-body">
				<ul>
				<?php	
					$id = $this->session->userdata('user_id');
					if($this->ion_auth->is_admin()){
				?>
				 	<li><a href="<?= site_url('/auth/') ?>">Utilisateurs</a></li>
				<?php
					}
				?>
				<?php
					if($this->ion_auth->in_group(array('pvv'))){
				?>
				  <li><a href="<?= site_url('/auth/profil_user/'.$id) ?>">Mon profil</a></li>
				<?php
					}else{
				?>
				  <li><a href="<?= site_url('/auth/edit_user/'.$id) ?>">Mon profil</a></li>
				<?php
					}
				?>
				  <li><a href="<?= site_url('/auth/change_password') ?>">Mot de passe</a></li>
				  <li><a href="<?= site_url('/auth/logout') ?>">Logout</a></li>
				</ul>
            </div>
          </li>
        </ul>
			</li>	
</ul>


<?php
	if(!isset($hide_alert) && $this->ion_auth->in_group(array('pharmacie','partenaire','regionsante','zonesante')) && get_warning(true)){
?>
<div class="row">
	<div class="col s12">
		<div class="center card red darken-1">
			<h1 style="margin: 10px 0 0;"><a href="<?php echo site_url('/backend/alertes') ?>">Controler votre stock</a></h1>
		</div>	
	</div>	
</div>	
<?php
	}
?>	

