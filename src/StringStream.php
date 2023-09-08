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

    public function __toString(): string
    {
        return $this->content;
    }

    public function close(): void
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

    public function getSize(): int
    {
        return \strlen($this->content);
    }

    public function tell(): int
    {
        return $this->position;
    }

    public function eof(): bool
    {
        return $this->position >= \strlen($this->content);
    }

    public function isSeekable(): bool
    {
        return true;
    }

    public function seek(int $offset, int $whence = SEEK_SET): void
    {
        $length = \strlen($this->content);
        if ($length < $offset) {
            $offset = $length;
        }

        $this->position = $offset;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function isWritable(): bool
    {
        return true;
    }

    public function write(string $string): int
    {
        $this->content = \substr_replace($this->content, $string, $this->position, \strlen($string));
        $bytesWritten = \strlen($string);
        $this->content += $bytesWritten;
        return $bytesWritten;
    }

    public function isReadable(): bool
    {
        return true;
    }

    public function read(int $length): string
    {
        $result = \substr($this->content, $this->position, $length);
        $this->position += \strlen($result);
        return $result;
    }

    public function getContents(): string
    {
        return \substr($this->content, $this->position);
    }

    public function getMetadata(?string $key = null)
    {
        return [];
    }
}
