<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class TelegramUser
 * @package App\Models
 * @version January 17, 2019, 5:09 pm UTC
 *
 * @property string phone
 * @property string photo
 * @property string comment
 * @property string name
 */
class TelegramUser extends Model
{

    public $table = 'telegram_users';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';



    public $fillable = [
        'id',
        'name',
        'phone',
        'photo',
        'comment',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'phone' => 'string',
        'photo' => 'blob',
        'comment' => 'string',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
