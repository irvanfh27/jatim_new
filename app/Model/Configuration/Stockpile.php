<?php

namespace App\Model\Configuration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stockpile extends Model
{
    use SoftDeletes;

    protected $appends = ['status'];
    protected $fillable = ['uuid', 'code', 'name', 'address', 'active', 'created_by', 'updated_by'];

    public function getStatusAttribute()
    {
        if ($this->active == 1) {
            $status = 'Active';
        } else {
            $status = 'Inactive';
        }
        return $status;
    }


    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
