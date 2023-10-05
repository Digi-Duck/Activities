<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRoleStudent
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $user_id
 * @property string $user_name
 * @property string|null $img_path
 * @property string $phone_number
 * 
 * @property User $user
 * @property Collection|QrcodeDetail[] $qrcodeDetails
 * @property Collection|RegisterActivity[] $registerActivities
 * @property Collection|StudentActivity[] $studentActivities
 *
 * @package App\Models
 */
class UserRoleStudent extends Model
{
    protected $table = 'user_role_students';
    public static $snakeAttributes = false;

    protected $casts = [
        'user_id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'user_name',
        'img_path',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function qrcodeDetails()
    {
        return $this->hasMany(QrcodeDetail::class, 'student_id');
    }

    public function registerActivities()
    {
        return $this->hasMany(RegisterActivity::class, 'student_id');
    }

    public function studentActivities()
    {
        return $this->hasMany(StudentActivity::class, 'student_id');
    }
}
