<?php

namespace Telegram;

use Illuminate\Redis\RedisManager;
use Telegram\Bot\Objects\Update;

class Dialogs
{
    protected $telegram;
    protected $redis;

    public function __construct(Telegram $telegram, RedisManager $redis)
    {
        $this->telegram = $telegram;
        $this->redis    = $redis;
    }

    public function add(Dialog $dialog)
    {
        $dialog->setTelegram($this->telegram);

        $chatId = $dialog->getChat()->getId();
        $this->setField($chatId, 'next', $dialog->getNext());
        $this->setField($chatId, 'dialog', get_class($dialog));

        return $dialog;
    }

    public function get(Update $update)
    {
        $chatId = $update->getMessage()->getChat()->getId();
        $redis = $this->redis;

        if (!$redis->exists($chatId)) {
            return false;
        }

        $next = $redis->hget($chatId, 'next');
        $name = $redis->hget($chatId, 'dialog');
        $memory = $redis->hget($chatId, 'memory');

        /** @var Dialog $dialog */
        $dialog = new $name($update); // @todo look at the todo above about code safety
        $dialog->setTelegram($this->telegram);
        $dialog->setNext($next);
        $dialog->setMemory($memory);

        return $dialog;
    }

    public function proceed(Update $update)
    {
        $dialog = self::get($update);

        if (!$dialog) {
            return;
        }

        $chatId = $dialog->getChat()->getId();
        $dialog->proceed();

        if ($dialog->isEnd() && $dialog->notLinked()) {
            $this->redis->del($chatId);
        }

        if(! $dialog->isEnd() && $dialog->notLinked()) {
            $this->setField($chatId, 'next', $dialog->getNext());
            $this->setField($chatId, 'memory', $dialog->getMemory());
        }
    }

    public function exists(Update $update)
    {
        if (!$this->redis->exists($update->getMessage()->getChat()->getId())) {
            return false;
        }

        return true;
    }

    protected function setField($key, $field, $value, int $seconds = 300)
    {
        $redis = $this->redis;

        $redis->multi();
        $redis->hset($key, $field, $value);
        $redis->expire($key, $seconds);
        $redis->exec();
    }

    public function schedule(string $chatId, int $step, $class, int $seconds = 18000)
    {
        $this->setField($chatId, 'next', $step, $seconds);
        $this->setField($chatId, 'dialog', $class, $seconds);
    }

    public function jump(Dialog $newDialog)
    {
        $update = $newDialog->getUpdate();
        $chatId = $newDialog->getChat()->getId();

        $this->redis->del($chatId);
        $this->add($newDialog);
        $this->proceed($update);
    }
}
