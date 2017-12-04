<?php

namespace AliyunMNS\Foundation\ServiceProviders;

use AliyunMNS\Work\Sms\Sms;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class SmsServiceProvider  implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['sms'] = function ($pimple) {
            return new Sms($pimple['config']);
        };
    }
}