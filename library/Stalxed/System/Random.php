<?php
namespace Stalxed\System;

/**
 * Генерирует случайные значения.
 *
 */
class Random
{
    /**
     * Экземпляр класса.
     *
     * @var System_Random
     */
    private static $callbackRandomFunction = 'mt_rand';
    
    /**
     * Список символов для генерации случайных слов.
     * 
     * @var array
     */
    private $symbols = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    );
    
    private $historyNumbers = array();
    
    /**
     * Список сгенерированных слов.
     * 
     * @var array
     */
    private $historyWords = array();

    public static function setDefaultRandomFunction()
    {
        self::$callbackRandomFunction = 'mt_rand';
    }
    
    public static function setCallbackRandomFunction($callbackRandomFunction)
    {
        self::$callbackRandomFunction = $callbackRandomFunction;
    }
    
	/**
     * Возвращает случайное число в указанном диапазоне.
     * 
     * @param integer $minNumber
     * @param integer $maxNumber
     * @return integer
     */
    public function getNumber($minNumber, $maxNumber)
    {
        return call_user_func(self::$callbackRandomFunction, $minNumber, $maxNumber);
    }
    
    /**
     * Возвращает уникальное случайное число.
     * 
     * @param integer $minNumber
     * @param integer $maxNumber
     * @return integer
     * @throws Exception
     */
    public function getUniqueNumber($minNumber, $maxNumber)
    {
        for ($i = 0; $i < 1000; $i++) {
            $number = $this->getNumber($minNumber, $maxNumber);
            
            if (array_search($number, $this->historyNumbers) === false) {
                $this->historyNumbers[] = $number;
                
                return $number;
            }
        }
        
        throw new Exception\RuntimeException('Exceeded maximum count of attempts select.');
    }
    
    /**
     * Возвращает случайное слово с количеством букв
     * в указанном диапазоне.
     * 
     * @param integer $min_symbols
     * @param integer $max_symbols
     * @return string
     */
    public function getWord($min_symbols, $max_symbols)
    {
        $word = '';
        $count_symbols = $this->getNumber($min_symbols, $max_symbols);
        for ($i = 0; $i < $count_symbols; $i++) {
            $index = $this->getNumber(0, count($this->symbols) - 1);
            $word .= $this->symbols[$index];
        }
        
        return $word;
    }
    
    /**
     * Возвращает уникальное случайное слово с количеством
     * букв в указанном диапазоне.
     * 
     * @param integer $min_symbols
     * @param integer $max_symbols
     * @return string
     * @throws Exception
     */
    public function getUniqueWord($min_symbols, $max_symbols)
    {
        for ($i = 0; $i < 1000; $i++) {
            $word = $this->getWord($min_symbols, $max_symbols);
            
            if (array_search($word, $this->historyWords) === false) {
                $this->historyWords[] = $word;
                
                return $word;
            }
        }
        
        throw new Exception\RuntimeException('Exceeded maximum count of attempts select.');
    }
    
    /**
     * Возвращает массив в перемешанном порядке.
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
