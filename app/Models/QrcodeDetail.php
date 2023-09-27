<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QrcodeDetail
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $activity_id
 * @property int $student_id
 * @property string $qrcode_number
 * @property string $qrcode_path
 * @property bool $qrcode_status
 *
 * @property ActivityDetail $activityDetail
 * @property UserRoleStudent $userRoleStudent
 *
 * @package App\Models
 */
class QrcodeDetail extends Model
{
    protected $table = 'qrcode_details';
    public static $snakeAttributes = false;

    protected $casts = [
        'activity_id' => 'int',
        'student_id' => 'int',
        'qrcode_status' => 'int'
    ];

    protected $fillable = [
        'activity_id',
        'student_id',
        'qrcode_number',
        'qrcode_path',
        'qrcode_status'
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
