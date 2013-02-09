<?php
namespace Stalxed\System;

/**
 * The class generates a different random data.
 *
 */
class Random
{
    /**
     * Callback functions generate a random number.
     *
     * @var callback
     */
    private static $callbackRandomFunction = 'mt_rand';
    /**
     * The list of characters to generate random words.
     *
     * @var array
     */
    private $symbols = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    );
    /**
     * The list of generated numbers.
     *
     * @var array
     */
    private $historyNumbers = array();
    /**
     * The list generated words.
     *
     * @var array
     */
    private $historyWords = array();

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
     * Generates and returns a random number in the specified range.
     *
     * @param integer $minNumber
     * @param integer $maxNumber
     * @return integer
     */
    public function generateNumber($minNumber, $maxNumber)
    {
        if ($minNumber > $maxNumber) {
            throw new Exception\RangeException();
        }

        return call_user_func(self::$callbackRandomFunction, $minNumber, $maxNumber);
    }

    /**
     * Generates and returns a unique random number in the specified range.
     *
     * @param integer $minNumber
     * @param integer $maxNumber
     * @return integer
     * @throws Stalxed\System\Exception\LimitExceededException
     */
    public function generateUniqueNumber($minNumber, $maxNumber)
    {
        for ($i = 0; $i < 1000; $i++) {
            $number = $this->generateNumber($minNumber, $maxNumber);

            if (array_search($number, $this->historyNumbers) === false) {
                $this->historyNumbers[] = $number;

                return $number;
            }
        }

        throw new Exception\LimitExceededException();
    }

    /**
     * Generates and returns a combination of letters in the specified range.
     *
     * @param integer $minLetters
     * @param integer $maxLetters
     * @return string
     */
    public function generateLetters($minLetters, $maxLetters)
    {
        $word = '';
        $count_symbols = $this->generateNumber($minLetters, $maxLetters);
        for ($i = 0; $i < $count_symbols; $i++) {
            $index = $this->generateNumber(0, count($this->symbols) - 1);
            $word .= $this->symbols[$index];
        }

        return $word;
    }

    /**
     * Generates and returns a unique combination of letters in the specified range.
     *
     * @param integer $minLetters
     * @param integer $maxLetters
     * @return string
     * @throws Stalxed\System\Exception\LimitExceededException
     */
    public function generateUniqueLetters($minLetters, $maxLetters)
    {
        for ($i = 0; $i < 1000; $i++) {
            $word = $this->generateLetters($minLetters, $maxLetters);

            if (array_search($word, $this->historyWords) === false) {
                $this->historyWords[] = $word;

                return $word;
            }
        }

        throw new Exception\LimitExceededException();
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
