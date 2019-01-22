<?php

namespace AvtoDev\FirebaseCloudMessaging\Receivers;

class FcmTopicReceiver implements FcmNotificationReceiverInterface
{
    /**
     * @var string
     */
    protected $topic;

    /**
     * FcmTopicReceiver constructor.
     *
     * @param string $topic
     */
    public function __construct($topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget()
    {
        return ['topic' => $this->getTopic()];
    }
}
