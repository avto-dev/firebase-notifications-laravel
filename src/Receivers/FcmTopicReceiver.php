<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Receivers;

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
    public function getTarget(): array
    {
        return ['topic' => $this->getTopic()];
    }
}
