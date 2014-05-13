<?php
//base class

class MyBaseClass{
	
	public function __set($name, $value)
    {
        //echo "Setting '$name' to '$value'\n";
        $this->$name = $value;
    }

    public function loadActions($filename){
        return json_decode( file_get_contents($filename),'assoc' ) ;
    }

    public function __get($name)
    {
        echo "Getting '$name'\n";
        if (array_key_exists($name, $this->$name)) {
            return $this->$name;
        }
	    /*
	        $trace = debug_backtrace();
	        trigger_error(
	            'Undefined property via __get(): ' . $name .
	            ' in ' . $trace[0]['file'] .
	            ' on line ' . $trace[0]['line'], E_USER_NOTICE);
	     */
        return null;
    }

    /**  As of PHP 5.1.0  */
    public function __isset($name)
    {
        echo "Is '$name' set?\n";
        return isset($this->$name);
    }

    private function test_dump() {
        var_dump(get_object_vars($this));
    }

}