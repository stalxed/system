<?php
namespace StalxedTest\System;

use Stalxed\System\Random;

class RandomTest extends \PHPUnit_Framework_TestCase
{
	protected function tearDown()
	{
		Random::unsetInstance();
		
		parent::tearDown();
	}
    
    public function testGetDigitWithExceptions()
    {
    	$random = $this->getMock('Random', array('getDigit'), array(), '', FALSE);
    	$random->expects($this->any())
             ->method('getDigit')
             ->will($this->onConsecutiveCalls(1, 2, 3, 4, 5));

    	Random::setInstance($random);
    	
        $this->assertSame(5, Random::getInstance()->getDigitWithExceptions(0, 51, array(1, 2, 3, 4)));     
    }
    
    public function testGetDigitWithExceptions_MaxNumberAttemptsExceeded()
    {
    	$this->setExpectedException('Exception', 'Exceeded maximum count of attempts select.');
    	
    	$random = $this->getMock('Stalxed\System\Random', array('getDigit'), array(), '', FALSE);
    	$random->expects($this->exactly(52))
             ->method('getDigit')
             ->with($this->equalTo(0), $this->equalTo(51))
             ->will($this->returnValue(3));

        $random->getDigitWithExceptions(0, 51, array(3));     
    }  
    
    public function testGetWord()
    {
    	$random = $this->getMock('Stalxed\System\Random', array('getDigit'), array(), '', FALSE);
    	$random->expects($this->any())
             ->method('getDigit')
             ->with($this->equalTo(0), $this->equalTo(51))
             ->will($this->onConsecutiveCalls(
                 8, 0, 1, 2, 3, 4, 49, 50, 51 //8 symbols: abcdeXYZ.
             ));
             
        $this->assertSame('abcdeXYZ', $random->getWord(0, 51));
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
