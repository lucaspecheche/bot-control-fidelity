<?php

namespace Users\Telegram\Dialogs;

use App\Models\Chat;
use Telegram\Bot\Objects\Update;
use Users\Models\User;

class UserDialogService
{
    public function createAndChat(Update $update)
    {
        $from = $update->getMessage()->getFrom();
        $chat = $update->getMessage()->getChat();

        $dataUser = [
            'id_third_party' => $from->getId(),
            'first_name'     => $from->getFirstName(),
            'last_name'      => $from->getLastName()
        ];

        $user = (new User())->findOrNew($dataUser);

        $dataChat = [
            'chat' => $chat->getId(),
            'type' =>    $chat->getType(),
            'user_id' => $user->id
        ];

        $chat = (new Chat())->create($dataChat);

        return ($user and $chat) ? 'Criado Com sucesso' : 'Ocorreu um erro ao concluir o processo';
    }
}
