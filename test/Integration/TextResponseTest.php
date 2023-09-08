<?php

declare(strict_types=1);

namespace Genkgo\TestApi\Integration;

use Genkgo\Api\Connection;
use Genkgo\Api\Response;
use Genkgo\Api\StringStream;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class TextResponseTest extends TestCase
{
    public function testText(): void
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
            ->method('getBody')
            ->willReturn(new StringStream('true'));

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn(['text/txt']);

        $connection = new Connection($client, new HttpFactory(), 'https://www.url.com/', 'token');
        $response = $connection->command('organization', 'login', [
            'uid' => 'username',
            'password' => 'password'
        ]);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('true', $response->getBody());
    }
}
