<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserBehavior
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $type_id
 * @property string $behavior
 *
 * @package App\Models
 */
class UserBehavior extends Model
{
    protected $table = 'user_behaviors';
    public static $snakeAttributes = false;

    protected $casts = [
        'type_id' => 'int'
    ];

    protected $fillable = [
        'type_id',
        'behavior'
    ];
}
