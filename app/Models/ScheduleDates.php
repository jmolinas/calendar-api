<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDates extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    const UPDATED_AT = null;

    const CREATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedule_dates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schedule_id',
        'date',
    ];

    public function event()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }
}