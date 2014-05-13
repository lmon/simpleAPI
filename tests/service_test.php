<?php
require_once('/Library/WebServer/Documents/MonacoWork/simpletest/autorun.php');
require_once('/Library/WebServer/Documents/MonacoWork/simpletest//web_tester.php');
require_once(dirname(__FILE__) . '/puzzleService.php');

class TestOfPuzzle extends WebTestCase {
    public $SITE = "http://localhost/MonacoWork/php/puzzle/index.php";

    function TestServiceExists(){
    	$pz = new puzzleService();
    	$this->assertTrue($pz);
        print $this->onFunctionEnd(__FUNCTION__);
    }

    function TestServiceRespondsToBadRequest(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->get($this->SITE."?/BAD/" );
        $this->assertText('{"result":"servicenotfound"}');
        print $this->onFunctionEnd(__FUNCTION__);
    }

    function TestServiceRespondsToIdRequest(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->get($this->SITE, array("id"=>"12345") );
        $this->assertText('{"result":"success","uid":"12345"}');
        print $this->onFunctionEnd(__FUNCTION__);
    }
    /*
    function TestServiceRespondsToUpload(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->post($this->SITE."?COM=upload", array("firstname"=>"testcaselucas","lastname"=>"testcasemonaco") );
        $this->assertText('{"result":"success","action":"upload","response":{"fileid":"11231","uid":');
        print $this->onFunctionEnd(__FUNCTION__);
    }
	*/
    function TestServiceFailsToUpload_missingfirst(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->post($this->SITE."?COM=upload", array( "lastname"=>"testcasemonaco") );
        $this->assertText('{"result":"fail","action":"upload"');
        print $this->onFunctionEnd(__FUNCTION__);
    }

    function TestServiceFailsToUpload_missinglast(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->post($this->SITE."?COM=upload", array("firstname"=>"testcaselucas"));
        $this->assertText('{"result":"fail","action":"upload"');
        print $this->onFunctionEnd(__FUNCTION__);
    }

    function TestServiceFailsToUpload_longfirst(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->post($this->SITE."?COM=upload", array("firstname"=>str_repeat('g', 256), "lastname"=>"testcasemonaco") );
        $this->assertText('{"result":"fail","action":"upload"');
        print $this->onFunctionEnd(__FUNCTION__);
    }

    function TestServiceFailsToUpload_longlast(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->post($this->SITE."?COM=upload", array("firstname"=>"testcaselucas","lastname"=>str_repeat('z', 256)) );
        $this->assertText('{"result":"fail","action":"upload"');
        print $this->onFunctionEnd(__FUNCTION__);
    }

    function TestServiceFailsToUpload_nofile(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->post($this->SITE."?COM=upload", array("firstname"=>"testcaselucas","lastname"=>"testcasemonaco") );
        $this->assertText('{"result":"fail","action":"upload"');
        print $this->onFunctionEnd(__FUNCTION__);
    }

    function TestServiceFailsToUpload_badfileext(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->post($this->SITE."?COM=upload", array("file"=>"badname.zip", "firstname"=>"testcaselucas","lastname"=>"testcasemonaco") );
        $this->assertText('{"result":"fail","action":"upload"');
        print $this->onFunctionEnd(__FUNCTION__);
    }

    function TestServiceFailsToUpload_largefile(){
    	$pz = new puzzleService();
    	// make some pseudo http req
    	$this->post($this->SITE."?COM=upload", array("firstname"=>"testcaselucas","lastname"=>"monaco") );
        $this->assertText('{"result":"fail","action":"upload"');
        print $this->onFunctionEnd(__FUNCTION__);
    }


    function onFunctionEnd($f){
      print "\n==== End ".$f. " ====\n\n";
    }
}
?>
