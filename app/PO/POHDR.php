<?php

namespace App\PO;

use App\Model\Configuration\GeneralVendor;
use App\Model\Configuration\Stockpile;
use App\Model\PO\MasterSign;
use Illuminate\Database\Eloquent\Model;

class POHDR extends Model
{
    protected $table = 'po_hdr';
    protected $primaryKey = 'idpo_hdr';
    protected $appends = ['stockpile_name', 'general_vendor_name', 'status_po'];
    public const CREATED_AT = 'entry_date';


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
        return $this->belongsTo(MasterSign::class,'sign_id','idmaster_sign');
    }

    public function getStockpileNameAttribute()
    {
        return $this->stockpile->name;
    }

    public function getGeneralVendorNameAttribute()
    {
        return $this->generalVendor->general_vendor_name;
    }

    public function getStatusPoAttribute()
    {
        if ($this->status == 0) {
            $status = 'On Process';
        } elseif ($this->status == 1) {
            $status = 'Invoice';

        } elseif ($this->status == 2) {
            $status = 'Paid';

        } elseif ($this->status == 3) {
            $status = 'Reject';

        } elseif ($this->status == 4) {
            $status = 'Cancel';
        }
        return $status;
    }

}
