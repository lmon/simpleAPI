<?php

//DBHandlerClass.php
class DBHandler {
	private $DBHOST ;
	private $DBUSER ;
	private $DBPASS ;
	private $DB;
  private $CONNECTION;
// TABLE1 defined in db_config

  function __construct($DB, $DBHOST, $DBUSER, $DBPASS){
    $this->DB = $DB;
    $this->DBHOST = $DBHOST;
    $this->DBUSER = $DBUSER;
    $this->DBPASS = $DBPASS;
  }

  function create($values)
  {
      $conn = $this->db_connect();
      $sql = "insert into ".$this->DB.".".TABLE1." (firstname, lastname) VALUES('".$values['firstname']."', '".$values['lastname']."')";
      //$result = 
      if(mysql_query($sql, $conn)){
          return $this->get_record_by_id(mysql_insert_id(),TABLE1);
      }else{
        return ('Error, insert query failed '.mysql_error());
      } 

      return false;//(mysql_fetch_array($result));
  }

  function db_connect()
  {
    if($this->CONNECTION){ return $this->CONNECTION; }

     $this->CONNECTION = @mysql_pconnect($this->DBHOST, $this->DBUSER, $this->DBPASS); 
     if (!$this->CONNECTION){
     	  echo "1 FATAL error making connection in db_connect<br>** ".mysql_error()."**<br>";
        exit;
     }else{
      return $this->CONNECTION;
     }   
  }
  
  function get_all($tbl=null, $columns=null,$lim=null) { 
    if($tbl == null){$tbl = TABLE1;}
    if($columns !=null){$columns = implode(",", $columns);}else{$columns = "*";}

  	$conn = $this->db_connect();

    $limit = "";     # LIMIT 5,10;  # Retrieve rows 6-15

    if(is_array($lim)){
      $limit = "LIMIT ".$lim[0].",".$lim[1];
    } 
    	$sql = "SELECT $columns FROM ".$this->DB.".".$tbl." ".$limit;

    	$result = mysql_query($sql, $conn);
     
      $rows = array();
      while($row = mysql_fetch_assoc($result)){
        //Do stuff 
        $rows[] = $row ;
      } 
    	return $rows;
  }

  function get_record_by_id($id, $tbl=null) { 
    if($tbl == null){$tbl = TABLE1;}
    $conn = $this->db_connect();
    $sql = "SELECT * FROM ".$this->DB.".".$tbl. " WHERE uid = $id ";
    $result = mysql_query($sql, $conn);
    if($result){
    	return(mysql_fetch_array($result));
    }else{
   	  return array('result'=>'fail', 'message'=>'no results found ' .mysql_error() ) ;
   	return;
   }	
  }
  
  /*

  function show_tables()
  {	
    $conn = $this->db_connect();
    $sql = "SHOW TABLES from mainDB" ;
    $result = mysql_query($sql, $conn);
   	return  $result  ;
  }

  function db_query($tbl, $query)
  {
    $conn = $this->db_connect();
    $x = mysql_select_db($this->DB) or die ('I cannot select to the database because: ' . mysql_error());
    $result = mysql_query($query, $conn);

    if (!$result)
      return(0);

    return $result ;
   }
   
   function resourceToArray($resource){
  		$ret = array();
  		if($resource){
  			while($line = mysql_fetch_assoc($resource)){ $ret[] = $line;	}
  		} else{
  			echo "error " .mysql_error();
  		} 
  		return $ret;
  	}*/

}