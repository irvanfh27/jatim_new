<?php

namespace App\Model\Configuration;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Model;

class GeneralVendor extends Model
{
    use ModelTrait;

    protected $table = 'general_vendor';
    protected $primaryKey = 'general_vendor_id';
}
