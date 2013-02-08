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
    private static $instance;
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
    
    /**
     * Список сгенерированных слов.
     * 
     * @var array
     */
    private $history_words = array();
    
    /**
     * Запрет вызова конструктора извне класса.
     * 
     */
    protected function __construct()
    {
    }
    
    /**
     * Запрет вызова метода __clone извне класса.
     * 
     */
    protected function __clone()
    {
    }
    
    /**
     * Возвращает экземпляр класса.
     *
     * @return System_Random
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Устанавливает экземпляр класса.
     * 
     * @param System_Random $instance
     */
    public static function setInstance(Random $instance)
    {
        self::$instance = $instance;
    }
    
    /**
     * Уничтожает экземпляр класса.
     * 
     */
    public static function unsetInstance()
    {
        self::$instance = null;
    }
    
    /**
     * Возвращает случайное число в указанном диапазоне.
     * 
     * @param integer $min_digit
     * @param integer $max_digit
     * @return integer
     */
    public function getDigit($min_digit, $max_digit)
    {
        return mt_rand($min_digit, $max_digit);
    }
    
    /**
     * Возвращает случайное число в указанном диапазоне.
     * Числа, указанные в списке исключений не могут быть
     * возвращены.
     * 
     * @param integer $min_digit
     * @param integer $max_digit
     * @param array $exceptions
     * @return integer
     * @throws Exception
     */
    public function getDigitWithExceptions($min_digit, $max_digit, array $exceptions = array())
    {
        $max_count_attempts_select = $max_digit - $min_digit + 1;
        for ($i = 0; $i < $max_count_attempts_select; $i++) {
            $digit = $this->getDigit($min_digit, $max_digit);
            if (array_search($digit, $exceptions) !== false) {
                continue;
            }
            
            return $digit;
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
        $count_symbols = $this->getDigit($min_symbols, $max_symbols);
        for ($i = 0; $i < $count_symbols; $i++) {
            $index = $this->getDigit(0, count($this->symbols) - 1);
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
            
            if (array_search($word, $this->history_words) === false) {
                $this->history_words[] = $word;
                
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
