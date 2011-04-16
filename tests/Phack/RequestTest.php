<?php
namespace Phack;

require_once __DIR__ . '/TestCase.php';

/**
 * Test class for \Phack\Request.
 */
class RequestTest extends \Phack\TestCase
{
    public function testGetAddress()
    {
        $env     = array('REMOTE_ADDR' => '0.0.0.0');
        $request = new Request($env);

        $this->assertEquals('0.0.0.0', $request->getAddress());
    }

    public function testGetterAlias()
    {
        $env     = array('QUERY_STRING' => 'foo=bar');
        $request = new Request($env);

        $this->assertEquals('foo=bar', $request->getQueryString());
        $this->assertEquals('foo=bar', $request->query_string);
    }

    public function testGetGet()
    {
        $env     = array('QUERY_STRING' => 'foo=bar&baz=foo+bar');
        $request = new Request($env);

        $expected = array(
            'foo' => 'bar',
            'baz' => 'foo bar'
        );
        $this->assertSame($expected, $request->getGet());
        $this->assertSame('bar',     $request->get['foo']);
        $this->assertSame('foo bar', $request->get['baz']);
    }
}
