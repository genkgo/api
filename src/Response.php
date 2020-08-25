<?php

namespace Genkgo\Api;

use Genkgo\Api\Exception\ResponseException;

class Response
{
    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $charset;

    /**
     * @var string
     */
    private $body;

    /**
     *
     */
    const TYPE_TEXT = 'text/txt';

    /**
     *
     */
    const TYPE_JSON = 'application/json';

    /**
     * @param string $body
     * @param string $contentType
     * @throws ResponseException
     */
    public function __construct($body, $contentType)
    {
        $this->body = $body;
        if (strpos($contentType, ';') === false) {
            $this->contentType = $contentType;
        } else {
            list ($this->contentType, $charset) = array_map('trim', explode(';', $contentType));
            if (strpos($charset, 'charset=') === false) {
                throw new ResponseException('Wrong content type, malformed charset: ' . $charset);
            }
            list ($key, $this->charset) = array_map('trim', explode('=', $charset));
        }
    }

    /**
     * @return string
     * @throws ResponseException
     */
    public function getBody()
    {
        switch ($this->contentType) {
            case self::TYPE_TEXT:
                return $this->body;
            case self::TYPE_JSON:
                return json_decode($this->body);
            default:
                throw new ResponseException("Unknown response type {$this->contentType}");
        }
    }

    /**
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @return mixed
     * @throws ResponseException
     */
    public function getContentType()
    {
        return $this->contentType;
    }

}
