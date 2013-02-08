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

    public function testSetAndGet()
    {
        $config = Config::getInstance();
        $config->set('test', 10);

        $this->assertSame(10, $config->get('test'));
    }

    public function testSetPathAndGetPath()
    {
        $config = Config::getInstance();
        $config->setPath('test', 'test.txt');

        $this->assertSame('test.txt', $config->getPath('test'));
    }
    
    public function testSetPathAndGetPath_PathWithPrefix()
    {
    	$config = Config::getInstance();
    	$config->setPrefixPath('/path');
    	$config->setPath('test', 'test.txt');
        
        $this->assertSame('/path/test.txt', $config->getPath('test'));
    }
    
    public function testClear()
    {
        $config = Config::getInstance();
        $config->set('test', 1);
        $config->setPrefixPath('/path');
    	$config->setPath('test', 'test.txt');
        $config->clear();

        $this->assertNull($config->get('test'));
        $this->assertNull($config->getPath('test'));
        
        $config->setPath('test', 'test.txt');
        $this->assertSame('test.txt', $config->getPath('test'));
    }
    
    public function testGet_OptionNotExist()
    {
    	$config = Config::getInstance();
        
        $this->assertNull($config->get('test'));
    }
    
    public function testGetPath_PathNotExist()
    {
    	$config = Config::getInstance();
        
        $this->assertNull($config->getPath('test'));
    }
}
