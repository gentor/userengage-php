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
     * @param $user_id
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\ClientException
     */
    public function deleteUserByUserId($user_id)
    {
        return $this->client->users->deleteByCustomId($id);
    }

}