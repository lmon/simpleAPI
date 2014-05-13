<?php
	 # FileHandler.php
 
	 class FileHandler extends MyBaseClass{
	 	private $PARENT;
	 	/*** maximum filesize allowed in bytes ***/
    	private $max_file_size = 51200;
    	private $fname = null;
    	private $directory = "uploaded/";

 		function __construct($parent){
 			$this->PARENT = $parent;
	 		 /*** the maximum filesize from php.ini ***/
		    $ini_max = str_replace('M', '', ini_get('upload_max_filesize'));
		    $this->upload_max = $ini_max * 1024;
		
			$max = ini_get('post_max_size');

		}

		public function create($fname = null){
			$this->fname = $fname;
 			$filenames = array();

			if(!isset($_FILES['file']['tmp_name'][0]) || strlen($_FILES['file']['tmp_name'][0])<1 ){
				return array('response'=>'Error','files'=>'no file');
			}
		 	if(!$this->validate()){ return array('response'=>'Error','size'=>'error'); }
 			$numfiles_uploaded = count($_FILES['file']['tmp_name']);
		 	
 			for($i=0; $i < $numfiles_uploaded; $i++){	
				if($_FILES['file']['tmp_name'][$i] == ""){continue;}
					if(is_uploaded_file($_FILES['file']['tmp_name'][$i])){
				
					$ext = $this->getFileExtenstion($_FILES['file']['name'][$i]);
					$newfilename = $this->directory.$this->makeFileName().'.'.$ext;
				
					if(file_exists($newfilename)){
						$newfilename = $this->directory.$this->makeFileName().rand(1,1000).'.'.$ext;		
					}	
					
					if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $newfilename ) ){
	      				# do nothing
					}else{
	      				return ('Error, move file failed (1) #'. $_FILES['file']['error'][$i]);
					}
				}else{
					#
				}
				$filenames[] = $newfilename;
			} 
			//success
	      return array('response'=>'Success','files'=>$filenames, 'filecount'=>$numfiles_uploaded);
		}

		function makeFileName(){
			// move to helper
			if($this->fname != null){ return preg_replace(array('/ /','/:/','/-/'), array("","",""), $this->fname);  } #2014-05-05 09:17:33
			date_default_timezone_set ('America/New_York' );
			$d = new DateTime( );
			return $d->format('YmdHis');
		}

		function getFileExtenstion($filename){
			// move to helper
			$file_ext=explode('.',$filename)	;
			$file_ext=end($file_ext);  
			return strtolower(end(explode('.',$filename)));  
		}

		private function validate(){ 
	      		return true;			
			for($i=0; $i < count($_FILES['file']['tmp_name']);$i++) {
				// size
				/*** check if the file is less then the max php.ini size ***/
	            if($_FILES['file']['size'][$i] > $this->upload_max)
	            {
			print  'Error, File '.$_FILES['file']['size'][$i].' exceeds '.$this->upload_max.' php.ini limit. ' ;
	          return 'Error';
	            }
	            // check the file is less than the maximum file size
	            elseif($_FILES['file']['size'][$i] > $this->max_file_size)
	            {
			print  'Error, File '.$_FILES['file']['size'][$i].' exceeds '.$this->max_file_size ;
               return ('Error,  File size exceeds '.$this->max_file_size.' limit ('.$i.')');
	            }

			}
			return true;
		}

	 }
?>