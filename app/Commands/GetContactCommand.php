<?php
/**
 * Created by PhpStorm.
 * User: object
 * Date: 18.01.19
 * Time: 14:39
 */

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class GetContactCommand extends Command
{

    /**
     * @var string Command Name
     */
    protected $name = "getContact";

    /**
     * @var string Command Description
     */
    protected $description = "Give your contacts to bot";

    public function handle($arguments)
    {

        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);


        $keyboard = array(
            array(
                array(
                    'text'=>"Send your visit card",
                    'request_contact'=>true
                )
            )
        );

        $reply_markup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $response = Telegram::sendMessage([
            'chat_id' =>  isset($arguments) ? $arguments : $this->update->getMessage()->getChat()->all()['id'],
            'text' => 'Для начала использования отправь мне свой контакт',
            'reply_markup' => $reply_markup
        ]);
    }


}