<?php

namespace Telegram\Exceptions;

class TelegramExceptions
{
    public static function exit()
    {
        return new TelegramBuildExceptions(
            'Você saiu!'
        ) ;
    }

    public static function methodUndefined($step)
    {
        return new TelegramBuildExceptions(
            "Erro: Passo ($step) deve ser declarado como função."
        );
    }
}
