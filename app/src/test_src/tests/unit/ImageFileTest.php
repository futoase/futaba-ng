<?php
use Codeception\Util\Stub;

require(dirname(__FILE__) . "/../../../model/upload_file.php");
require(dirname(__FILE__) . "/../../../model/image_file.php");

class ImageFileTest extends \PHPUnit_Framework_TestCase {
  protected function setUp() {
  }

  protected function tearDown() {
  }

  /**
   * ImageFile::adjustmentImageCanvasSize
   */
  public function testAdjustmentImageCanvasSize() {
    $result = ImageFile::adjustmentImageCanvasSize(MAX_W, MAX_H); 
    $this->assertEquals(array('width' => MAX_W, 'height' => MAX_H), $result);
    $result = ImageFile::adjustmentImageCanvasSize(MAX_W * 30, MAX_H * 2);
    $this->assertNotEquals(
      array('width' => MAX_W * 2, 'height' => MAX_H * 2), 
      $result
    );
  }
}
