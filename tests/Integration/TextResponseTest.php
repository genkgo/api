<?php

namespace Genkgo\Api\Integration;

use Genkgo\Api\Connection;
use Genkgo\Api\Response;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class TextResponseTest extends TestCase
{

    public function testText()
    {
        $httpRequest = $this->getMockBuilder(Client::class)->setMethods(['post'])->getMock();
        $httpResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $httpRequest
            ->expects($this->once())
            ->method('post')
            ->with('https://www.url.com/', [
                'form_params' => [
                    'token' => 'token',
                    'part' => 'organization',
                    'command' => 'login',
                    'uid' => 'username',
                    'password' => 'password'
                ]])
            ->willReturn($httpResponse);

        $httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn('true');

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn(['text/txt']);

        $connection = new Connection($httpRequest, 'https://www.url.com/', 'token');
        $response = $connection->command('organization', 'login', [
            'uid' => 'username',
            'password' => 'password'
        ]);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('true', $response->getBody());
    }

}
