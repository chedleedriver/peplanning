<?php

$config = array(

	// This is a authentication source which handles admin authentication.
	'admin' => array(
		// The default is to use core:AdminPassword, but it can be replaced with
		// any authentication source.

		'core:AdminPassword',
	),


	// An authentication source which can authenticate against both SAML 2.0
	// and Shibboleth 1.3 IdPs.
	'rm' => array(
		'saml:SP',

		// The entity ID of this SP.
		// Can be NULL/unset, in which case an entity ID is generated based on the metadata URL.
		'entityID' => 'https://peplanning-dev.itfacilitas.co.uk/simplesaml/module.php/saml/sp/metadata.php/rm',

		// The entity ID of the IdP this should SP should contact.
		// Can be NULL/unset, in which case the user will be shown a list of available IdPs.
		'idp' => 'http://sts.platform.rmunify.com/sts',

		// The URL to the discovery service.
		// Can be NULL/unset, in which case a builtin discovery service will be used.
		'discoURL' => NULL,
		'certificate' => 'star_itfacilitas_co_uk.crt',
	),


	/*
	'example-sql' => array(
		'sqlauth:SQL',
		'dsn' => 'pgsql:host=sql.example.org;port=5432;dbname=simplesaml',
		'username' => 'simplesaml',
		'password' => 'secretpassword',
		'query' => 'SELECT "username", "name", "email" FROM "users" WHERE "username" = :username AND "password" = :password',
	),
	*/

);
