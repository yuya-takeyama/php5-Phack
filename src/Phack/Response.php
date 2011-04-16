<?php
namespace Phack;

/**
 * The class represents a Phack response.
 *
 * It has body, status and headers of HTTP protocol.
 */
class Response implements \ArrayAccess, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $_body;

    /**
     * @var int
     */
    protected $_status;

    /**
     * @var array
     */
    protected $_headers;

    /**
     * @var int
     */
    protected $_length;

    /**
     * Constructor.
     *
     * Creates a object which has body, status and headers of HTTP protocol.
     * By default, it is as a html with empty content.
     *
     * @param  string|array|Traversable $body   HTTP response body.
     * @param  int                      $status HTTP status code.
     * @param  array                    $header HTTP response headers.
     */
    public function __construct($body = array(), $status = 200, $headers = array())
    {
        $this->_body    = array();
        $this->_status  = (int)$status;
        $this->_headers = \array_merge(
            array('Content-Type' => 'text/html'),
            $headers
        );
        $this->_length = 0;

        $this->_buildBody($body);
    }

    /**
     * Gets the set of HTTP headers.
     *
     * @return array Key-Value pair of HTTP headers.
     */
    public function getHeaders()
    {
        return $this->_headers;
    }

    /**
     * Gets the HTTP status code.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Gets the body;
     *
     * @return string
     */
    public function getBody()
    {
        return $this->_body;
    }

    /**
     * Gets Iterator (Array) of HTTP body.
     *
     * Makes the response to behave as Traversable.
     */
    public function getIterator()
    {
        return $this->_body;
    }

    /**
     * Gets the length of HTTP response body.
     *
     * @return int
     */
    public function getLength()
    {
        return $this->_length;
    }

    /**
     * Gets the value from the HTTP headers.
     *
     * @param  string $key Key of the HTTP header.
     * @return string      Value of the HTTP header.
     */
    public function offsetGet($key)
    {
        return $this->_headers[$key];
    }

    /**
     * Sets a value of the HTTP header.
     *
     * @param  string $key   Key of HTTP header.
     * @return string $value Value of HTTP header.
     */
    public function offsetSet($key, $value)
    {
        $this->_headers[$key] = $value;
    }

    /**
     * Whether the HTTP header exists.
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return \array_key_exists($key, $this->_headers);
    }

    /**
     * Removes a value from the HTTP headers.
     *
     * @param  string $key Key of the HTTP header.
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->_headers[$key]);
    }

    /**
     * Returns HTTP response as array.
     *
     * @return array +int        HTTP status code.
     *               +array      HTTP response headers.
     *               +array|self HTTP response body.
     */
    public function finish()
    {
        if ($this->_status === 204 || $this->_status === 304) {
            unset($this->_headers['Content-Type']);
            $result = array($this->_status, $this->_headers, array());
        } else {
            $result = array($this->_status, $this->_headers, $this);
        }
        return $result;
    }

    /**
     * Builds the HTTP body.
     *
     * @param  string|array|Traversable $body Value represents HTTP body.
     * @return void
     */
    protected function _buildBody($body)
    {
        if (\is_string($body)) {
            $this->_write($body);
        } else if (\is_array($body) || $body instanceof Traversable) {
            foreach ($body as $part) {
                $this->_write($part);
            }
        }
    }

    /**
     * Appends to body and updates its length.
     *
     * @param  string $str String to append to the body.
     * @return void
     */
    protected function _write($str)
    {
        $this->_body[] .= $str;
        $this->_length += \strlen($str);

        $this->_headers['Content-Length'] = $this->_length;
    }
}
