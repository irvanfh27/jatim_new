<?php

namespace App\Model\PO;

use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    protected $table = 'uom';
    protected $primaryKey = 'uom_id';
    protected $fillable = ['uuid', 'uom_type', 'created_by', 'updated_by'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
