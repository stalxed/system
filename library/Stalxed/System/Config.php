<?php
namespace Stalxed\System;

/**
 * Содержит конфигурационные данные.
 *
 */
class Config
{
    /**
     * Экземпляр класса.
     *
     * @var \Stalxed\System\Config
     */
    private static $instance;
    /**
     * Опции конфигурации.
     *
     * @var array
     */
    private $options = array();
    /**
     * Префикс пути.
     *
     * @var string
     */
    private $prefixPath;
    /**
     * Пути к элементам.
     *
     * @var array
     */
    private $paths = array();

    /**
     * Запрет вызова конструктора извне класса.
     *
     */
    private function __construct()
    {
    }

    /**
     * Запрет вызова метода __clone извне класса.
     *
     */
    private function __clone()
    {
    }

    /**
     * Возвращает экземпляр класса.
     *
     * @return System_Config
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
     * @param System_Config $instance
     */
    public static function setInstance(System_Config $instance)
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
     * Устанавливает опцию конфигурации.
     * 
     * @param string $name
     * @param string $value
     */
    public function set($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * Устанавливает префикс пути.
     *
     * @param string $prefixPath
     */
    public function setPrefixPath($prefixPath)
    {
        $this->prefixPath = $prefixPath;
    }

    /**
     * Устанавливает путь к элементу.
     *
     * @param string $name
     * @param string $value
     */
    public function setPath($name, $value)
    {
        $this->paths[$name] = $value;
    }

    /**
     * Очищает конфигурационные данные.
     *
     */
    public function clear()
    {
        $this->options = array();
        unset($this->prefixPath);
        $this->paths = array();
    }

    /**
     * Возвращает опцию конфигурации.
     *
     * @param string $name
     * 
     * @return string
     */
    public function get($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * Возвращает путь к элементу.
     * Подставляется префикс пути, если он установлен.
     *
     * @param string $name
     * 
     * @return string
     */
    public function getPath($name)
    {
        if (!isset($this->paths[$name])) {
            return null;
        }

        if (isset($this->prefixPath)) {
            return $this->prefixPath . '/' . $this->paths[$name];
        } else {
            return $this->paths[$name];
        }
    }
}
