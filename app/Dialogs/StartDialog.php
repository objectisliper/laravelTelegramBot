<?php
/**
 * Created by PhpStorm.
 * User: object
 * Date: 18.01.19
 * Time: 20:25
 */

namespace App\Dialogs;


use BotDialogs\Dialog;

class StartDialog extends Dialog
{
    // Array with methods that contains logic of dialog steps.
    // The order in this array defines the sequence of execution.
    protected $steps = ['hello', 'fine', 'bye'];

    public function hello()
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => 'Hello! How are you?'
        ]);
    }

    public function bye()
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => 'Bye!'
        ]);
        $this->jump('hello');
    }

    public function fine()
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => 'I\'m OK :)'
        ]);
    }
}