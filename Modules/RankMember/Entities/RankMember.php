<?php

namespace Modules\RankMember\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RankMember extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'rank',
        'min_points',
    ];
    public function scopeSearch(Builder $query, $search)
    {
        return $query->where('rank', 'like', '%' . $search . '%');
    }

    public function scopeSort(Builder $query, $sort, $direction)
    {
        if (!$sort) {
            $sort = 'min_points';
        }
        return $query->orderBy($sort, $direction);
    }
    protected static function newFactory()
    {
        // return \Modules\RankMember\Database\factories\RankMemberFactory::new();
    }
}
