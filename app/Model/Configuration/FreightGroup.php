<?php

namespace App\Model\Configuration;

use Illuminate\Database\Eloquent\Model;

class FreightGroup extends Model
{
    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';

    protected $table = 'freight_group';
    protected $primaryKey = 'freight_group_id';

    protected $fillable = ['group_name'];


}
