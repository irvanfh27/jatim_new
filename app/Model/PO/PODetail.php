<?php

namespace App\Model\PO;

use App\Model\Configuration\Shipment;
use App\Model\Configuration\Stockpile;
use Illuminate\Database\Eloquent\Model;

class PODetail extends Model
{
    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';

    protected $table = 'po_detail';
    protected $primaryKey = 'idpo_detail';
    protected $fillable = [
        'no_po', 'qty', 'harga', 'keterangan', 'amount', 'ppn', 'pph',
        'pph_id', 'ppn_id', 'entry_by', 'stockpile_id', 'pphstatus', 'ppnstatus',
        'item_id', 'shipment_id', 'uuid', 'uom_id'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'shipment_id');
    }

    public function item()
    {
        return $this->belongsTo(MasterItem::class, 'item_id', 'idmaster_item');
    }

    public function stockpile()
    {
        return $this->belongsTo(Stockpile::class, 'stockpile_id', 'stockpile_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id', 'uom_id');
    }
}
