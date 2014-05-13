<?php
	 #Router.php

	 class Router extends MyBaseClass{
	 	private $PARENT;
	 	private $COMMAND = "request";
	 	private $ACTIONFILE = 'actions.json';
 		private $ACTIONS;

 		function __construct($parent){
 			$this->PARENT = $parent;
 			$this->ACTIONS = $this->loadActions($this->ACTIONFILE);
		}

		public function handleRequest(){
			#	echo "in " . __FUNCTION__ ."<br />"; exit;
			$method = $_SERVER['REQUEST_METHOD'];
			$c = isset($_REQUEST[$this->COMMAND])?$_REQUEST[$this->COMMAND]:'default' ;		 
			$params = $this->cleanParams($c);
			$verb = $params[0];
 
			if(isset($verb) && in_array($verb, array_keys($this->ACTIONS))){
 				
 				$func = @( $this->ACTIONS[$verb][$method] ? $this->ACTIONS[$verb][$method] : 'getIndex' );
				return $this->PARENT->$func($params);
					 
			}else{ # default action				
					$func = $this->ACTIONS['default']['GET'];
					return $this->PARENT->$func($params); 
			}
			return;
		}

		private function cleanParams($params){
			return explode("/",$params);
		}
	 }
?>