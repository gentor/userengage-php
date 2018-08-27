<?php

namespace Gentor\Userengage;

/**
 * Class UserengageCompanies
 * @package Gentor\Userengage
 */
class UserengageCompanies
{
    /** @var UserengageClient $client */
    private $client;

    /**
     * @var string
     */
    protected $endPoint = 'companies/';

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
        return $this->client->put('companies-by-id/' . $id . '/', $options);
    }

    /**
     * @param $companyId
     * @param array $attributes
     * @return mixed
     */
    public function setAttributes($companyId, array $attributes)
    {
        return $this->client->post('companies-by-id/' . $companyId . '/set_multiple_attributes/', $attributes);
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
     * @param $id
     * @return mixed
     */
    public function deleteByCustomId($id)
    {
        return $this->client->delete('companies-by-id/' . $id . '/');
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
        return $this->client->get('companies-by-id/' . $id);
    }
}