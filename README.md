# Book Library

Attemtping to make SilverStripe the RESTful API for the [Backbone Book Library App](http://addyosmani.github.io/backbone-fundamentals/#exercise-2-book-library---your-first-restful-backbone.js-app).

## Environment

Example _ss_environment.php for dev environments below...

```php
	<?php

	/* What kind of environment is this: development, test, or live (ie, production)? */
	define('SS_ENVIRONMENT_TYPE', 'dev');
	 
	/* Database connection */
	define('SS_DATABASE_SERVER', 'localhost');
	define('SS_DATABASE_USERNAME', '');
	define('SS_DATABASE_PASSWORD', '');
	define('SS_DATABASE_SUFFIX', '');
	 
	/* Configure a default username and password to access the CMS on all sites in this environment. */
	define('SS_DEFAULT_ADMIN_USERNAME', 'admin');
	define('SS_DEFAULT_ADMIN_PASSWORD', 'password');

	//Dev email
	define('SS_DEV_EMAIL', 'you@gmail.com');

	global $_FILE_TO_URL_MAPPING;
	$_FILE_TO_URL_MAPPING['/Users/you/Sites/library.local'] = 'http://library.local/';
```
