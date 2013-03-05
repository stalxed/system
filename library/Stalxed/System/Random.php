<?php
namespace Stalxed\System;

/**
 * The class generates a different random data.
 *
 */
class Random
{
    /**
     * Callback functions generate a random digit.
     *
     * @var callback
     */
    private static $callbackRandomFunction = 'mt_rand';
    /**
     * The list of letters to generate a random letter.
     *
     * @var array
     */
    private $letters = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    );

    /**
     * Sets the default callback functions generate a random number.
     *
     */
    public static function setDefaultRandomFunction()
    {
        self::$callbackRandomFunction = 'mt_rand';
    }

    /**
     * Sets the callback function of generating a random number.
     *
     * @param callback $callbackRandomFunction
     */
    public static function setCallbackRandomFunction($callbackRandomFunction)
    {
        self::$callbackRandomFunction = $callbackRandomFunction;
    }

    /**
     * Generates and returns a random digit in the specified range.
     *
     * @param integer $minDigit
     * @param integer $maxDigit
     * @return integer
     */
    public function generateDigit($minDigit, $maxDigit)
    {
        if ($minDigit > $maxDigit) {
            throw new Exception\RangeException();
        }

        return call_user_func(self::$callbackRandomFunction, $minDigit, $maxDigit);
    }

    /**
     * Generates and returns a random letter.
     *
     * @return string
     */
    public function generateLetter()
    {
        $index = $this->generateDigit(0, count($this->letters) - 1);

        return $this->letters[$index];
    }

    /**
     * Shuffle an array.
     *
     * @param array $array
     * @return array
     */
    public function shuffle(array $array)
    {
        shuffle($array);

        return $array;
    }
}
