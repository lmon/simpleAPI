<?php
// ViewController.php

class ViewController extends MyBaseClass{
	
	public $FORMAT = 'json';
	private $DEBUG;
	private $HTML_DIRECTORY = 'html';

	function __construct(){
		$this->FORMAT = (isset($_REQUEST['id']) &&$_REQUEST['id'] == 'html' )?'html':'json';
	}
	
	private function display($value){

		if($this->FORMAT=='json'){
			return json_encode($value);
		}else{
			return $this->print_table($value['response']['records']);
		}
	}
	
	private function displayPage($name, $format){
		(file_exists( $this->HTML_DIRECTORY."/$name.$format" ) ? require_once "html/$name.$format" : require_once "html/index.html" );
	}

	/*********************************************************/

    public function detail($content){
        return $this->display(array('result'=>$this->showSuccessOrFail($content), "response"=>$content));
    }

    public function upload( $content ){
        return $this->display(array('result'=>$this->showSuccessOrFail($content),'action'=>'upload', "response"=>$content));
    }

    public function uploadForm(){
        return $this->displayPage('upload','html');
    }
    
    public function index(){
        #echo "in " . __FUNCTION__ ."<br />";
        return $this->display(array('result'=>'servicenotfound'));
    }

    public function all($content){
        #echo "in " . __FUNCTION__ ."<br />";
        return $this->display(array('result'=>$this->showSuccessOrFail($content), 'response'=>$content));
    }
	 
	private function showSuccessOrFail($content){
	 	#print_r($content);
	 	if(in_array('fail', $content)){return 'fail';}
	 		return 'success';
	}

	private function print_table($data){
		$content ="<table border=1> ";
	 	
	 	foreach ($data as $k=>$v) { 
		    $content .="<tr>";
		    if(is_array($v)){
		    	$content .=$this->createDataRow($v);	
		    }else{
		        $content .= "<td>$k $v</td>" ;	
			}
		    $content .="<tr>";
		}
		$content .="</table> ".print_r($data,true);

	 	return $this->htmlTemplate($content);
	}
    
    private function createDataRow($data){
    	$content = "";
    	foreach ($data as $k=>$v) { 
			if(is_array($v)){
				return $this->createDataRow($v);
			}else{
		        $content .= "<td>$k $v</td>" ;	
			}
		}	
		return $content;
    }

	private function htmlTemplate($content){
		return "<html>
			<body>
				$content
			</body>
			</html>";
	}	

}