<?php
namespace Stalxed\System;

/**
 * The class contains the configuration data.
 *
 */
class Config
{
    /**
     * An instance of the class.
     *
     * @var \Stalxed\System\Config
     */
    private static $instance;
    /**
     * Configuration options.
     *
     * @var array
     */
    private $options = array();
    /**
     * The prefix of path.
     *
     * @var string
     */
    private $prefixPath;
    /**
     * Paths.
     *
     * @var array
     */
    private $paths = array();

    /**
     * Prohibits calling the constructor outside the class.
     * Implementing the Singleton Pattern
     */
    private function __construct()
    {
    }

    /**
     * Prohibits the cloning procedure.
     * Implementing the Singleton Pattern
     */
    private function __clone()
    {
    }

    /**
     * Returns an instance of the class.
     *
     * @return \Stalxed\System\Config
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Sets the instance of the class.
     *
     * @param \Stalxed\System\Config $instance
     */
    public static function setInstance(Config $instance)
    {
        self::$instance = $instance;
    }

    /**
     * Destroys the instance of the class.
     */
    public static function unsetInstance()
    {
        self::$instance = null;
    }

    /**
     * Sets a configuration option.
     *
     * @param string $name
     * @param string $value
     */
    public function set($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * Sets the prefix path.
     *
     * @param string $prefixPath
     */
    public function setPrefixPath($prefixPath)
    {
        $this->prefixPath = $prefixPath;
    }

    /**
     * Sets the path.
     *
     * @param string $name
     * @param string $value
     */
    public function setPath($name, $value)
    {
        $this->paths[$name] = $value;
    }

    /**
     * Cleans up the configuration data.
     */
    public function clear()
    {
        $this->options = array();
        unset($this->prefixPath);
        $this->paths = array();
    }

    /**
     * Returns a configuration option.
     *
     * @param string $name
     * @return string
     */
    public function get($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * Returns the path.
     * Adds the prefix path, if it is set.
     *
     * @param string $name
     * @return string
     */
    public function getPath($name)
    {
        if (! isset($this->paths[$name])) {
            return null;
        }

        if (isset($this->prefixPath)) {
            return $this->prefixPath . '/' . $this->paths[$name];
        } else {
            return $this->paths[$name];
        }
    }
}
