<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityDetail
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $presenter_id
 * @property string $activity_name
 * @property string $activity_info
 * @property string $activity_presenter
 * @property int $activity_type
 * @property int $activity_lowest_number_of_people
 * @property int $activity_highest_number_of_people
 * @property Carbon $activity_start_registration_time
 * @property Carbon $activity_end_registration_time
 * @property Carbon $activity_start_time
 * @property Carbon $activity_end_time
 * @property string $activity_address
 * @property string $activity_phone_number
 * @property string $activity_email
 * @property string $activity_instruction
 * @property string $activity_information
 * @property int $activity_status
 * 
 * @property UserRolePresenter $userRolePresenter
 * @property Collection|ActivityPhoto[] $activityPhotos
 * @property Collection|QrcodeDetail[] $qrcodeDetails
 * @property Collection|RegisterActivity[] $registerActivities
 *
 * @package App\Models
 */
class ActivityDetail extends Model
{
    protected $table = 'activity_details';
    public static $snakeAttributes = false;

    protected $casts = [
        'presenter_id' => 'int',
        'activity_type' => 'int',
        'activity_lowest_number_of_people' => 'int',
        'activity_highest_number_of_people' => 'int',
        'activity_start_registration_time' => 'datetime',
        'activity_end_registration_time' => 'datetime',
        'activity_start_time' => 'datetime',
        'activity_end_time' => 'datetime',
        'activity_status' => 'int'
    ];

    protected $fillable = [
        'presenter_id',
        'activity_name',
        'activity_info',
        'activity_presenter',
        'activity_type',
        'activity_lowest_number_of_people',
        'activity_highest_number_of_people',
        'activity_start_registration_time',
        'activity_end_registration_time',
        'activity_start_time',
        'activity_end_time',
        'activity_address',
        'activity_phone_number',
        'activity_email',
        'activity_instruction',
        'activity_information',
        'activity_status'
    ];

    public function userRolePresenter()
    {
        return $this->belongsTo(UserRolePresenter::class, 'presenter_id');
    }

    public function activityPhotos()
    {
        return $this->hasMany(ActivityPhoto::class, 'activity_id');
    }

    public function qrcodeDetails()
    {
        return $this->hasMany(QrcodeDetail::class, 'activity_id');
    }

    public function registerActivities()
    {
        return $this->hasMany(RegisterActivity::class, 'activity_id');
    }

    public function userBehavior()
    {
        return $this->hasMany(UserBehavior::class, 'type_id');
    }
}
