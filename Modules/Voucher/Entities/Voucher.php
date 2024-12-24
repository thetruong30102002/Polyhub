<?php

namespace Modules\Voucher\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Voucher extends Model
{
    use HasFactory;


    protected $table = 'vouchers';
    protected $fillable = [
        'code', 'type', 'amount', 'start_date', 'end_date', 'usage_limit', 'used', 'status', 'created_at',
        'updated_at' 
    ];
    public $timestamps = true;
    protected static function newFactory()
    {
        return \Modules\Voucher\Database\factories\VoucherFactory::new();
    }
}
