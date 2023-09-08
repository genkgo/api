<?php

declare(strict_types=1);

namespace Genkgo\TestApi\Integration;

use Genkgo\Api\Connection;
use Genkgo\Api\Exception\ResponseException;
use Genkgo\Api\StringStream;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\HttpFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use PHPUnit\Framework\TestCase;

final class ErrorResponseTest extends TestCase
{
    public function testClientError(): void
    {
        $client = $this->createMock(Client::class);
        $httpResponse = $this->createMock(ResponseInterface::class);

        $httpResponse
            ->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(404);

        $httpResponse
            ->expects($this->any())
            ->method('getBody')
            ->willReturn(new StringStream('error message'));

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($this->isInstanceOf(RequestInterface::class))
            ->willReturn($httpResponse);

        $this->expectException(ResponseException::class);
        $this->expectExceptionMessage('Request failed with command unknown, status code 404 and message error message');
        $connection = new Connection($client, new HttpFactory(), 'https://www.url.com/', 'token');
        $connection->command('unknown', 'unknown');
    }

    public function testResponseError(): void
    {
        $client = $this->createMock(Client::class);
        $httpResponse = $this->createMock(ResponseInterface::class);

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($this->isInstanceOf(RequestInterface::class))
            ->willReturn($httpResponse);

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn([]);

        $this->expectException(ResponseException::class);
        $this->expectExceptionMessage('Response did not contains a Content-Type header');
        $connection = new Connection($client, new HttpFactory(), 'https://www.url.com/', 'token');
        $connection->command('unknown', 'unknown');
    }

    public function testUnknownContentType(): void
    {
        $client = $this->createMock(Client::class);
        $httpResponse = $this->createMock(ResponseInterface::class);

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($this->isInstanceOf(RequestInterface::class))
            ->willReturn($httpResponse);

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn(['application/unknown']);

        $this->expectException(ResponseException::class);
        $this->expectExceptionMessage('Unknown response type application/unknown');

        $connection = new Connection($client, new HttpFactory(), 'https://www.url.com/', 'token');
        $response = $connection->command('unknown', 'unknown');
        $response->getBody();
    }

    public function testMalformedContentType(): void
    {
        $client = $this->createMock(Client::class);
        $httpResponse = $this->createMock(ResponseInterface::class);

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with($this->isInstanceOf(RequestInterface::class))
            ->willReturn($httpResponse);

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn(['application/unknown; UTF-8']);

        $this->expectException(ResponseException::class);
        $this->expectExceptionMessage('Wrong content type, malformed charset: UTF-8');

        $connection = new Connection($client, new HttpFactory(), 'https://www.url.com/', 'token');
        $response = $connection->command('unknown', 'unknown');
        $response->getBody();
    }
}
