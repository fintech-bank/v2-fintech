<?php

namespace App\Services;


use Http;

class SlackNotifier
{
    private $hook;
    /**
     * @var null
     */
    private $channel;
    private Http $client;

    /**
     * @param $hook
     * @param $channel
     */
    public function __construct($hook, $channel = null)
    {
        $this->hook = $hook;
        $this->channel = $channel;
        $this->client = new Http();
    }

    public function send($text, $attachments = [], $hook = null, $channel = null)
    {
        $hook = $this->getHook($hook);
        $channel = $this->getChannel($channel);
        $payload = $this->preparePayload($text, $attachments, $channel);

        $this->client->post($hook, ['json' => $payload]);
    }

    private function getHook(mixed $hook)
    {
        return (is_null($hook)) ? $this->hook : $hook;
    }

    private function getChannel(mixed $channel)
    {
        return (is_null($channel)) ? $this->channel : $channel;
    }

    private function preparePayload($text, mixed $attachments, mixed $channel): array
    {
        return ['text' => $text, 'attachments' => [$attachments], 'channel' => $channel];
    }
}
