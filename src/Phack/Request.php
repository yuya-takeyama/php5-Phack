<?php
namespace Phack;

/**
 * The class represents HTTP request to Phack.
 */
class Request
{
    /**
     * Environment variables.
     *
     * @var array
     */
    protected $_env;

    /**
     * Constructor.
     *
     * @param  array $env Environment variable.
     */
    public function __construct($env)
    {
        $this->_env = $env;
    }

    /**
     * Unified alias to getter methods.
     *
     * <code>
     * $queryString = $request->getQueryString();
     * $queryString = $request->query_string;     // Alias.
     * </code>
     *
     * @param  string $key Key of the property.
     * @return mixed       Value.
     */
    public function __get($key)
    {
        $method = 'get' . Util::toCamelCase($key);
        if (method_exists($this, $method)) {
            $result = $this->$method();
        } else {
            $result = NULL;
        }
        return $result;
    }

    public function getGet()
    {
        return Util::parseQuery($this->getQueryString());
    }

    public function getAddress()
    {
        return $this->_env['REMOTE_ADDR'];
    }

    public function getRemoteHost()
    {
        return $this->_env['REMOTE_HOST'];
    }

    public function getProtocol()
    {
        return $this->_env['SERVER_PROTOCOL'];
    }

    public function getMethod()
    {
        return $this->_env['REQUEST_METHOD'];
    }

    public function getPort()
    {
        return (int)$this->_env['SERVER_PORT'];
    }

    public function getPathInfo()
    {
        return $this->_env['PATH_INFO'];
    }

    public function getQueryString()
    {
        return $this->_env['QUERY_STRING'];
    }

    public function getContentLength()
    {
        return $this->_env['CONTENT_LENGTH'];
    }

    public function getContentType()
    {
        return $this->_env['CONTENT_TYPE'];
    }
}
