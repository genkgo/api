<?php

declare(strict_types=1);

namespace Genkgo\TestApi\Integration;

use Genkgo\Api\Connection;
use Genkgo\Api\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

final class JsonResponseTest extends TestCase
{
    public function testJson(): void
    {
        $client = $this->createMock(Client::class);
        $httpResponse = $this->createMock(ResponseInterface::class);

        $client
            ->expects($this->once())
            ->method('sendRequest')
            ->with(
                $this->callback(
                    function (RequestInterface $request) {
                        $this->assertEquals('part=organization&command=tree&token=token', (string)$request->getBody());
                        return true;
                    }
                )
            )
            ->willReturn($httpResponse);

        $httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(\json_encode([['id' => 1, 'name' => 'Top Element']]));

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn(['application/json']);

        $connection = new Connection($client, new HttpFactory(), 'https://www.url.com/', 'token');
        $response = $connection->command('organization', 'tree');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertContainsOnlyInstancesOf(StdClass::class, $response->getBody());
        $this->assertEquals('Top Element', $response->getBody()[0]->name);
    }

    public function testJsonWithCharset(): void
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
            ->willReturn(\json_encode([['id' => 1, 'name' => 'Top Element']]));

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn(['application/json; charset=UTF-8']);

        $connection = new Connection($client, new HttpFactory(), 'https://www.url.com/', 'token');
        $response = $connection->command('organization', 'tree');

        $this->assertEquals('application/json', $response->getContentType());
        $this->assertEquals('UTF-8', $response->getCharset());
        $this->assertContainsOnlyInstancesOf(StdClass::class, $response->getBody());
        $this->assertEquals('Top Element', $response->getBody()[0]->name);
    }
}
