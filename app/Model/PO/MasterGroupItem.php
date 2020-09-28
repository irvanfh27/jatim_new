<?php

namespace App\Model\PO;

use App\Model\Configuration\Account;
use Illuminate\Database\Eloquent\Model;

class MasterGroupItem extends Model
{
    const CREATED_AT = 'entry_date';

    protected $table = 'master_groupitem';
    protected $primaryKey = 'idmaster_groupitem';
    protected $fillable = ['uuid', 'group_name', 'account_id', 'created_by', 'updated_by'];

    protected $appends = ['account_no'];

    public function getAccountNoAttribute()
    {
        return $this->account->account_no;
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
