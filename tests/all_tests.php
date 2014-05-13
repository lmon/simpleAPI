<?php
require_once('/Library/WebServer/Documents/MonacoWork/simpletest/autorun.php');
require_once(dirname(__FILE__) . '/service_test.php');

// puzzletest.php
class AllTests extends TestSuite {
    function __construct() {
        parent::__construct();
        $this->addFile('service_test.php');
    }
}
?>
