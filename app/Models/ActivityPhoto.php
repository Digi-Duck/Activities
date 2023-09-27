<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityPhoto
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $activity_id
 * @property string $activity_img_path
 *
 * @property ActivityDetail $activityDetail
 *
 * @package App\Models
 */
class ActivityPhoto extends Model
{
    protected $table = 'activity_photos';
    public static $snakeAttributes = false;

    protected $casts = [
        'activity_id' => 'int'
    ];

    protected $fillable = [
        'activity_id',
        'activity_img_path'
    ];

    public function activityDetail()
    {
        return $this->belongsTo(ActivityDetail::class, 'activity_id');
    }
}
