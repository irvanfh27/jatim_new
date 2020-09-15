<?php

namespace App\Model\PO;

use Illuminate\Database\Eloquent\Model;

class PODetail extends Model
{
    const CREATED_AT = 'entry_date';
    protected $table = 'po_detail';
    protected $primaryKey = 'idpo_detail';
    protected $fillable = [
        'no_po', 'qty', 'harga', 'keterangan', 'amount', 'ppn', 'pph',
        'pph_id', 'ppn_id', 'entry_by', 'stockpile_id','pphstatus','ppnstatus',
        'item_id','shipment_id'
    ];

}
