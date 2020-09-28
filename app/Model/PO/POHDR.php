<?php

namespace App\PO;

use App\Model\Configuration\GeneralVendor;
use App\Model\Configuration\GeneralVendorBank;
use App\Model\Configuration\Stockpile;
use App\Model\PO\MasterSign;
use App\Model\PO\PODetail;
use App\User;
use Illuminate\Database\Eloquent\Model;

class POHDR extends Model
{
    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';

    protected $table = 'po_hdr';
    protected $primaryKey = 'idpo_hdr';
    protected $appends = ['stockpile_name', 'general_vendor_name', 'status_po'];
    protected $fillable = [
        'no_po', 'general_vendor_id', 'no_penawaran', 'tanggal', 'memo', 'currency_id', 'exchangerate',
        'stockpile_id', 'sign_id', 'toc', 'totalppn', 'totalpph', 'totalall', 'entry_by', 'gv_bank_id', 'uuid', 'grandtotal', 'approved_date', 'gv_bank_id'
    ];


    public function stockpile()
    {
        return $this->belongsTo(Stockpile::class, 'stockpile_id', 'stockpile_id');
    }

    public function generalVendor()
    {
        return $this->belongsTo(GeneralVendor::class, 'general_vendor_id', 'general_vendor_id');
    }

    public function sign()
    {
        return $this->belongsTo(MasterSign::class, 'sign_id', 'idmaster_sign');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'entry_by', 'id');
    }

    public function po_detail()
    {
        return $this->hasMany(PODetail::class, 'no_po', 'no_po');
    }

    public function gv_bank()
    {
        return $this->belongsTo(GeneralVendorBank::class, 'gv_bank_id', 'gv_bank_id');
    }

    public function getStockpileNameAttribute()
    {
        return isset($this->stockpile->name) ? $this->stockpile->name : NULL;
    }

    public function getGeneralVendorNameAttribute()
    {
        return isset($this->generalVendor->general_vendor_name) ? $this->generalVendor->general_vendor_name : NULL;
    }

    public function getStatusPoAttribute()
    {
        if ($this->status == 0) {
            $status = 'On Process';
        } elseif ($this->status == 1) {
            $status = 'Approve';

        } elseif ($this->status == 2) {
            $status = 'Receive';

        } elseif ($this->status == 3) {
            $status = 'Reject';

        } elseif ($this->status == 4) {
            $status = 'Cancel';
        } elseif ($this->status == 5) {
            $status = 'Complete';
        }
        return $status;
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
