<?php

namespace Gentor\Userengage;


use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;

/**
 * Class UserengageService
 *
 * @package Gentor\Userengage
 */
class UserengageService
{
    public $client;

    /**
     * UserengageService constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->client = new UserengageClient($config['api_key']);
    }

    /**
     * @param       $method
     * @param array $args
     *
     * @return mixed
     * @throws \Gentor\Intercom\IntercomException
     */
    public function __call($method, array $args)
    {
        $call = explode('_', Str::snake($method), 2);
        $module = Str::plural($call[0]);

        if (!property_exists($this->client, $module)) {
            throw new UserengageException("Userengage module {$module} not found");
        }

        if (!isset($call[1])) {
            throw new UserengageException("Userengage method for module {$module} is not set");
        }

        $method = Str::camel($call[1]);
        if (!method_exists($this->client->{$module}, $method)) {
            throw new UserengageException("Userengage method {$method} for module {$module} not found");
        }

        return call_user_func_array([$this->client->{$module}, $method], $args);
    }

    /**
     * @param array $options
     *
     * @return null
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function getUser(array $options)
    {
        try {
            $user = $this->client->users->getUsers($options);
        } catch (ClientException $e) {
            if ($e->getCode() == 404) {
                $user = null;
            } else {
                throw $e;
            }
        }

        return $user;
    }

    /**
     * @return mixed
     */
    public function getAllUsers()
    {
        return $this->client->users->getUsers([]);
    }

    /**
     * Create / Update User
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createUser(array $data)
    {
        return $this->client->users->create($data);
    }

    /**
     * @param       $id
     *
     * @param array $options
     *
     * @return mixed
     */
    public function deleteUser($id, $options = [])
    {
        return $this->client->users->deleteUser($id, $options);
    }

    /**
     * @param $user_id
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function deleteUserByUserId($user_id)
    {
        try {
            $user = $this->deleteUser(null, ['user_id' => $user_id]);
        } catch (ClientException $e) {
            if ($e->getCode() == 404) {
                $user = null;
            } else {
                throw $e;
            }
        }

        return $user;
    }

}