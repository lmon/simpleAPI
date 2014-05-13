<?php

	require_once "MyBaseClass.php";
	require_once "Router.php";
	require_once "DataService.php";
	require_once "ViewController.php";

class puzzleService{
	private $ROUTER;
	private $DATASERVICE;
	private $VIEW;
	private $MAXRECORDS = 99;
	function __construct(){ 
		// load these supporters
		$this->DATA = new DataService($this);
		$this->VIEW = new ViewController($this);
		// now run
		$this->ROUTER = new Router($this);
		if(count($_REQUEST)>0){ $this->ROUTER->handleRequest();}
	}

	function getDetail($params){
		//validate ID
		print $this->VIEW->detail( $this->DATA->detail($params[1]) );	
	}

	function doUpload(){
		#print "IN UPLOAD";
		 print $this->VIEW->upload($this->DATA->upload($this->safeParams())) ;	
	}

	function doUploadForm(){
		 print $this->VIEW->uploadForm() ;	
	}

	function getAdmin(){
		print $this->VIEW->admin() ;	
	}

	function getAll($params){
		$start = @($params[1]?$params[1]:0);
		$count = @($params[2]?$params[2]:$this->MAXRECORDS);

		print $this->VIEW->all($this->DATA->getList($start, $count)) ;	
	}

	// default action
	function getIndex(){
		#echo "in " . __FUNCTION__ ."<br />";
		print $this->VIEW->index();	
	}

	function safeParams(){
		return array(
			'firstname'=>	@(isset($_REQUEST['firstname'])?$_REQUEST['firstname']:null),
			'lastname'=>	@(isset($_REQUEST['firstname'])?$_REQUEST['lastname']:null),
			'file'=>		@(isset($_REQUEST['file'])?$_REQUEST['file']:null)
			);
	}

}