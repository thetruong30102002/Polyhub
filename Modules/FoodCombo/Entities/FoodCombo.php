<?php

namespace Modules\FoodCombo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\TicketFoodCombo\Entities\TicketFoodCombo;

class FoodCombo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'avatar',
        
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where('name', 'like', $term)
            ->orWhere('price', 'like', $term);
    }
    public function scopeOrderByPrice($query, $sortDirection = 'desc')
    {
        $sortDirection = strtolower($sortDirection);
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
        return $query->orderBy('price', $sortDirection);
    }

    public function ticketFoodCombo()
    {
        return $this->belongsTo(TicketFoodCombo::class);
    }
    

    protected static function newFactory()
    {
        return \Modules\FoodCombo\Database\factories\FoodComboFactory::new();
    }
}
