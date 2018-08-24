<?php

namespace Gentor\Userengage;

/**
 * Class UserengageUsers
 * @package Gentor\Userengage
 */
class UserengageUsers
{
    /** @var UserengageClient $client */
    private $client;

    /**
     * @var string
     */
    protected $endPoint = 'users/';

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
    public function create(array $options)
    {
        return $this->client->post($this->endPoint, $options);
    }

    /**
     * @param $id
     * @param array $options
     * @return mixed
     */
    public function update($id, array $options)
    {
        return $this->client->put($this->endPoint . (int)$id . '/', $options);
    }

    /**
     * @param $id
     * @param array $options
     * @return mixed
     */
    public function updateByCustomId($id, array $options)
    {
        return $this->client->put('users-by-id/' . $id . '/', $options);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->client->delete($this->endPoint . (int)$id . '/');
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

    /**
     * @param $id
     * @return mixed
     */
    public function findByCustomId($id)
    {
        return $this->client->get('users-by-id/search/', ['user_id' => $id]);
    }

    /**
     * @param $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        $endpoint = $this->endPoint . 'search';

        return $this->client->get($endpoint, ['email' => $email]);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function findByKey($key)
    {
        $endpoint = $this->endPoint . 'search';

        return $this->client->get($endpoint, ['key' => $key]);
    }

    /**
     * @param int $minTimestamp
     * @param int $maxTimestamp
     * @param string $type first_seen|last_seen|last_contacted
     * @return mixed
     */
    public function findByDate($minTimestamp, $maxTimestamp = null, $type = 'first_seen')
    {
        if (!$maxTimestamp) {
            $maxTimestamp = time();
        }

        return $this->client->get($this->endPoint, [
            'search' => $type,
            'min' => $minTimestamp,
            'max' => $maxTimestamp,
        ]);
    }
}