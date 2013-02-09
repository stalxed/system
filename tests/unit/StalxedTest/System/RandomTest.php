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
        $i = -1;
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) use(&$i) {
            ++$i;
            
            return $minDigit + $i;
        });
    	
	    $random = new Random();
	    
	    $this->assertLessThanOrEqual(51, $i);
        $this->assertSame(5, $random->getDigitWithExceptions(0, 51, array(0, 1, 2, 3, 4)));     
    }
    
    public function testGetDigitWithExceptions_MaxNumberAttemptsExceeded()
    {
    	$this->setExpectedException('Stalxed\System\Exception\RuntimeException', 'Exceeded maximum count of attempts select.');
    	
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) {
            return $minDigit + $maxDigit;
        });
	    
	    $random = new Random();

        $random->getDigitWithExceptions(0, 51, array(51));     
    }  
    
    public function testGetWord()
    {
	    Random::setCallbackRandomFunction(function($minDigit, $maxDigit) {
            return $minDigit + $maxDigit;
        });
	    
	    $random = new Random();
             
        $this->assertSame('ddd', $random->getWord(0, 3));
    }
    
    public function testGetUniqueWord()
    {
    	$random = $this->getMock('Stalxed\System\Random', array('getDigit'), array(), '', FALSE);
    	$random->expects($this->any())
             ->method('getDigit')
             ->with($this->equalTo(0), $this->equalTo(51))
             ->will($this->onConsecutiveCalls(
                 3, 0, 1, 2,   //3 symbols: abc.
                 3, 0, 1, 2,   //3 symbols: abc.
                 3, 49, 50, 51 //3 symbols: XYZ.
             ));

        $this->assertSame('abc', $random->getUniqueWord(0, 51));     
        $this->assertSame('XYZ', $random->getUniqueWord(0, 51));
    }
    
    public function testGetUniqueWord_MaxNumberAttemptsExceeded()
    {
    	$this->setExpectedException('Exception', 'Exceeded maximum count of attempts select.');
    	
    	$random = $this->getMock('Stalxed\System\Random', array('getDigit'), array(), '', FALSE);
    	$random->expects($this->exactly(4 + 4 * 1000))
             ->method('getDigit')
             ->with($this->equalTo(0), $this->equalTo(51))
             ->will($this->returnValue(3)); //3 symbols: ddd.

        $random->getUniqueWord(0, 51);     
        $random->getUniqueWord(0, 51);
    }   
}
