<?php


namespace Telegram;


class teste
{
    public function __call($name, $arguments)
    {
        dd('__call');
    }

    public function teste()
    {
        dd('teste');
    }
}
