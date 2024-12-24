<?php

namespace Modules\TicketFoodCombo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Bill\Entities\Bill;
use Modules\FoodCombo\Entities\FoodCombo;

class TicketFoodCombo extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_combo_id',
        'bill_id',
        'price',
        'quantity',
    ];
    
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');
    }

    public function food_combo()
    {
        return $this->belongsTo(FoodCombo::class, 'food_combo_id');
    }

    // protected static function newFactory()
    // {
    //     return \Modules\TicketFoodCombo\Database\factories\TicketFoodComboFactory::new();
    // }
}
