<?php
/**
 * Created by PhpStorm.
 * User: object
 * Date: 18.01.19
 * Time: 16:39
 */

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetCategoriesCommand extends Command
{

    /**
     * @var string Command Name
     */
    protected $name = "setCategory";

    /**
     * @var string Command Description
     */
    protected $description = "Set your category";

    public function handle($arguments)
    {

        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);


        $keyboard = [['1', '2', '3']];

        $reply_markup = Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        Telegram::sendMessage([
            'chat_id' => isset($arguments) ? $arguments : $this->update->getMessage()->getChat()->all()['id'],
            'text' => 'Отлично! А теперь выбери к какой категории пользователей тебя отнести:',
            'reply_markup' => $reply_markup
        ]);
    }
}