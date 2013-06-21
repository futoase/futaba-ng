<?php
use Codeception\Util\Stub;

require(dirname(__FILE__) . "/../../../repository/extension.php");

class ExtensionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp() {
    }

    protected function tearDown() {
    }

    public function testFindExtension() {
      $this->assertEquals(ExtensionRepository::find(1), ".gif");
      $this->assertEquals(ExtensionRepository::find(13), ".swf");
    }

}
