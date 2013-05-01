<?php

class Keyword extends DataObject {
	
	public static $db = array(
		'Keyword' => 'Varchar(255)'
	);
	
	public static $has_one = array(
		'Book' => 'Book',
	);
	
	public static $summary_fields = array(
		'Keyword' => 'Keyword'
	);

}