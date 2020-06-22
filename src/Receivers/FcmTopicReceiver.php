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
    public function __construct(string $topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getTopic(): string
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
