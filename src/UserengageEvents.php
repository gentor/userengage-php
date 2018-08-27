<?php

namespace Gentor\Userengage;

use Carbon\Carbon;

/**
 * Class UserengageEvents
 * @package Gentor\Userengage
 */
class UserengageEvents
{
    /** @var UserengageClient $client */
    private $client;

    /**
     * @var string
     */
    protected $endPoint = 'events/';

    /**
     * UserengageUsers constructor.
     * @param UserengageClient $client
     */
    public function __construct(UserengageClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function create($client, $name, array $data = [], $timestamp = null)
    {
        $options = [
            'client' => $client,
            'name' => $name,
            'data' => $data,
            'timestamp' => is_null($timestamp) ? Carbon::now()->timestamp : $timestamp
        ];

        return $this->client->post($this->endPoint, $options);
    }

    /**
     * @param array $options
     * @return mixed
     */
    public function createByUserId($userId, $name, array $data = [], $timestamp = null)
    {
        $options = [
            'user_id' => $userId,
            'name' => $name,
            'data' => $data,
            'timestamp' => is_null($timestamp) ? Carbon::now()->timestamp : $timestamp
        ];

        return $this->client->post('users-by-id/' . $userId . '/events/', $options);
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function details($id = null)
    {
        $endpoint = $id ? $this->endPoint . (int)$id : $this->endPoint;

        return $this->client->get($endpoint);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->details($id);
    }
}