<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\CssSelector\Tests;

use Symfony\Component\CssSelector\CssSelector;

class CssSelectorTest extends \PHPUnit_Framework_TestCase
{
    public function testCssToXPath()
    {
        $this->assertEquals('descendant-or-self::*', CssSelector::toXPath(''));
        $this->assertEquals('descendant-or-self::h4', CssSelector::toXPath('h4'));
        $this->assertEquals("descendant-or-self::h4[@id = 'foo']", CssSelector::toXPath('h4#foo'));
        $this->assertEquals("descendant-or-self::h4[@class and contains(concat(' ', normalize-space(@class), ' '), ' foo ')]", CssSelector::toXPath('h4.foo'));
        $this->assertEquals('descendant-or-self::foo:h4', CssSelector::toXPath('foo|h4'));
    }

    /** @dataProvider getCssToXPathWithoutPrefixTestData */
    public function testCssToXPathWithoutPrefix($css, $xpath)
    {
        $this->assertEquals($xpath, CssSelector::toXPath($css, ''), '->parse() parses an input string and returns a node');
    }

    public function testParseExceptions()
    {
        try {
            CssSelector::toXPath('h4:');
            $this->fail('->parse() throws an Exception if the css selector is not valid');
        } catch (\Exception $e) {
            $this->assertInstanceOf('\Symfony\Component\CssSelector\Exception\ParseException', $e, '->parse() throws an Exception if the css selector is not valid');
            $this->assertEquals("Expected identifier, but <eof at 3> found.", $e->getMessage(), '->parse() throws an Exception if the css selector is not valid');
        }
    }

    public function getCssToXPathWithoutPrefixTestData()
    {
        return array(
            array('h4', "h4"),
            array('foo|h4', "foo:h4"),
            array('h4, h4, h3', "h4 | h4 | h3"),
            array('h4:nth-child(3n+1)', "*/*[name() = 'h4' and (position() - 1 >= 0 and (position() - 1) mod 3 = 0)]"),
            array('h4 > p', "h4/p"),
            array('h4#foo', "h4[@id = 'foo']"),
            array('h4.foo', "h4[@class and contains(concat(' ', normalize-space(@class), ' '), ' foo ')]"),
            array('h4[class*="foo bar"]', "h4[@class and contains(@class, 'foo bar')]"),
            array('h4[foo|class*="foo bar"]', "h4[@foo:class and contains(@foo:class, 'foo bar')]"),
            array('h4[class]', "h4[@class]"),
            array('h4 .foo', "h4/descendant-or-self::*/*[@class and contains(concat(' ', normalize-space(@class), ' '), ' foo ')]"),
            array('h4 #foo', "h4/descendant-or-self::*/*[@id = 'foo']"),
            array('h4 [class*=foo]', "h4/descendant-or-self::*/*[@class and contains(@class, 'foo')]"),
            array('div>.foo', "div/*[@class and contains(concat(' ', normalize-space(@class), ' '), ' foo ')]"),
            array('div > .foo', "div/*[@class and contains(concat(' ', normalize-space(@class), ' '), ' foo ')]"),
        );
    }
}
