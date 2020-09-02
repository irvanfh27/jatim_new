<?php

namespace App\Model\Configuration;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stockpile extends Model
{
    use SoftDeletes, SearchTrait;

    protected $primaryKey = 'stockpile_id';

    protected $appends = ['status'];

    protected $fillable = ['uuid', 'code', 'name', 'address', 'active', 'created_by', 'updated_by'];

    protected $searchable = [
        'code' => [
            'search_relation' => false,
        ],
        'name' => [
            'search_relation' => false,
        ],
    ];

    public function getStatusAttribute()
    {
        if ($this->active == 1) {
            $status = 'Active';
        } else {
            $status = 'Inactive';
        }
        return $status;
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
