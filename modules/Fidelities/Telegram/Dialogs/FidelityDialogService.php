<?php

namespace Fidelities\Telegram\Dialogs;

use Carbon\Carbon;
use Fidelities\Models\Fidelity;
use Telegram\Bot\Objects\User as UserTelegram;
use Users\Models\User;

class FidelityDialogService
{
    public function create(string $startAt, string $amount, UserTelegram $userTelegram)
    {
        $user = (new User())->findByThirdPartyId($userTelegram->getId());

        $data = [
          'label'     => 'Pague 15 e Ganhe Uma',
          'startAt'   => $startAt,
          'amount'    => $amount,
          'remainder' => $amount,
          'user_id'   => $user->id
        ];

        $fidelity = (new Fidelity())->firstOrCreate($data);

        return $fidelity ? 'Fidelidade Cadastrada com sucesso' : 'Ocorreu um erro ao salvar a fidelidade';
    }

    public function available(UserTelegram $userTelegram)
    {
        $user = (new User())->findByThirdPartyId($userTelegram->getId());

        if(empty($user)) {
            return "Usuário não encontrado.\nEntre com /user para se cadastrar";
        }

        if($user->fidelities->isEmpty()) {
            return 'Você não possui nenhuma fidadelidade cadastrada.';
        }

        $fidelity = $user->fidelities->first();

        $message = "Fidelidades Ativas:\n";

        //foreach ($user->fidelities as $fidelity ) {
            $message .= "\n- Plano: " . $fidelity->label;
            $message .= "\n- Início: " . Carbon::parse($fidelity->startAt)->toDateString();
            $message .= "\n- Quantidade: " . $fidelity->amount;
            $message .= "\n- Restantes: " . $fidelity->remainder;
            $message .= "\n";
        //}

        return $message;
    }

    public function checkout(UserTelegram $userTelegram)
    {
        $user     = (new User())->findByThirdPartyId($userTelegram->getId());
        $fidelity = $user->fidelities->first();

        $fidelity->remainder -= 1;
        $fidelity->save();

        if($fidelity->remainder == 0) {
            $fidelity->delete();
            return true;
        }

        return false;
    }
}
