<?php

namespace App\Repositories;

use App\Models\TelegramUser;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TelegramUserRepository
 * @package App\Repositories
 * @version January 17, 2019, 5:09 pm UTC
 *
 * @method TelegramUser findWithoutFail($id, $columns = ['*'])
 * @method TelegramUser find($id, $columns = ['*'])
 * @method TelegramUser first($columns = ['*'])
*/
class TelegramUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'phone',
        'photo',
        'comment',
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TelegramUser::class;
    }
}
