<?php

declare(strict_types=1);

namespace Genkgo\Api;

use Genkgo\Api\Exception\ResponseException;

final class Response
{
    public const TYPE_TEXT = 'text/txt';
    public const TYPE_JSON = 'application/json';
    private string $contentType;
    private string $charset;

    /**
     * @throws ResponseException
     */
    public function __construct(private string $body, string $contentType)
    {
        $this->body = $body;
        if (!\str_contains($contentType, ';')) {
            $this->contentType = $contentType;
        } else {
            [$this->contentType, $charset] = \array_map('trim', \explode(';', $contentType));
            if (!\str_contains($charset, 'charset=')) {
                throw new ResponseException('Wrong content type, malformed charset: ' . $charset);
            }

            [, $this->charset] = \array_map(fn (string $part) => \trim($part), \explode('=', $charset));
        }
    }

    /**
     * @throws ResponseException
     */
    public function getBody(): mixed
    {
        return match ($this->contentType) {
            self::TYPE_TEXT => $this->body,
            self::TYPE_JSON => \json_decode($this->body),
            default => throw new ResponseException("Unknown response type {$this->contentType}"),
        };
    }

    public function getCharset(): string
    {
        return $this->charset;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }
}
