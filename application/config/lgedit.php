<?php
	$config['lgedit_tables']=array(
		'ordonnances' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'pvv' => array(
					'required' => true,
					'label' => 'PVV',
					'type' => 'select',
					'values' => 'get_pvv'
				),
				'produits' => array(
					'required' => true,
					'label' => 'Produits',
					'type' => 'list',
					'values' => array(
						'produit' => array(
							'label' => 'produit', 
							'type' => 'select',
							'values' => 'get_produits'
						),
						'quantite' => array(
							'label' => 'quantite', 
							'type' => 'number'
						),
						'package' => array(
							'label' => 'Unit&eacute;', 
							'type' => 'text'
						),
						'posologie' => array(
							'label' => 'Posologie',
							'type' => 'text'
						)
					)
				),
				'commentaires' => array(
					//'required' => true,
					'label' => 'Commentaires',
					'type' => 'textarea'
				),
				'renouvelable' => array(
					'required' => true,
					'label' => 'Renouvelable',
					'type' => 'select',
					'values' => array('0' => 'Non','1' => '1 fois','2' => '2 fois','3' => '3 fois')
				),
				'prochaine_visite' => array(
					'required' => true,
					'label' => 'Prochaine visite',
					'type' => 'date'
				),
				'consultation' => array(
					'label' => 'Consultation N&deg;',
					'type' => 'hidden',
					'form_hide' => true,
				),
				'prepose_pharmacie' => array(
					'label' => 'Pharmacie',
					'type' => 'hidden',
					'form_hide' => true,
				),
				'delivered' => array(
					'label' => 'D&eacute;livr&eacute;e',
					'type' => 'hidden',
					'form_hide' => true,
					'value' => ''
				),
				'etat' => array(
					'label' => 'Etat',
					'type' => 'hidden',
					'value' => 'waiting',
					'table_hide' => true,
					'form_hide' => true,
				),
				'initiated' => array(
						'label'  => 'Emission',
					'required' => true,
					'type' => 'hidden',
					'form_hide' => true,
					'value' => date('Y-m-d'),
				),
				'closed' => array(
					'label'  => 'Validit&eacute;',
					'required' => true,
					'type' => 'hidden',
					'form_hide' => true,
					'value' => date('Y-m-d', strtotime('+1 month')),
				),
				'num_renewed' => array(
						'label'  => 'Renouvell&eacute;',
					'required' => true,
					'type' => 'hidden',
					'form_hide' => true,
					'value' => '0',
				)
			) 
		),
		'consultation' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'pvv' => array(
					'required' => true,
					'label' => 'PVV',
					'type' => 'select',
					'values' => 'get_pvv'
				),
				'agent' => array(
					'required' => true,
					'label' => 'M&eacute;decin',
					'type' => 'select',
					'values' => 'get_pvv'
				),
				'medecin' => array(
					'required' => true,
					'label' => 'M&eacute;decin',
					'type' => 'select',
					'values' => 'get_pvv'
				),
				'infirmier' => array(
					'required' => true,
					'label' => 'Infirmier',
					'type' => 'select',
					'values' => 'get_pvv'
				),
				'etat' => array(
					'label' => '',
					'type' => 'hidden',
					'value' => 'waiting',
					'table_hide' => true
				),
			) 
		),
		'constante' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'pvv' => array(
					'required' => true,
					'label' => 'PVV',
					'type' => 'hidden',
					'form_hide' => true,
				),
				'infirmier' => array(
					'required' => true,
					'label' => 'Infirmier',
					'type' => 'hidden',
					'form_hide' => true,
				),
				'consultation' => array(
					'required' => true,
					'label' => 'Consultation',
					'type' => 'hidden',
					'form_hide' => true,
				),
				'temp' => array(
					'required' => true,
					'label' => 'Temp&eacute;rature',
					'type' => 'text'
				),
				'poids' => array(
					'required' => true,
					'label' => 'Poids',
					'type' => 'text'
				),
				'tension' => array(
					'type' => 'text'
				),
				'taille' => array(
					'required' => true,
					'label' => 'Taille',
					'type' => 'text'
				),
				'pb' => array(
					'label' => 'PB',
					'type' => 'text'
				),
				'perimetre_cranien' => array(
					'label' => 'P&eacute;rim&egrave;tre Cranien (PC)',
					'type' => 'text'
				),
				'masse_corp' => array(
					'label' => 'Indice de Masse Corporelle (IMC)',
					'type' => 'text'
				),
				'pouls' => array(
					'label' => 'Pouls',
					'type' => 'text'
				),
				'charge_virale' => array(
					'label' => 'Charge virale',
					'type' => 'text'
				)
			) 
		),
		'prescription_examens' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'pvv' => array(
					'required' => true,
					'label' => 'PVV',
					'form_hide' => true,
					'type' => 'hidden'
				),
				'consultation' => array(
					'required' => true,
					'label' => 'Consultation',
					'form_hide' => true,
					'type' => 'hidden'
				),
				'medecin' => array(
					'required' => true,
					'label' => 'M&eacute;decin',
					'form_hide' => true,
					'type' => 'hidden'
				),
				'ge' => array(
					'required' => true,
					'label' => 'Go&ucirc;te &eacute;paisse',
					'type' => 'radio',
					'multiple' => false,
					'values' => array('checked'=>'Oui','unchecked'=>'Non')
				),
				'nfs' => array(
					'required' => true,
					'label' => 'NFS',
					'type' => 'radio',
					'multiple' => false,
					'values' => array('checked'=>'Oui','unchecked'=>'Non')
				)
			) 
		),
		'resultat_examens' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'pvv' => array(
					'required' => true,
					'label' => 'PVV',
					'form_hide' => true,
					'type' => 'hidden'
				),
				'consultation' => array(
					'required' => true,
					'label' => 'Consultation',
					'form_hide' => true,
					'type' => 'hidden'
				),
				'prescription' => array(
					'required' => true,
					'label' => 'Prescription',
					'form_hide' => true,
					'type' => 'hidden'
				),
				'examen' => array(
					'required' => true,
					'label' => 'Examen',
					'form_hide' => true,
					'type' => 'hidden'
				),
				'resultats' => array(
					'required' => true,
					'label' => 'Go&ucirc;te &eacute;paisse',
					'type' => 'textarea',
					'table_hide' => true
				)
			) 
		),
		'commandes' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'destinataire' => array(
					'required' => true,
					'label' => 'Fournisseur',
					'type' => 'select',
					'values' => 'get_destinataires_commandes'
				),
				'produits' => array(
					'required' => true,
					'label' => 'Produits',
					'type' => 'list',
					'values' => array(
						'produit' => array(
							'label' => 'Produit', 
							'type' => 'select',
							'values' => 'get_produits'
						),
						'quantite' => array(
							'label' => 'Quantite',
							'type' => 'number'
						),
						'peremption' => array(
							'required' => true,
							'label' => 'peremption',
							'type' => 'date'
						)
					)
				),
				'acheteur' => array(
					'label' => 'Effectu&eacute;e par',
					'type' => 'hidden',
					'form_hide' => true,
					'table_hide' => true
				)
			) 
		),
		'produits' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom',
					'type' => 'text'
				),
				'forme' => array(
					'required' => true,
					'label' => 'Forme',
					'type' => 'select',
					'values' => array(
						'comprimes' => 'comprimes',
						'sirop' => 'sirop'
					)
				),
				'dosage' => array(
					'required' => true,
					'label' => 'Dosage',
					'type' => 'text'
				),
				'specificite' => array(
					'required' => true,
					'label' => 'Sp&eacute;cificit&eacute;',
					'type' => 'select',
					'values' => array(
						'Pediatrique' => 'P&eacute;diatrique',
						'Adulte' => 'Adulte'
					)
				),
				'min_pharmacie' => array(
					'required' => true,
					'label' => 'Stock Minimum (Pharmacie)',
					'type' => 'number'
				),
				'max_pharmacie' => array(
					'required' => true,
					'label' => 'Stock Maximun',
					'type' => 'number'
				),
				'min_zonesante' => array(
					'required' => true,
					'label' => 'Stock Minimum (Zone de santé)',
					'type' => 'number'
				),
				'max_zonesante' => array(
					'required' => true,
					'label' => 'Stock Maximum (Zone de santé)',
					'type' => 'number'
				),
				'min_regionsante' => array(
					'required' => true,
					'label' => 'Stock Minimum (Centre de Distribution R&eacute;gional)',
					'type' => 'number'
				),
				'max_regionsante' => array(
					'required' => true,
					'label' => 'Stock Maximum (Centre de Distribution R&eacute;gional)',
					'type' => 'number'
				),
				'min_pays' => array(
					'required' => true,
					'label' => 'Stock Minimum (Pays)',
					'type' => 'number'
				),
				'max_pays' => array(
					'required' => true,
					'label' => 'Stock Maximum (Pays)',
					'type' => 'number'
				)
				
			) 
		),
		'pharmacie' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom',
					'type' => 'text'
				),
				'username' => array(
					'required' => true,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'type' => array(
					'required' => true,
					'label' => 'Type',
					'type' => 'select',
					'values' => array(
						'csps' => 'CSPS',
						'clinique' => 'Clinique',
						'hopital' => 'Hopital'
					)
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				),
				'ville' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'select',
					'values' => 'get_ville_nom'
				),
				'zonesante' => array(
					'required' => true,
					'label' => 'Zone sanitaire',
					'type' => 'select',
					'values' => 'get_zone_sante_nom'
				),
				'agent' => array(
					'required' => true,
					'label' => 'Formation sanitaire',
					'type' => 'select',
					'values' => 'get_forma_sante_nom'
				),
				'adresse' => array(
					//'required' => true,
					'label' => 'Adresse',
					'type' => 'text'
				),
				'email' => array(
					//'required' => true,
					'label' => 'Adresse e-mail',
					'type' => 'email'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'contact' => array(
					//'required' => true,
					'label' => 'Personne a contacter',
					'type' => 'text'
				)
			)
		), 
		'agent' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom',
					'type' => 'text'
				),
				'username' => array(
					'required' => false,
					'label' => 'Sigle',
					'type' => 'text'
				),
				'type' => array(
					'required' => true,
					'label' => 'Type',
					'type' => 'select',
					'values' => array(
						'csps' => 'CSPS',
						'clinique' => 'Clinique',
						'hopital' => 'Hopital'
					)
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				),
				'ville' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'select',
					'values' => 'get_ville_nom'
				),
				'zonesante' => array(
					'required' => true,
					'label' => 'Zone sanitaire',
					'type' => 'select',
					'values' => 'get_zone_sante_nom'
				),
				'adresse' => array(
					//'required' => true,
					'label' => 'Adresse',
					'type' => 'text'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'contact' => array(
					//'required' => true,
					'label' => 'Personne &agrave; contacter',
					'type' => 'text'
				)
			)
		), 
		'educateur' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'username' => array(
					'required' => true,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom',
					'type' => 'text'
				),
				'prenom' => array(
					'required' => true,
					'label' => 'Pr&eacute;nom',
					'type' => 'text'
				),
				'cnib' => array(
					//'required' => true,
					'label' => 'Carte Nationale d\'Identité',
					'type' => 'text'
				),
				'adresse' => array(
					//'required' => true,
					'label' => 'Adresse',
					'type' => 'text'
				),
				'email' => array(
					//'required' => true,
					'label' => 'Adresse e-mail',
					'type' => 'email'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				),
				'ville' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'select',
					'values' => 'get_ville_nom'
				),
				'agent' => array(
					'required' => true,
					'label' => 'Formation sanitaire',
					'type' => 'select',
					'values' => 'get_forma_sante_nom'
				),
				'username' => array(
					'required' => true,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'password' => array(
					'required' => true,
					'label' => 'Mot de passe',
					'type' => 'password'
				),
				'password_confirm' => array(
					'required' => true,
					'label' => 'Confirmer le mot de passe',
					'type' => 'password'
				)
			)
		), 
		'pvv' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom',
					'type' => 'text'
				),
				'prenom' => array(
					'required' => true,
					'label' => 'Prenom',
					'type' => 'text'
				),
				'birthdate' => array(
					'label' => 'Date de naissance',
					'type' => 'text'
				),
				'birthplace' => array(
					'label' => 'Lieu de naissance',
					'type' => 'text'
				),
				'sexe' => array(
					'required' => true,
					'label' => 'Sexe',
					'type' => 'select',
					'values' => array(
						'masculin' => 'Masculin',
						'feminin' => 'F&eacute;minin'
					)
				),
				'etatcivil' => array(
					'label' => 'Etat civil',
					'type' => 'text'
				),
				'cnib' => array(
					'label' => 'Carte Nationale d\'Identité',
					'type' => 'text'
				),
				'debut_traitement' => array(
					'label' => 'D&eacute;but de traitement',
					'type' => 'text'
				),
				'nouveau_cas' => array(
					'label' => 'Nouveau cas',
					'type' => 'text'
				),
				'date_depistage' => array(
					'label' => 'Date de d&eacute;pistage',
					'type' => 'text'
				),
				'date_inscription' => array(
					'label' => 'Date d\'enregistrement',
					'type' => 'text'
				),
				'adresse' => array(
					'label' => 'Adresse',
					'type' => 'text'
				),
				'telephone' => array(
					'required' => false,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'email' => array(
					'label' => 'Adresse e-mail',
					'type' => 'email'
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				),
				'ville' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'select',
					'values' => 'get_ville_nom'
				),
				'zonesante' => array(
					'required' => true,
					'label' => 'Zone sanitaire',
					'type' => 'select',
					'values' => 'get_zone_sante_nom'
				),
				'educateur' => array(
					'label' => 'Educateur',
					'type' => 'select',
					'values' => 'get_educateurs'
				),
				'username' => array(
					'required' => true,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'password' => array(
					'required' => true,
					'label' => 'Mot de passe',
					'type' => 'password'
				),
				'password_confirm' => array(
					'required' => true,
					'label' => 'Confirmer le mot de passe',
					'type' => 'password'
				)
			),
			'hooks' => array(
				'before_add' => 'hook_before_add_pvv'
			)
		), 
		'diffusions' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'sujet' => array(
					'required' => true,
					'label' => 'Sujet',
					'type' => 'text'
				),
				'message' => array(
					'required' => true,
					'label' => 'Message &agrave; diffuser',
					'type' => 'textarea'
				)
			)
			/*'hooks' => array(
				'before_add' => 'hook_before_add_pvv'
			)*/
		), 
		'questions' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'sujet' => array(
					'required' => true,
					'label' => 'Sujet',
					'type' => 'text'
				),
				'message' => array(
					'required' => true,
					'label' => 'Question',
					'type' => 'textarea'
				)
			)
			/*'hooks' => array(
				'before_add' => 'hook_before_add_pvv'
			)*/
		), 
		'medecin' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom',
					'type' => 'text'
				),
				'prenom' => array(
					'required' => true,
					'label' => 'Pr&eacute;nom',
					'type' => 'text'
				),
				'email' => array(
					//'required' => true,
					'label' => 'Email',
					'type' => 'email'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				),
				'ville' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'select',
					'values' => 'get_ville_nom'
				),
				'zonesante' => array(
					'required' => true,
					'label' => 'Zone de sant&eacute;',
					'type' => 'select',
					'values' => 'get_zone_sante_nom'
				),
				'agent' => array(
					'required' => true,
					'label' => 'Formation sanitaire',
					'type' => 'select',
					'values' => 'get_forma_sante_nom'
				),
				'username' => array(
					'required' => false,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'password' => array(
					'required' => true,
					'label' => 'Mot de passe',
					'type' => 'password'
				),
				'password_confirm' => array(
					'required' => true,
					'label' => 'Confirmer le mot de passe',
					'type' => 'password'
				)
			)
		), 
		'infirmier' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom',
					'type' => 'text'
				),
				'prenom' => array(
					'required' => true,
					'label' => 'Pr&eacute;nom',
					'type' => 'text'
				),
				'email' => array(
					//'required' => true,
					'label' => 'Email',
					'type' => 'email'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				),
				'ville' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'select',
					'values' => 'get_ville_nom'
				),
				'zonesante' => array(
					'required' => true,
					'label' => 'Zone de sant&eacute;',
					'type' => 'select',
					'values' => 'get_zone_sante_nom'
				),
				'agent' => array(
					'required' => true,
					'label' => 'Formation sanitaire',
					'type' => 'select',
					'values' => 'get_forma_sante_nom'
				),
				'username' => array(
					'required' => false,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'password' => array(
					'required' => true,
					'label' => 'Mot de passe',
					'type' => 'password'
				),
				'password_confirm' => array(
					'required' => true,
					'label' => 'Confirmer le mot de passe',
					'type' => 'password'
				)
			)
		),
		'zonesante' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'titre' => array(
					'required' => true,
					'label' => 'Nom de la zone',
					'type' => 'text'
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				),
				'ville' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'select',
					'values' => 'get_ville_nom'
				),
				'adresse' => array(
					//'required' => true,
					'label' => 'Adresse',
					'type' => 'text'
				),
				'email' => array(
					//'required' => true,
					'label' => 'Adresse e-mail',
					'type' => 'email'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom (Personne en charge)',
					'type' => 'text'
				),
				'prenom' => array(
					'required' => true,
					'label' => 'Pr&eacute;nom (Personne en charge)',
					'type' => 'text'
				),
				'username' => array(
					'required' => true,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'password' => array(
					'required' => true,
					'label' => 'Mot de passe',
					'type' => 'password'
				),
				'password_confirm' => array(
					'required' => true,
					'label' => 'Confirmer le mot de passe',
					'type' => 'password'
				)
			) 
		),
		'regionsante' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'titre' => array(
					'required' => true,
					'label' => 'Nom du centre',
					'type' => 'text'
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				),
				'ville' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'select',
					'values' => 'get_ville_nom'
				),
				'adresse' => array(
					//'required' => true,
					'label' => 'Adresse',
					'type' => 'text'
				),
				'email' => array(
					//'required' => true,
					'label' => 'Adresse e-mail',
					'type' => 'email'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom (Personne en charge)',
					'type' => 'text'
				),
				'prenom' => array(
					'required' => true,
					'label' => 'Pr&eacute;nom (Personne en charge)',
					'type' => 'text'
				),
				'username' => array(
					'required' => true,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'password' => array(
					'required' => true,
					'label' => 'Mot de passe',
					'type' => 'password'
				),
				'password_confirm' => array(
					'required' => true,
					'label' => 'Confirmer le mot de passe',
					'type' => 'password'
				)
			) 
		),
		'province' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'text'
				)
			) 
		),
		'ville' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Ville',
					'type' => 'text'
				),
				'province' => array(
					'required' => true,
					'label' => 'Province',
					'type' => 'select',
					'values' => 'get_province_nom'
				)
			) 
		),
		'partenaire' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'titre' => array(
					'required' => true,
					'label' => 'Nom du partenaire',
					'type' => 'text'
				),
				'ville' => array(
					//'required' => true,
					'label' => 'ville',
					'type' => 'text'
				),
				'adresse' => array(
					//'required' => true,
					'label' => 'Adresse',
					'type' => 'text'
				),
				'email' => array(
					//'required' => true,
					'label' => 'Adresse e-mail',
					'type' => 'email'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom (Personne en charge)',
					'type' => 'text'
				),
				'prenom' => array(
					'required' => true,
					'label' => 'Pr&eacute;nom (Personne en charge)',
					'type' => 'text'
				),
				'username' => array(
					'required' => true,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'password' => array(
					'required' => true,
					'label' => 'Mot de passe',
					'type' => 'password'
				),
				'password_confirm' => array(
					'required' => true,
					'label' => 'Confirmer le mot de passe',
					'type' => 'password'
				)
			) 
		),
		'societe_pharma' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'titre' => array(
					'required' => true,
					'label' => 'Nom de la soci&eacute;t&eacute;',
					'type' => 'text'
				),
				'ville' => array(
					//'required' => true,
					'label' => 'ville',
					'type' => 'text'
				),
				'adresse' => array(
					//'required' => true,
					'label' => 'Adresse',
					'type' => 'text'
				),
				'email' => array(
					//'required' => true,
					'label' => 'Adresse e-mail',
					'type' => 'email'
				),
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom (Personne en charge)',
					'type' => 'text'
				),
				'prenom' => array(
					'required' => true,
					'label' => 'Pr&eacute;nom (Personne en charge)',
					'type' => 'text'
				),
				'username' => array(
					'required' => true,
					'label' => 'Identifiant',
					'type' => 'text'
				),
				'password' => array(
					'required' => true,
					'label' => 'Mot de passe',
					'type' => 'password'
				),
				'password_confirm' => array(
					'required' => true,
					'label' => 'Confirmer le mot de passe',
					'type' => 'password'
				)
			) 
		),
		'stock' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'company' => array(
					'required' => false,
					'label' => 'Organisation',
					'type' => 'hidden'
				),
				'produit' => array(
					'required' => true,
					'label' => 'Produit',
					'type' => 'select',
					'values' => 'get_produits'
				),
				'quantite' => array(
					'required' => true,
					'label' => 'Quantit&eacute;',
					'type' => 'number'
				),
				'peremption' => array(
					'required' => true,
					'label' => 'P&eacute;remption',
					'type' => 'date'
				)
				
			) 
		),
		'propositions' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'nom' => array(
					'required' => true,
					'label' => 'Nom Medicament',
					'type' => 'text',
				),
				'observation' => array(
					//'required' => true,
					'label' => 'observation',
					'type' => 'text'
				)
				
			) 
		),
		'observations' => array(
			'id' => 'id',
			'fields' => array(
				'id' => array(
					'type' => 'text',
					'table_hide' => true
				),
				'pvv' => array(
					'required' => true,
					'label' => 'pvv',
					'type' => 'text',
				),
				'observation' => array(
					'required' => true,
					'label' => 'observation',
					'type' => 'text'
				)
				
			)  
		)
	);
?>
