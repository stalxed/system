<?php
namespace StalxedTest\System;

use Stalxed\System\Random;

class RandomTest extends \PHPUnit_Framework_TestCase
{
	protected function tearDown()
	{
		Random::resetCallbackRandomFunction();
		
		parent::tearDown();
	}
	
	public function testGetDigit()
	{
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) {
            return $minDigit + $maxDigit;
        });
	    
	    $random = new Random();
	    
	    $this->assertEquals(3, $random->getDigit(1, 2));
	}
    
    public function testGetDigitWithExceptions()
    {
        $list = array(0, 1, 2, 3, 4, 5);
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) use(&$list) {
            return array_shift($list);
        });
    	
	    $random = new Random();
	    
        $this->assertSame(5, $random->getDigitWithExceptions(0, 10, array(0, 1, 2, 3, 4)));     
    }
    
    public function testGetDigitWithExceptions_MaxNumberAttemptsExceeded()
    {
    	$this->setExpectedException(
    	    'Stalxed\System\Exception\RuntimeException',
    	     'Exceeded maximum count of attempts select.'
    	);
    	
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) {
            return 5;
        });
	    
	    $random = new Random();

        $random->getDigitWithExceptions(0, 10, array(5));     
    }  
    
    public function testGetWord()
    {
        $list = array(3, 0, 1, 2);
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) use(&$list) {
            return array_shift($list);
        });
	    
	    $random = new Random();
             
        $this->assertSame('abc', $random->getWord(0, 3));
    }
    
    public function testGetUniqueWord()
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
        
        $this->assertSame('abc', $random->getUniqueWord(0, 10));     
        $this->assertSame('XYZ', $random->getUniqueWord(0, 10));
    }
    
    public function testGetUniqueWord_MaxNumberAttemptsExceeded()
    {
    	$this->setExpectedException(
    	    'Stalxed\System\Exception\RuntimeException',
    	     'Exceeded maximum count of attempts select.'
    	);
    	
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) {
            return 5;
        });

	    $random = new Random();
        $random->getUniqueWord(0, 10);     
        $random->getUniqueWord(0, 10);
    }   
}
