<?php
require_once dirname(__FILE__) . '/../../_setup.php';
require_once 'libs/System/Random.class.php';

class System_RandomMock extends System_Random
{
	private static $digits = array();
	private static $digits_with_exceptions = array();
	private static $words = array();
	private static $unique_words = array();

    public static function register()
    {
    	System_Random::setInstance(new self());
    }
    
    public static function unregister()
    {
    	System_Random::unsetInstance();
    }
    
    public static function setDigits()
    {
    	self::$digits = func_get_args();
    }
    
    public static function setDigitsWithExceptions()
    {
    	self::$digits_with_exceptions = func_get_args();
    }
    
    public static function setWords()
    {
    	self::$words = func_get_args();
    }
    
    public static function setUniqueWords()
    {
    	self::$unique_words = func_get_args();
    }
    
    public function getDigit($min_digit, $max_digit)
    {
    	return array_shift(self::$digits);
    }
    
    public function getDigitWithExceptions($min_digit, $max_digit, array $list_exceptions = array())
    {
    	return array_shift(self::$digits_with_exceptions);
    }
    
    public function getWord($min_symbols, $max_symbols)
    {
    	return array_shift(self::$words);
    }
    
    public function getUniqueWord($min_symbols, $max_symbols)
    {
    	return array_shift(self::$unique_words);
    }
    
    public function shuffle(array $array)
    {
    	return $array;
    }
}
?>