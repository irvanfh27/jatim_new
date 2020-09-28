<?php

namespace App\Model\Configuration;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';

    protected $table = 'account';
    protected $primaryKey = 'account_id';

}
