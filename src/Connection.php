<?php
namespace Genkgo\Api;

use Genkgo\Api\Exception\ResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;

/**
 * Class Connection
 * @package Genkgo\Api
 */
class Connection {

    /**
     * @var
     */
    private $address;

    /**
     * @var
     */
    private $token;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     * @param $address
     * @param $token
     */
    public function __construct (Client $client, $address, $token) {
        $this->client = $client;
        $this->address = $address;
        $this->token = $token;
    }

    /**
     * @param $part
     * @param $command
     * @param array $parameters
     * @return Response
     * @throws ResponseException
     */
    public function command ($part, $command, $parameters=array()) {
        $data = array(
            'part'	=> (string) $part,
            'command'	=> (string) $command,
            'token'	=> (string) $this->token
        );
        $data = array_merge($data, $parameters);
        return $this->post($data);
    }

    /**
     * @param $data
     * @return Response
     * @throws ResponseException
     */
    protected function post ($data) {
        $client = $this->client;
        try {
            $response = $client->post($this->address, [
                'form_params' => $data
            ]);
        } catch (ServerException $e) {
            $responseStatus = $e->getResponse()->getStatusCode();
            $responseMsg = $e->getResponse()->getBody();

            throw new ResponseException(
                "Request failed with command {$data['command']}, status code {$responseStatus} and message {$responseMsg}"
            );
        }

        $body = (string) $response->getBody();

        $contentType = $response->getHeader('content-type');
        if (count($contentType) === 0) {
            throw new ResponseException(
                "Response did not contains a Content-Type header"
            );
        }

        $contentType = $contentType[0];

        return new Response($body, $contentType);
    }
}