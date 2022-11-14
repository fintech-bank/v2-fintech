<?php

namespace App\Services;


use App\Helper\LogHelper;
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
     * @param null $channel
     */
    public function __construct($channel = null)
    {
        $this->hook = config('services.slack.hook');
        $this->channel = $channel;
        $this->client = new Http();
    }

    public function send($text, $attachments = [], $hook = null, $channel = null)
    {
        $hook = $this->getHook($hook);
        $channel = $this->getChannel($channel);
        $payload = $this->preparePayload($text, $attachments, $channel);

        try {
            Http::post($hook, $payload);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
        }
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
        return ['text' => $text, 'blocks' => $attachments, 'channel' => $channel];
    }
}
