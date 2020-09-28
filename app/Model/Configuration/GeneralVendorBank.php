<?php

namespace App\Model\Configuration;

use Illuminate\Database\Eloquent\Model;

class GeneralVendorBank extends Model
{
    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';

    protected $table = 'general_vendor_bank';
    protected $primaryKey = 'gv_bank_id';
}
