<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use Uuids;

    const UPDATED_AT = null;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedule';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
    ];

    public function dates()
    {
        return $this->hasMany(ScheduleDates::class);
    }
}