<?php
/**
 * Created by PhpStorm.
 * User: object
 * Date: 17.01.19
 * Time: 22:15
 */

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;



class StartCommand extends Command
{

    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => 'Привет, добро пожаловать! Я справлюсь с тестовым заданием 🙂']);

        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // Reply with the commands list
        $this->replyWithMessage(['text' => "Давай познакомимся, как тебя зовут?"]);
    }

}