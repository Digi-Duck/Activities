<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRoleAdmin
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * 
 * @property User $user
 *
 * @package App\Models
 */
class UserRoleAdmin extends Model
{
    protected $table = 'user_role_admins';
    public static $snakeAttributes = false;

    protected $casts = [
        'user_id' => 'int'
    ];

    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
