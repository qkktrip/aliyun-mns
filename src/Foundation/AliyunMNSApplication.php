<?php

namespace AliyunMNS\Foundation;


use Pimple\Container;

/**
 * Class AliyunApp
 *
 * @package AliyunMNS\Foundation
 */
class AliyunMNSApplication extends Container
{

    /**
     * @var array
     */
    protected $providers = [
        ServiceProviders\SmsServiceProvider::class
    ];

    /**
     * AliyunApp constructor.
     *
     * @param array $config
     */
    public function __construct($config)
    {
        $this['config'] = function() use ($config){
            return new Config($config);
        };
        $this->registerProvidres();
    }

    /**
     * Register providers
     */
    private function registerProvidres()
    {
        foreach ($this->providers as $provider) {
            $this->register(new $provider());
        }
    }

    /*
     * Register base providers
     */
    private function registerBase()
    {
    }

    /**
     * Magic get access.
     *
     * @param $id
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param $id
     * @param $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

}