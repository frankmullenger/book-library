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

class Book_Controller extends Controller {
	
	// Basic API for Backbone
	// $app->get('/wines', 'getWines');
	// $app->get('/wines/:id',	'getWine');
	// $app->get('/wines/search/:query', 'findByName');
	// $app->post('/wines', 'addWine');
	// $app->put('/wines/:id', 'updateWine');
	// $app->delete('/wines/:id',	'deleteWine');
	
	static $url_handlers = array(
		'$ID!' => 'handleAction',
		'$Action//$ID/$OtherID' => 'handleAction',
	);
	
	static $allowed_actions = array(
		'retrieve',
		'update',
		'delete',
		'add'
	);
	
	/**
	 * Controller's default action handler.  It will call the method named in $Action, if that method exists.
	 * If $Action isn't given, it will use "index" as a default.
	 */
	public function handleAction($request) {
		// urlParams, requestParams, and action are set for backward compatability 
		foreach($request->latestParams() as $k => $v) {
			if($v || !isset($this->urlParams[$k])) $this->urlParams[$k] = $v;
		}

		$this->action = str_replace("-","_",$request->param('Action'));
		$this->requestParams = $request->requestVars();
		// if(!$this->action) $this->action = 'index';
		
		if (!$this->action) {
			
			switch ($request->httpMethod()) {
				case 'PUT':
					$this->action = 'update';
					break;
				case 'DELETE':
					$this->action = 'delete';
					break;
				case 'POST':
						$this->action = 'add';
						break;
				case 'GET':
				default:
					$this->action = 'retrieve';
					break;
			}
			
			// SS_Log::log(new Exception(print_r('-----------------------------------------------', true)), SS_Log::NOTICE);
			// SS_Log::log(new Exception(print_r($request->httpMethod(), true)), SS_Log::NOTICE);
			// SS_Log::log(new Exception(print_r($request, true)), SS_Log::NOTICE);
		}
		
		if(!$this->hasAction($this->action)) {
			$this->httpError(404, "The action '$this->action' does not exist in class $this->class");
		}
		
		// run & init are manually disabled, because they create infinite loops and other dodgy situations 
		if(!$this->checkAccessAction($this->action) || in_array(strtolower($this->action), array('run', 'init'))) {
			return $this->httpError(403, "Action '$this->action' isn't allowed on class $this->class");
		}
		
		if($this->hasMethod($this->action)) {
			$result = $this->{$this->action}($request);
			
			// If the action returns an array, customise with it before rendering the template.
			if(is_array($result)) {
				return $this->getViewer($this->action)->process($this->customise($result));
			} else {
				return $result;
			}
		} else {
			return $this->getViewer($this->action)->process($this);
		}
	}
	
	
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