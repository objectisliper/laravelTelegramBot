<?php
/**
 * Created by PhpStorm.
 * User: object
 * Date: 18.01.19
 * Time: 13:43
 */

namespace App\Http\Controllers;


use App\Commands\GetContactCommand;
use App\Commands\savePhotoCommand;
use App\Commands\SetCategoriesCommand;
use App\Models\TelegramUser;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController
{

    public function webhook()
    {
        $telegram = Telegram::getWebhookUpdates()['message'];
        $decoded_telegram = json_decode($telegram);

        if (!TelegramUser::find($telegram['from']['id'])) {

            TelegramUser::create(["id" => $telegram['from']['id'], "name" => $telegram['from']['first_name']], true);

        } elseif (isset($telegram['text']) && !$this->isCommand($telegram['text']) &&
                  ($telegram['text'] == '1' || $telegram['text'] == '2' || $telegram['text'] == '3'))
        {

            TelegramUser::where('id', $telegram['from']['id'])->update(['category' => $telegram['text']]);
            (new savePhotoCommand())->handle($decoded_telegram->chat->id);

        } elseif (isset($telegram['text']) && !$this->isCommand($telegram['text']) && ctype_space($telegram['text']) ) {

            TelegramUser::where('id', $telegram['from']['id'])->update(['comment' => $telegram['text']]);

        } elseif (isset($telegram['text']) && !$this->isCommand($telegram['text'])) {

            TelegramUser::where('id', $telegram['from']['id'])->update(['name' => $telegram['text']]);
            (new GetContactCommand)->handle($decoded_telegram->chat->id);

        } elseif (isset($decoded_telegram->contact->phone_number)) {

            TelegramUser::where('id', $telegram['from']['id'])->update(['phone' => $telegram->getContact()->all()['phone_number']]);
            (new SetCategoriesCommand())->handle($decoded_telegram->chat->id);

        } elseif (isset($decoded_telegram->photo)){

            $photo = Telegram::getFile(['file_id' => end($decoded_telegram->photo)->file_id]);
            $client = (new Client());
            $path = public_path().'/images/'.$photo->getFileId().'.jpg';
            $file_path = fopen($path,'w');
            $url = "https://api.telegram.org/file/bot";
            $url .= Telegram::getAccessToken();
            $url .= "/".$photo->getFilePath();
            $client->get($url, ['save_to' => $file_path]);
            TelegramUser::where('id', $telegram['from']['id'])->update(['photo' => 'images/'.$photo->getFileId().'.jpg']);
            Telegram::sendPhoto([
                'chat_id' => $decoded_telegram->chat->id,
                'photo' => storage_path('app').'/photo.jpg',
                'caption' => 'Спасибо, теперь вы можете оставить отзыв. Просто отправьте сообщение, мы будем рады положительному фидбеку 😉'
            ]);
        }

        Telegram::commandsHandler(true);
    }

    private function isCommand(string $message){
        $commands = Telegram::getCommands();
        foreach ($commands as $name => $command){
            if ($name === substr($message,1) && substr($message, 0, 1) === "/"){
                return true;
            }
        }
        return false;
    }

    public function index(){
        return view('change_photo');
    }

    public function savePhoto(Request $request){
        if($request->hasfile('photo'))
        {
            $file = $request->file('photo');
            $filename ='photo.jpg';
            $file->storeAs('',$filename);
        }
        return redirect('admin/auth/telegram_users');
    }
}