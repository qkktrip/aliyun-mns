<?php

namespace Tests;

use AliyunMNS\Foundation\AliyunMNSApplication;
use PHPUnit\Framework\TestCase;

class TestSms extends TestCase
{

    public function testSMS()
    {
        $config = [
            'access_id' => 'your access id',
            'access_key' => 'your access key',
            'end_point' => 'end point url',

            'sms_template' => [
                'register' => [
                    'topic_name' => 'your topic name',
                    'sign_name' => 'your sign name',
                    'template_code' => 'SMS_68940007'
                ]

            ],
        ];

        $app = new AliyunMNSApplication($config);
        $messageId = $app->sms
            ->template('register')
            ->to('receiver phone numbner')
            ->message(["code" => "code", "product" => "product name"])
            ->send();

        echo $messageId;
    }
}
