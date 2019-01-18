<?php
/**
 * Created by PhpStorm.
 * User: object
 * Date: 18.01.19
 * Time: 13:43
 */

namespace App\Http\Controllers;


use App\Models\TelegramUser;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController
{
    public function webhook(){
        $telegram = Telegram::getWebhookUpdates()['message'];

        if (!TelegramUser::find($telegram['from']['id'])){
            TelegramUser::create(["id" => $telegram['from']['id'], "name" => $telegram['from']['first_name']],true);
        }

        Telegram::commandsHandler(true);
    }
}