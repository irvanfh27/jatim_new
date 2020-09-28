<?php

namespace App\Model\Configuration;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class GeneralVendor extends Model
{
    use ModelTrait;

    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';

    protected $table = 'general_vendor';
    protected $primaryKey = 'general_vendor_id';
}
