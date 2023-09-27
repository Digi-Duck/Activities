<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Statistic
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $website_view
 *
 * @package App\Models
 */
class Statistic extends Model
{
    protected $table = 'statistics';
    public static $snakeAttributes = false;

    protected $casts = [
        'website_view' => 'int'
    ];

    protected $fillable = [
        'website_view'
    ];
}
