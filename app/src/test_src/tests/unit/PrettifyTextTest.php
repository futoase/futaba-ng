<?php
use Codeception\Util\Stub;

require(dirname(__FILE__) . "/../../../model/trip.php");
require(dirname(__FILE__) . "/../../../model/prettify_text.php");

class PrettifyTextTest extends \Codeception\TestCase\Test
{
  /**
   * @var \CodeGuy
   */
  protected $codeGuy;

  protected function _before() {
  }

  protected function _after() {
  }

  /**
   * PrettifyText::replaceStringOfMail
   */
  public function testReplaceStringOfMail() {
    $result = PrettifyText::replaceStringOfMail("hoge@com");
    $this->assertEquals($result, "hoge@com");
    $result = PrettifyText::replaceStringOfMail("\r\nhoge@com\r\n");
    $this->assertEquals($result, "hoge@com");
  }

  /**
   * PrettifyText::replaceStringOfSubject
   */
  public function testReplaceStringOfSubject() {
    $result = PrettifyText::replaceStringOfMail("test subject");
    $this->assertEquals($result, "test subject");
    $result = PrettifyText::replaceStringOfMail("\r\ntest subject\r\n");
    $this->assertEquals($result, "test subject");
  }

  /**
   * PrettifyText::replaceStringOfUrl
   */
  public function testReplaceStringOfUrl() {
    $result = PrettifyText::replaceStringOfUrl("http://hoge.com");
    $this->assertEquals($result, "http://hoge.com");
    $result = PrettifyText::replaceStringOfUrl("\r\nhttp://hoge.com\r\n");
    $this->assertEquals($result, "http://hoge.com");
  }

  /**
   * PrettifyText::replaceStringOfResNumber
   */
  public function testReplaceStringOfResNumber() {
    $result = PrettifyText::replaceStringOfResNumber(">>100");
    $this->assertEquals($result, "&gt;&gt;100");
    $result = PrettifyText::replaceStringOfResNumber("\r\n>>100\r\n");
    $this->assertEquals($result, "&gt;&gt;100");
  }

  /**
   * PrettifyText::replaceStringOfComment
   */
  public function testReplaceStringOfComment() {
    $result = PrettifyText::replaceStringOfComment("hogehoge\n\n\n\nhogehoge");
    $this->assertEquals($result, "hogehoge<br />hogehoge");
    $result = PrettifyText::replaceStringOfComment(">>100\r\nmuga");
    $this->assertEquals($result, "&gt;&gt;100<br />muga");
  } 

  /**
   * PrettifyText::replaceStringOfName
   */
  public function testReplaceStringOfName() {
    $result = PrettifyText::replaceStringOfName("hoge◆\r\n");
    $this->assertEquals($result, "hoge◇");
    $result = PrettifyText::replaceStringOfName("hoge#fuga");
    $this->assertEquals($result, "hoge</b>◆FBMM7z9idA<b>");
  }

}
