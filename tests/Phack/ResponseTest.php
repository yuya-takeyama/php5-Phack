<?php
namespace Phack;

require_once __DIR__ . '/TestCase.php';

/**
 * Test class for \Phack\Response.
 */
class ResponseTest extends \Phack\TestCase
{
    public function testEmptyResponse()
    {
        $response = new Response;

        $this->assertEquals(200,         $response->getStatus());
        $this->assertEquals('text/html', $response['Content-Type']);
        $this->assertEquals(array(),     $response->getBody());
        $this->assertEquals(0,           $response->getLength());
    }

    public function testResponseHasSpecifiedValues()
    {
        $response = new Response(
            array('Foo', 'Bar', 'Baz'),
            404,
            array(
                'X-Foo' => 'FooBar'
            )
        );

        $this->assertEquals(404,                        $response->getStatus());
        $this->assertEquals('text/html',                $response['Content-Type']);
        $this->assertEquals('FooBar',                   $response['X-Foo']);
        $this->assertEquals(array('Foo', 'Bar', 'Baz'), $response->getBody());
        $this->assertEquals(9,                          $response->getLength());
    }
}
