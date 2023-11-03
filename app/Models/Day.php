<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Day extends Model
{
    use HasFactory;

    protected $table = 'date';
    protected $primaryKey = 'id';

    protected $fillable = [
        'uuid',
        'day',
        'short_name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at',
    ];

    public function officeHour()
    {
        return $this->hasOne(OfficeHour::class, 'day_uuid', 'uuid');
    }

    public function timeSchedules()
    {
        return $this->hasMany(TimeSchedule::class, 'uuid', 'day_uuid');
    }


    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = (string) Str::orderedUuid();
            $model->created_by = auth()->user()->id;
        });

        self::updating(function ($model) {
            $model->updated_by = auth()->user()->id;
        });

        self::deleting(function ($model) {
            $model->deleted_by = auth()->user()->id;
        });
    }
}
