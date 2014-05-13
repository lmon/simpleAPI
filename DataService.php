<?php
//DataService.php
require_once "MyBaseClass.php";
require_once "db_config.php";
require_once "DBHandler.php";
require_once "FileHandler.php";

class DataService extends MyBaseClass{
	
	var $DEBUG;
	var $DBCONNECT;
	var $FILEHANDLER;
	var $PARENT;

	function __construct($parent){
		global $DB, $DBHOST, $DBUSER, $DBPASS;
		$this->PARENT = $parent;
		//$this->TYPE = 'json';
		$this->DBCONNECT = new DBHandler($DB, $DBHOST, $DBUSER, $DBPASS ) ;
		$this->FILEHANDLER = new FileHandler($parent) ;
	}
	
	function detail($id){
		$res = $this->DBCONNECT->get_record_by_id($id);
		return ($res=="")?array("response"=>"fail", "message"=>"no record found") :array("uid"=>$res); 
	}

	function upload($values_array){
		$values_array = $this->clean($values_array);

		if($this->validate($values_array) ){
			// database updated
			$createresult = $this->DBCONNECT->create($values_array); 
			if( ($createresult != false) && !in_array('Error', $createresult) ){
				
				// file system updated
				// use the the time stamp from DB to create the filename :$createresult['created_at']
				$fileresult = $this->FILEHANDLER->create( $createresult['created_at'] );
				if( ($fileresult != false) && !in_array('Error', $fileresult) ){
					return array(
						'filesresult'=>$fileresult ,
						'createresult'=>$createresult
						);
				}else{
					return array('result'=>'fail','message'=>'filesystem failure '.implode(", ",$fileresult));
				}
			}else{
				return array('result'=>'fail','message'=>'record create failure '.$createresult);
			}		
		}else{
			return array('result'=>'fail','message'=>'invalid form data');
		}
		return array('result'=>'fail','message'=>'something bad in '.__FUNCTION__);
	}
	
	function validate($values_array){
		//exists
		if(!isset($values_array['firstname']) || trim($values_array['firstname'])=="") {return false;}
		if(!isset($values_array['lastname']) || trim($values_array['lastname'])=="") {return false;}
		
		//max length
		if( strlen(trim($values_array['firstname'])) > 255) {return false;}
		if( strlen(trim($values_array['lastname'])) > 255) {return false;}
		
		return true;
	}	

	function validateFiles(){
		$extensions = array("jpeg","jpg","png");
		$file_ext=explode('.',$_FILES['image']['name'][$key])	;
		$file_ext=end($file_ext);  
		$file_ext=strtolower(end(explode('.',$_FILES['image']['name'][$key])));  
		if(in_array($file_ext,$extensions ) === false){
			$errors[]="extension not allowed";
		}

		if($_FILES['image']['size'][$key] > 2097152){
			$errors[]='File size must be less tham 2 MB';
		}       
		return (count($errors)>0?false:true);
	}

	function clean($values_array){
		function trim_value(&$value) {
		    // this removes whitespace and related characters from the beginning and end of the string
		    $value = trim($value);    
		}

		array_filter($values_array, 'trim_value');    // the data in $_POST is trimmed

		$postfilter = // set up the filters to be used with the trimmed post array
		    array(
		            'firstname'	=> array('filter' => FILTER_SANITIZE_ENCODED, 'flags' => FILTER_FLAG_STRIP_LOW),   
		            'lastname'	=> array('filter' => FILTER_SANITIZE_ENCODED, 'flags' => FILTER_FLAG_STRIP_LOW) 
		        );

		$revised_post_array = filter_var_array($values_array, $postfilter);  // must be referenced via a variable which is now an array that takes the place of $_POST[]
		return $revised_post_array;
	}

	##############################
	# @Service
	# - get a list of results
	# optional params:
	#	llimit: how many, start: where to start
	#############################
 
	
	function getList($start=0, $count=0){
		
		$res = $this->DBCONNECT->get_all(null, array('uid','created_at'), array($start, $count));
		
		/*echo "in " . __FUNCTION__ ."<br />";
		print "res = ";
		print_r($res);
		 */
		return ($res=="")?array("result"=>"fail", "message"=>"no record found") : array("records"=>$res); 

	}
	
/*
	function getDetail($id=0){
		if($id==0){ return array("action"=>$this->getRequestAction(),"msg"=> "getDetail: id missing: $id" ); }
		
			$sql ="select * from ". TABLE1 ." WHERE work_id = ".mysql_real_escape_string($id) ;
			$sql2 ="select * from ". TABLE1 ." WHERE isHidden !=1 and parent = ".mysql_real_escape_string($id) ;
			//print $sql; 
			
			$res = db_query("", $sql);
			$res2 = db_query("", $sql2);

		return array("action"=>$this->getRequestAction(),
			"msg"=> "getDetail: $id", 
			"data"=>array("result"=>resourceToArray($res),
			"children"=>resourceToArray($res2))  ); ;
	}*/

	function getContent($name){
		return;
	}
	
	 
	
} 
?>