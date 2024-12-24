<?php

namespace Modules\Checkin\Entities;

use Modules\Bill\Entities\Bill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'checkin_code',
        'type'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\Checkin\Database\factories\CheckinFactory::new();
    // }
}
