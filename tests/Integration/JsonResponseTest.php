<?php
namespace Genkgo\Api\Integration;

use Genkgo\Api\Connection;
use Genkgo\Api\Response;
use GuzzleHttp\Client;
use Psr\Http\Message\MessageInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class JsonResponseTest extends TestCase {

    public function testJson () {
        $httpRequest = $this->getMockBuilder(Client::class)->setMethods(['post'])->getMock();
        $httpResponse = $this->getMockBuilder(MessageInterface::class)->getMock();

        $httpRequest
            ->expects($this->once())
            ->method('post')
            ->with('https://www.url.com/', [
                'form_params' => [
                    'token' => 'token',
                    'part' => 'organization',
                    'command' => 'tree'
                ]])
            ->willReturn($httpResponse)
        ;

        $httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([['id' => 1, 'name'=> 'Top Element']]))
        ;

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn(['application/json'])
        ;

        $connection = new Connection($httpRequest, 'https://www.url.com/', 'token');
        $response = $connection->command('organization', 'tree');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertContainsOnlyInstancesOf(StdClass::class, $response->getBody());
        $this->assertEquals('Top Element', $response->getBody()[0]->name);
    }

    public function testJsonWithCharset () {
        $httpRequest = $this->getMockBuilder(Client::class)->setMethods(['post'])->getMock();
        $httpResponse = $this->getMockBuilder(MessageInterface::class)->getMock();

        $httpRequest
            ->expects($this->once())
            ->method('post')
            ->willReturn($httpResponse)
        ;

        $httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->willReturn(json_encode([['id' => 1, 'name'=> 'Top Element']]))
        ;

        $httpResponse
            ->expects($this->once())
            ->method('getHeader')
            ->with('content-type')
            ->willReturn(['application/json; charset=UTF-8'])
        ;

        $connection = new Connection($httpRequest, 'https://www.url.com/', 'token');
        $response = $connection->command('organization', 'tree');

        $this->assertEquals('application/json', $response->getContentType());
        $this->assertEquals('UTF-8', $response->getCharset());
        $this->assertContainsOnlyInstancesOf(StdClass::class, $response->getBody());
        $this->assertEquals('Top Element', $response->getBody()[0]->name);
    }

}
