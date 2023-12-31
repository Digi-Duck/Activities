<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentActivity
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $student_id
 * @property int $activity_id
 * @property int $activity_type
 *
 * @property ActivityDetail $activityDetail
 * @property UserRoleStudent $userRoleStudent
 *
 * @package App\Models
 */
class StudentActivity extends Model
{
    protected $table = 'student_activities';
    public static $snakeAttributes = false;

    protected $casts = [
        'student_id' => 'int',
        'activity_id' => 'int',
        'activity_type' => 'int'
    ];

    protected $fillable = [
        'student_id',
        'activity_id',
        'activity_type'
    ];

    public function activityDetail()
    {
        return $this->belongsTo(ActivityDetail::class, 'activity_id');
    }

    public function userRoleStudent()
    {
        return $this->belongsTo(UserRoleStudent::class, 'student_id');
    }
}
