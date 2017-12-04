<?php


namespace AliyunMNS\Core;

use \AliyunMNS\Foundation\Config;

abstract class AbstractAPI
{
    protected $client;
    protected $config;

    public function __construct(Config $config)
    {
        $this->setConfig($config);

        $client = new Client(
            $config['end_point'],
            $config['access_id'],
            $config['access_key']
        );
        $this->setClient($client);
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param mixed $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

}