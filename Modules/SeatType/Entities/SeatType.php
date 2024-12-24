<?php

namespace Modules\SeatType\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeatType extends Model
{
    use HasFactory;

    protected $table = 'seat_types';
    protected $fillable = ['name', 'price','created_at','updated_at'];
    public $timestamp = true;
}
