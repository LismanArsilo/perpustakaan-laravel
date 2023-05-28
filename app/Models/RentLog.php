<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rent_log';

    public function status()
    {
        return $this->belongsTo(Status::class,  'id', 'status_id');
    }

    // Mengubah Format Date
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
