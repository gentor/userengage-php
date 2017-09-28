<?php

namespace Gentor\Userengage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;

/**
 * Class UserengageClient
 * @package Gentor\Userengage
 */
class UserengageClient
{
    /** @var Client $httpClient */
    private $httpClient;

    /**
     * @var
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $endPoint = 'https://app.userengage.com/api/public/';

    /**
     * UserengageClient constructor.
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new Client();
    }

    /**
     * @param $endpoint
     * @param array $query
     * @return mixed
     */
    public function get($endpoint, $query = [])
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->endPoint . $endpoint,
                array_merge($this->setHeaders(), ['query' => $query])
            );
        } catch (ClientException $e) {
            return $this->handleException($e);
        }

        return $this->handleResponse($response);
    }

    /**
     * @param $endpoint
     * @param array $options
     * @return mixed
     */
    public function post($endpoint, array $options)
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->endPoint . $endpoint,
                array_merge($this->setHeaders(), ['json' => $options])
            );
        } catch (ClientException $e) {
            return $this->handleException($e);
        }

        return $this->handleResponse($response);
    }

    /**
     * @param $endpoint
     * @param array $options
     * @return mixed
     */
    public function put($endpoint, array $options)
    {
        try {
            $response = $this->httpClient->request(
                'PUT',
                $this->endPoint . $endpoint,
                array_merge($this->setHeaders(), ['json' => $options])
            );
        } catch (ClientException $e) {
            return $this->handleException($e);
        }

        return $this->handleResponse($response);
    }

    /**
     * @param $endpoint
     * @return mixed
     */
    public function delete($endpoint)
    {
        try {
            $response = $this->httpClient->request(
                'DELETE',
                $this->endPoint . $endpoint,
                $this->setHeaders()
            );
        } catch (ClientException $e) {
            return $this->handleException($e);
        }

        return $this->handleResponse($response);
    }

    /**
     * @param $results
     * @return mixed|object
     */
    public function nextPage($results)
    {
        if (!isset($results->next)) {
            return $this->emptyResult();
        }

        $response = $this->httpClient->request('GET', $results->next, $this->setHeaders());

        return $this->handleResponse($response);
    }

    /**
     * @param $results
     * @return mixed|object
     */
    public function previousPage($results)
    {
        if (!isset($results->previous)) {
            return $this->emptyResult();
        }

        $response = $this->httpClient->request('GET', $results->previous, $this->setHeaders());

        return $this->handleResponse($response);
    }

    /**
     * @param ClientException $exception
     * @return mixed
     */
    protected function handleException(ClientException $exception)
    {
        $response = $exception->getResponse();

        return $this->handleResponse($response);
    }

    /**
     * @return object
     */
    protected function emptyResult()
    {
        return (object)['results' => []];
    }

    /**
     * @return array
     */
    private function setHeaders()
    {
        return [
            'headers' => [
                'Authorization' => 'Token ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ]
        ];
    }

    /**
     * @param Response $response
     * @return mixed
     */
    private function handleResponse(Response $response)
    {
        $stream = stream_for($response->getBody());
        $data = json_decode($stream);
        return $data;
    }
}