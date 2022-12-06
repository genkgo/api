<?php

declare(strict_types=1);

namespace Genkgo\Api;

use Psr\Http\Message\StreamInterface;

final class StringStream implements StreamInterface
{
    private int $position = 0;

    public function __construct(private string $content)
    {
    }

    public function __toString()
    {
        return $this->content;
    }

    public function close()
    {
    }

    public function detach()
    {
        $handle = \fopen('php://memory', 'r+');
        if ($handle === false) {
            throw new \UnexpectedValueException('Cannot open php://memory for writing');
        }

        \fwrite($handle, $this->content);
        return $handle;
    }

    public function getSize()
    {
        return \strlen($this->content);
    }

    public function tell()
    {
        return $this->position;
    }

    public function eof()
    {
        return $this->position >= \strlen($this->content);
    }

    public function isSeekable()
    {
        return true;
    }

    public function seek($offset, $whence = SEEK_SET)
    {
        $length = \strlen($this->content);
        if ($length < $offset) {
            $offset = $length;
        }

        $this->position = $offset;
        return 0;
    }

    public function rewind()
    {
        $this->position = 0;
        return true;
    }

    public function isWritable()
    {
        return true;
    }

    public function write($string)
    {
        $this->content = \substr_replace($this->content, $string, $this->position, \strlen($string));
        $bytesWritten = \strlen($string);
        $this->content += $bytesWritten;
        return $bytesWritten;
    }

    public function isReadable()
    {
        return true;
    }

    public function read($length)
    {
        $result = \substr($this->content, $this->position, $length);
        $this->position += \strlen($result);
        return $result;
    }

    public function getContents()
    {
        return \substr($this->content, $this->position);
    }

    public function getMetadata($key = null)
    {
        return [];
    }
}
