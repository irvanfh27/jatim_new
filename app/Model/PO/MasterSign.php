<?php

namespace App\Model\PO;

use Illuminate\Database\Eloquent\Model;

class MasterSign extends Model
{
    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';

    protected $table = 'master_sign';
    protected $primaryKey = 'idmaster_sign';
    protected $fillable = ['uuid', 'name', 'jabatan', 'created_by', 'updated_by'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
