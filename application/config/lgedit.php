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
				'etat' => array(
					'label' => '',
					'type' => 'hidden',
					'value' => 'waiting',
					'table_hide' => true
				),
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
				'telephone' => array(
					//'required' => true,
					'label' => 'T&eacute;l&eacute;phone',
					'type' => 'tel'
				),
				'email' => array(
					//'required' => true,
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
					//'required' => true,
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
					'type' => 'hidden'
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
