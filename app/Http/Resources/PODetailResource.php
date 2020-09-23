<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PODetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->idpo_detail,
            'uuid' => $this->uuid,
            'shipment_no' => isset($this->shipment->shipment_no) ? $this->shipment->shipment_no : NULL,
            'qty' => $this->qty,
            'harga' => number_format($this->harga, 2, ".", ","),
            'keterangan' => $this->keterangan,
            'item_name' => isset($this->item->item_name) ? $this->item->item_name : NULL,
            'stockpile' => isset($this->stockpile->name) ? $this->stockpile->name : NULL,
            'ppn' => number_format($this->ppn, 2, ".", ","),
            'pph' => number_format($this->pph, 2, ".", ","),
            'amount' => number_format($this->amount, 2, ".", ","),
            'grandtotal' => number_format($this->amount + ($this->ppn - $this->pph), 2, ".", ","),
            'qty_confirm' => $this->qty_confirm,
            'receive_date' => $this->receive_date,
            'receiver' => $this->receiver,
            'uom_type' => isset($this->uom) ? $this->uom->uom_type : NULL,
        ];
    }
}
