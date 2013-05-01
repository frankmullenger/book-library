<?php

class BookAdmin extends ModelAdmin {

	static $url_segment = 'book';

	static $url_priority = 50;

	static $menu_title = 'Book';

	public $showImportForm = false;

	public static $managed_models = array(
		'Book'
	);

}