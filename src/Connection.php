<?php

declare(strict_types=1);

namespace Genkgo\Api;

use Genkgo\Api\Exception\ResponseException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

final class Connection
{
    public function __construct(
        private ClientInterface $client,
        private RequestFactoryInterface $requestFactory,
        private string $address,
        private string $token
    ) {
    }

    /**
     * @throws ResponseException
     */
    public function command(string $part, string $command, array $parameters = []): Response
    {
        $data = [
            'part' => $part,
            'command' => $command,
            'token' => $this->token
        ];

        $data = \array_merge($data, $parameters);
        return $this->post($data);
    }

    /**
     * @throws ResponseException
     */
    private function post(array $data): Response
    {
        try {
            $response = $this->client->sendRequest(
                $this->requestFactory->createRequest('POST', $this->address)
                    ->withBody(new StringStream(\http_build_query($data, '', '&')))
            );

            $responseStatus = $response->getStatusCode();
            if ($responseStatus >= 400) {
                $responseMsg = $response->getBody();

                throw new ResponseException(
                    "Request failed with command {$data['command']}, status code {$responseStatus} and message {$responseMsg}"
                );
            }
        } catch (ClientExceptionInterface $e) {
            \var_dump($e);
            throw new ResponseException(
                "Request failed with command {$data['command']}, {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }

        $body = (string)$response->getBody();

        $contentType = $response->getHeader('content-type');
        if (\count($contentType) === 0) {
            throw new ResponseException(
                "Response did not contains a Content-Type header"
            );
        }

        $contentType = $contentType[0];

        return new Response($body, $contentType);
    }
}
