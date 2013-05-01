<?php

class Book extends DataObject {
	
	public static $db = array(
		'Title' => 'Varchar(255)',
		'Author' => 'Varchar(255)',
		'ReleaseDate' => 'SS_Datetime'
	);
	
	public static $has_many = array(
		'Keywords' => 'Keyword',
	);
	
	public static $has_one = array(
		'Image' => 'Image',
	);
	
	public static $summary_fields = array(
		'Image.CMSThumbnail' => 'Image',
		'Title' => 'Title',
		'Author' => 'Author'
	);
	
	static $searchable_fields = array( 
		'Title'
	);
}

class Book_Controller extends API_Controller {

	public function retrieve($request) {
		
		$library = array();
		$books = DataList::create('Book');
		// $keywords = DataList::create('Keyword');

		if ($id = Convert::raw2sql($request->param('ID'))) {
			$books->where("\"Book\".\"ID\" = '$id'");
		}

		$library = array();
		foreach ($books as $book) {

			$bookData = $book->toMap();
			
			// $bookData['keywords'] = $keywords->filter('BookID', $book->ID)->toNestedArray();
			
			$bookData['keywords'] = $book->Keywords()->toNestedArray();
			$bookData['coverImage'] = $book->Image()->CMSThumbnail()->getFilename();
			
			$library[] = $bookData;
		}

		if ($books && $books->exists()) {
			$response = json_encode($library);
		}
		else {
			$response = '{"error":{"text":"None exist"}}';
		}
		return $response;
	}
	
	public function update($request) {
		SS_Log::log(new Exception(print_r('update', true)), SS_Log::NOTICE);
	}
	
	public function delete($request) {
		SS_Log::log(new Exception(print_r('delete', true)), SS_Log::NOTICE);
	}
	
	public function add($request) {
		SS_Log::log(new Exception(print_r('add', true)), SS_Log::NOTICE);
	}
}