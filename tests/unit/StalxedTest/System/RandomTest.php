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

    public function testGenerateDigit_CorrectRange()
    {
        Random::setCallbackRandomFunction(
            function ($minDigit, $maxDigit) {
                return 2;
            }
        );

        $random = new Random();

        $this->assertEquals(2, $random->generateDigit(1, 3));
    }

    public function testGenerateDigit_MinDigitLessThanMax()
    {
        $this->setExpectedException('Stalxed\System\Exception\RangeException');

        $random = new Random();
        $random->generateDigit(3, 1);
    }

    public function testGenerateLetters_SimpleCall()
    {
        $list = array(0);
        Random::setCallbackRandomFunction(
            function ($minDigit, $maxDigit) use (&$list) {
                return array_shift($list);
            }
        );

        $random = new Random();

        $this->assertSame('a', $random->generateLetter());
    }
}
