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
			
			$image = $book->Image();
			$bookData['coverImage'] = ($image->exists()) ? $book->Image()->CMSThumbnail()->getFilename() : null;
			
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
	
	public function add($request) {
		
		// TODO: Upload file

		$data = json_decode($request->getBody());

		// TODO: Validation and error checking here
		$book = new Book();
		$book->Title = $data->title;
		$book->Author = $data->author;
		$book->ReleaseDate = date('Y-m-d', round($data->releaseDate / 1000)); // Javascript timestamp in milliseconds
		$book->write();
		
		$keys = $data->keywords;
		if ($keys) foreach ($keys as $key) {
			$keyword = new Keyword();
			$keyword->Keyword = $key->keyword;
			$keyword->BookID = $book->ID;
			$keyword->write();
		}
		
		$bookData = $book->toMap();
		$bookData['keywords'] = $book->Keywords()->toNestedArray();
		// TODO: Need to add image
		
		if ($book && $book->exists()) {
			$response = json_encode($bookData);
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

		if ($id = Convert::raw2sql($request->param('ID'))) {
			$book = Book::get()
				->where("\"ID\" = '$id'")
				->first();
			$book->delete();
			$response = '';
		}
		else {
			$response = '{"error":{"text":"Does no exist"}}';
		}
		return $response;
	}
	
	
}