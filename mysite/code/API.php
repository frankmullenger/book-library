<?php

/**
 * 
 * Basic API for Backbone as a guide
 * $app->get('/wines', 'getWines');
 * $app->get('/wines/:id',	'getWine');
 * $app->get('/wines/search/:query', 'findByName');
 * $app->post('/wines', 'addWine');
 * $app->put('/wines/:id', 'updateWine');
 * $app->delete('/wines/:id',	'deleteWine');
 * 
 */
class API_Controller extends Controller {

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
		
		//Switch actions based on HTTP verbs
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
		return '{"error":{"text":"Not implemented"}}';
	}
	
	public function update($request) {
		return '{"error":{"text":"Not implemented"}}';
	}
	
	public function delete($request) {
		return '{"error":{"text":"Not implemented"}}';
	}
	
	public function add($request) {
		return '{"error":{"text":"Not implemented"}}';
	}
}