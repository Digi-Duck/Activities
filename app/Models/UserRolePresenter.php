<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRolePresenter
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
 * @property Collection|ActivityDetail[] $activityDetails
 * @property Collection|StudentActivity[] $studentActivities
 *
 * @package App\Models
 */
class UserRolePresenter extends Model
{
    protected $table = 'user_role_presenters';
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

    public function activityDetails()
    {
        return $this->hasMany(ActivityDetail::class, 'presenter_id');
    }

    public function studentActivities()
    {
        return $this->hasMany(StudentActivity::class, 'activity_id');
    }
}
