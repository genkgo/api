<?php
namespace Genkgo\Api;

use Genkgo\Api\Exception\ResponseException;

/**
 * Class Response
 * @package Genkgo\Api
 */
class Response {

    /**
     * @var string
     */
    private $contentType;
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
     */
    public function __construct($body, $contentType)
    {
        $this->body = $body;
        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     * @throws ResponseException
     */
    public function getContentType()
    {
        switch ($this->contentType) {
            case self::TYPE_TEXT:
                return new Response($this->body, $this->contentType);
            case self::TYPE_JSON:
                return new Response(json_decode($this->body), $this->contentType);
            default:
                throw new ResponseException(
                    "Unknown response type"
                );
        }
    }

}