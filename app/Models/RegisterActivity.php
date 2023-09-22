<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RegisterActivity
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $activity_id
 * @property int $student_id
 * @property string $student_name
 * @property string $student_phone_number
 * @property string $student_email
 * @property string $student_additional_remark
 * @property int $registration_status
 * 
 * @property ActivityDetail $activityDetail
 * @property UserRoleStudent $userRoleStudent
 *
 * @package App\Models
 */
class RegisterActivity extends Model
{
    protected $table = 'register_activities';
    public static $snakeAttributes = false;

    protected $casts = [
        'activity_id' => 'int',
        'student_id' => 'int',
        'registration_status' => 'int'
    ];

    protected $fillable = [
        'activity_id',
        'student_id',
        'student_name',
        'student_phone_number',
        'student_email',
        'student_additional_remark',
        'registration_status'
    ];

    public function activityDetail()
    {
        return $this->belongsTo(ActivityDetail::class, 'activity_id');
    }

    public function userRoleStudent()
    {
        return $this->belongsTo(UserRoleStudent::class, 'student_id');
    }

    public function userBehavior()
    {
        return $this->hasMany(UserBehavior::class, 'type_id');
    }
}
