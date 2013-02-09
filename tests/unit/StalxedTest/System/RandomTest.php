<?php
namespace StalxedTest\System;

use Stalxed\System\Random;

class RandomTest extends \PHPUnit_Framework_TestCase
{
	protected function tearDown()
	{
		Random::setDefaultRandomFunction();
		
		parent::tearDown();
	}
	
	public function testGenerateNumber_CorrectRange()
	{
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) {
            return 2;
        });
	    
	    $random = new Random();
	    
	    $this->assertEquals(2, $random->generateNumber(1, 3));
	}
	
	public function testGenerateNumber_MinNumberLessThanMax()
	{
	    $this->setExpectedException('Stalxed\System\Exception\RangeException');
	     
	    $random = new Random();
	    $random->generateNumber(3, 1);
	}
    
    public function testGenerateUniqueNumber_CorrectRange()
    {
        $list = array(1, 1, 1, 2);
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) use(&$list) {
            return array_shift($list);
        });
    	
	    $random = new Random();
	    
        $this->assertSame(1, $random->generateUniqueNumber(1, 3));   
        $this->assertSame(2, $random->generateUniqueNumber(1, 3));
    }
    
    public function testGenerateUniqueNumber_MinNumberLessThanMax()
    {
        $this->setExpectedException('Stalxed\System\Exception\RangeException');
         
        $random = new Random();
        $random->generateUniqueNumber(3, 1);
    }
    
    public function testGenerateUniqueNumber_ExceedingLimitSelection()
    {
    	$this->setExpectedException('Stalxed\System\Exception\LimitExceededException');
    	
	    $random = new Random();
	    $random->generateUniqueNumber(1, 3);
	    $random->generateUniqueNumber(1, 3);
	    $random->generateUniqueNumber(1, 3);
	    $random->generateUniqueNumber(1, 3);
    }  
    
    public function testGenerateWord_CorrectRange()
    {
        $list = array(3, 0, 1, 2);
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) use(&$list) {
            return array_shift($list);
        });
	    
	    $random = new Random();
             
        $this->assertSame('abc', $random->generateWord(1, 3));
    }
    
    public function testGenerateWord_MinNumberLessThanMax()
    {
        $this->setExpectedException('Stalxed\System\Exception\RangeException');
         
        $random = new Random();
        $random->generateWord(3, 1);
    }
    
    public function testGenerateUniqueWord_CorrectRange()
    {
        $list = array(
            3, 0, 1, 2,   //3 symbols: abc.
            3, 0, 1, 2,   //3 symbols: abc.
            3, 49, 50, 51 //3 symbols: XYZ.
        );
        Random::setCallbackRandomFunction(function($minDigit, $maxDigit) use(&$list) {
            return array_shift($list);
        });
             
        $random = new Random();
        
        $this->assertSame('abc', $random->generateUniqueWord(1, 3));     
        $this->assertSame('XYZ', $random->generateUniqueWord(1, 3));
    }
    
    public function testGenerateUniqueWord_MinNumberLessThanMax()
    {
        $this->setExpectedException('Stalxed\System\Exception\RangeException');
         
        $random = new Random();
        $random->generateUniqueWord(3, 1);
    }
    
    public function testGenerateUniqueWord_ExceedingLimitSelection()
    {
    	$this->setExpectedException('Stalxed\System\Exception\LimitExceededException');
    	
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) {
            return 2;
        });

	    $random = new Random();
        $random->generateUniqueWord(1, 3);     
        $random->generateUniqueWord(1, 3);
    }   
}
