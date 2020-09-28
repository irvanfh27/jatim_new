<?php

namespace App\Model\PO;

use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';

    protected $table = 'uom';
    protected $primaryKey = 'uom_id';
    protected $fillable = ['uuid', 'uom_type', 'created_by', 'updated_by'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
