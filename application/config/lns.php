<?php

	$config['lns_agents']=array(
		'KA' => 'KABORE Anselme',
		'OAA' => 'OUEDRAOGO Abdoul AZIZ',
		'OD' => 'OUEDRAOGO Dieudonné',
		'SE' => 'SAM Emile',
		'NJB' => 'NANA Jean Baptiste'
	);


	$config['lns_checks']=array(
		'options' => array(
			'OPT0' => 'option assainisement par induction vapeur seche',
		),
		'interieur' => array(
			'INT0' => 'Démontage façade et capot de l’unité intérieur.',
			'INT1' => 'Débranchement électrique de l’unité.',
			'INT2' => 'Nettoyage carrosserie.',
			'INT3' => 'Démontage de la turbine de ventilation si pas de blocage pour cause d’oxydation sévère.',
			'INT4' => 'Nettoyage de la turbine. (pinceau si turbine bloquée par oxydation)',
			'INT5' => 'Nettoyage léger du condenseur par brosse à l’avant et à l’intérieur.',
			'INT6' => 'Contrôle des points de rouilles et application d’un produit spécifique si besoin.',
			'INT7' => 'Contrôle de l’axe du moteur de la turbine et dégripper l’axe si besoin.',
			'INT8' => 'Injection sur condenseur de la formule nettoyage en basse pression.',
			'INT9' => 'Nettoyage de bac(s) condensats.',
			'INT10' => 'Contrôle écoulement condensats.',
			'INT11' => 'Contrôle et Nettoyage si il y a des capteurs.',
			'INT12' => 'Séchage de l’ensemble.',
			'INT13' => 'Réinstallation de la turbine et de l’ensemble des éléments hors électricité.'
		),
		'interieur_notes' => array(
			'INTN0' => 'Oxydation turbine eleve',
			'INTN1' => 'Bruit ventilo eleve',
			'INTN2' => 'Carte electronique defectieuse',
			'INTN3' => 'Turbine en panne'
		),
		'exterieur' => array(
			'EXT0' => 'Démontage de l’unité extérieure.',
			'EXT1' => 'Nettoyage entretoise ventilateur et dégripper l’axe si besoin.',
			'EXT2' => 'Dépoussiérage de l’unité.',
			'EXT3' => 'Nettoyage avec application de détergeant spécifique pour l’échangeur extérieurs et dégraissage.',
			'EXT4' => 'Remontage de l’unité.'	
		),
		'exterieur_notes' => array(
			'EXTN0' => 'Manque de gaz (fuite)',
			'EXTN1' => 'Vibration eleve',
			'EXTN2' => 'Bruit du compresseur a l\'arret'
		),
		'general' => array(
			'GEN0' => 'Mise en tension et démarrage de l’unité général.',
			'GEN1' => 'Contrôle température bouche aération.',
			'GEN2' => 'Contrôle de pression au manomètre si besoin et selon gaz.',
		),
		'general_notes' => array(
			'GENN0' => 'panne',
			'GENN1' => 'dismatique saute',
			'GENN2' => 'Clim non fonctionelle',
			'GENN3' => 'fait disjoncter au niveau du coffret'
		)
	);
?>
