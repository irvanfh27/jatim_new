<?php

namespace App\Model\PO;

use Illuminate\Database\Eloquent\Model;

class MasterSign extends Model
{
    protected $table = 'master_sign';
    protected $primaryKey = 'idmaster_sign';
    protected $fillable = ['uuid','name','jabatan','created_by','updated_by'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

}
