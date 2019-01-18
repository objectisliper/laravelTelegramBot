<?php
/**
 * Created by PhpStorm.
 * User: object
 * Date: 18.01.19
 * Time: 16:50
 */

namespace App\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class savePhotoCommand extends Command
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
    public function handle($arguments)
    {

        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        Telegram::sendMessage([
            'chat_id' => isset($arguments) ? $arguments : $this->update->getMessage()->getChat()->all()['id'],
            'text' => 'Поздравляю, теперь пришли мне фото'
        ]);
    }

}