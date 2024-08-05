<?php

namespace jeremykenedy\Slack\Laravel\Fakes;

use jeremykenedy\Slack\Client;
use jeremykenedy\Slack\Message;
use PHPUnit\Framework\Assert;

class SlackFake extends Client
{
    public $messages;

    public function __construct($endpoint, $attributes = [], $guzzle = null)
    {
        $this->messages = collect();
    }

    public function assertTrue($callback)
    {
        Assert::assertTrue($callback());
    }

    public function sendMessage(Message $message)
    {
        $this->messages->push($message);
    }

    public function assertMessageSent($callback = null)
    {
        Assert::assertTrue($this->messages->count() > 0);

        if ($callback) {
            Assert::assertTrue($callback($this->messages, null));
        }
    }

    public function assertMessageSentTo($channel, $callback = null)
    {
        Assert::assertTrue($this->messages->count() > 0);

        if ($callback) {
            Assert::assertTrue($callback($this->messages->filter(function ($m) use ($channel) {
                return $m->getChannel() == $channel;
            }), null));
        }
    }
}
