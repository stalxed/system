<?php
namespace StalxedTest\System;

use Stalxed\System\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Config::unsetInstance();
        
        parent::tearDown();
    }

    public function testSetAndGet_SomeValue()
    {
        $config = Config::getInstance();
        $config->set('test', 10);

        $this->assertSame(10, $config->get('test'));
    }

    public function testSetAndGetPath_SomePath()
    {
        $config = Config::getInstance();
        $config->setPath('test', 'test.txt');

        $this->assertSame('test.txt', $config->getPath('test'));
    }
    
    public function testSetAndGetPath_PathWithPrefix()
    {
    	$config = Config::getInstance();
    	$config->setPrefixPath('/path');
    	$config->setPath('test', 'test.txt');
        
        $this->assertSame('/path/test.txt', $config->getPath('test'));
    }
    
    public function testClear_SomeOptionSet()
    {
        $config = Config::getInstance();
        $config->set('test', 1);
        $config->clear();

        $this->assertNull($config->get('test'));
    }
    
    public function testClear_SomePathSet()
    {
        $config = Config::getInstance();
        $config->setPath('test', 'test.txt');
        $config->clear();
    
        $this->assertNull($config->getPath('test'));
    }
    
    public function testClear_SomePathWithPrefixSet()
    {
        $config = Config::getInstance();
        $config->setPrefixPath('/path');
        $config->clear();
        $config->setPath('test', 'test.txt');
        
        $this->assertSame('test.txt', $config->getPath('test'));
    }
    
    public function testGet_NonexistentOption()
    {
    	$config = Config::getInstance();
        
        $this->assertNull($config->get('test'));
    }
    
    public function testGetPath_NonexistentPath()
    {
    	$config = Config::getInstance();
        
        $this->assertNull($config->getPath('test'));
    }
}
