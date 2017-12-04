<?php


namespace AliyunMNS\Work\Sms;


use AliyunMNS\Core\AbstractAPI;
use AliyunMNS\Core\Exceptions\RuntimeException;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Requests\PublishMessageRequest;

class Sms extends AbstractAPI
{
    protected $template;

    protected $to;

    protected $message;

    /**
     * Set SMS template used for SMS
     *
     * @param $template
     * @return $this
     * @throws RuntimeException
     */
    public function template($template)
    {
        $smsTemplate = $this->getConfig()['sms_template.' . $template];

        if (empty($smsTemplate)) {
            throw new RuntimeException('SMS template not found.');
        }

        $this->template = $smsTemplate;

        return $this;
    }

    /**
     * Set receiving message person's mobile phone number
     *
     * @param $to
     * @return $this
     * @throws RuntimeException
     */
    public function to($to)
    {
        if (!preg_match("/^1[34578]{1}\d{9}$/", $to)) {
            throw new RuntimeException('Illegal mobile phone number');
        }

        $this->to = $to;

        return $this;
    }

    /**
     * Set the value of the parameters in the SMS template
     *
     * @param array $message
     * @return $this
     */
    public function message(array $message)
    {
        $this->message = $message;
        return $this;
    }


    /**
     * Send SMS message
     *
     * @return string SMS message id
     * @throws RuntimeException
     */
    public function send()
    {
        if (empty($this->template)) {
            throw new RuntimeException('No SMS templates are set up.');
        }

        if (empty($this->to)){
            throw new RuntimeException('No receiver are set up.');
        }

        // Get topic instance
        $topic = $this->getClient()->getTopicRef($this->template['topic_name']);

        // Set sign name and template code for SMS
        $batchSmsAttributes = new BatchSmsAttributes($this->template['sign_name'], $this->template['template_code']);

        // Set the value of the parameters in the SMS template
        $batchSmsAttributes->addReceiver($this->to, $this->message);
        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));

        // SMS body must be set up
        // Tips:The message content is not available for the time being, And the message content should be specified, not empty.
        $messageBody = "sms";

        // Publish SMS messages
        $request = new PublishMessageRequest($messageBody, $messageAttributes);

        try {
            $res = $topic->publishMessage($request);

            if (!$res->isSucceed()){
                throw new RuntimeException('Publish SMS messages failed.');
            }

            return $res->getMessageId();

        } catch (MnsException $e) {
            echo $e;
        }
    }
}