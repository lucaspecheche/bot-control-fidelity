<?php

namespace Telegram;

use Telegram\Bot\Api;

class Telegram extends Api
{
    public function deleteMessage($chatId, $message_id)
    {
        return $this->post('deleteMessage', [
            'chat_id' => $chatId,
            'message_id' => $message_id
        ])->getDecodedBody();
    }

    public function chatId()
    {
        return $this->getWebhookUpdates()
            ->getMessage()
            ->getChat()
            ->getId();
    }
}