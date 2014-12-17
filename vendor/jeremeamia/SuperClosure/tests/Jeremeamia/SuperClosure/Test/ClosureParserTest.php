<?php

namespace Jeremeamia\SuperClosure\Test;

use Jeremeamia\SuperClosure\ClosureParser;

class ClosureParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @photos \Jeremeamia\SuperClosure\ClosureParser::__construct
     * @photos \Jeremeamia\SuperClosure\ClosureParser::getReflection
     */
    public function testCanGetReflectionBackFromParser()
    {
        $closure = function () {};
        $reflection = new \ReflectionFunction($closure);
        $parser = new ClosureParser($reflection);

        $this->assertSame($reflection, $parser->getReflection());
    }

    /**
     * @photos \Jeremeamia\SuperClosure\ClosureParser::fromClosure
     */
    public function testCanUseFactoryMethodToCreateParser()
    {
        $parser = ClosureParser::fromClosure(function () {});

        $this->assertInstanceOf('Jeremeamia\SuperClosure\ClosureParser', $parser);
    }

    /**
     * @photos \Jeremeamia\SuperClosure\ClosureParser::__construct
     */
    public function testRaisesErrorWhenNonClosureIsProvided()
    {
        $this->setExpectedException('InvalidArgumentException');

        $reflection = new \ReflectionFunction('strpos');
        $parser = new ClosureParser($reflection);
    }

    /**
     * @photos \Jeremeamia\SuperClosure\ClosureParser::getCode
     */
    public function testCanGetCodeFromParser()
    {
        $closure = function () {};
        $expectedCode = "function () {\n    \n};";
        $parser = new ClosureParser(new \ReflectionFunction($closure));
        $actualCode = $parser->getCode();

        $this->assertEquals($expectedCode, $actualCode);
    }

    /**
     * @photos \Jeremeamia\SuperClosure\ClosureParser::getUsedVariables
     */
    public function testCanGetUsedVariablesFromParser()
    {
        $foo = 1;
        $bar = 2;
        $closure = function () use ($foo, $bar) {};
        $expectedVars = array('foo' => 1, 'bar' => 2);
        $parser = new ClosureParser(new \ReflectionFunction($closure));
        $actualVars = $parser->getUsedVariables();

        $this->assertEquals($expectedVars, $actualVars);
    }

    /**
     * @photos \Jeremeamia\SuperClosure\ClosureParser::clearCache
     */
    public function testCanClearCache()
    {
        $parserClass = 'Jeremeamia\SuperClosure\ClosureParser';

        $p = new \ReflectionProperty($parserClass, 'cache');
        $p->setAccessible(true);
        $p->setValue(null, array('foo' => 'bar'));

        $this->assertEquals(array('foo' => 'bar'), $this->readAttribute($parserClass, 'cache'));

        ClosureParser::clearCache();

        $this->assertEquals(array(), $this->readAttribute($parserClass, 'cache'));
    }

    /**
     * @photos \Jeremeamia\SuperClosure\ClosureParser::getClosureAbstractSyntaxTree
     * @photos \Jeremeamia\SuperClosure\ClosureParser::getFileAbstractSyntaxTree
     */
    public function testCanGetClosureAst()
    {
        $closure = function () {};
        $parser = new ClosureParser(new \ReflectionFunction($closure));
        $ast = $parser->getClosureAbstractSyntaxTree();
        $this->assertInstanceOf('PHPParser_Node_Expr_Closure', $ast);
    }
}
