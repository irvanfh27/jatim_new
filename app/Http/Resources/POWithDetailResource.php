<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class POWithDetailResource extends JsonResource
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
            'id' => isset($this->idpo_hdr) ? $this->idpo_hdr : NULL,
            'uuid' => $this->uuid,
            'no_po' => $this->no_po,
            'general_vendor_id' => $this->general_vendor_id,
            'no_penawaran' => $this->no_penawaran,
            'tanggal' => $this->tanggal,
            'memo' => $this->memo,
            'currency_id' => $this->currency_id,
            'exchangerate' => $this->exchangerate,
            'stockpile_id' => $this->stockpile_id,
            'status' => $this->status,
            'sign_id' => $this->sign_id,
            'toc' => $this->toc,
            'grandtotal' => number_format($this->grandtotal, 2, ".", ","),
            'totalppn' => number_format($this->totalppn, 2, ".", ","),
            'totalpph' => number_format($this->totalpph, 2, ".", ","),
            'totalall' => number_format($this->totalall, 2, ".", ","),
            'entry_date' => $this->entry_date,
            'updated_at' => $this->updated_at,
            'entry_by' => $this->entry_by,
            'stockpile_name' => $this->stockpile_name,
            'general_vendor_name' => $this->general_vendor_name,
            'status_po' => $this->status_po,
            'po_details' => PODetailResource::collection($this->po_detail)
        ];
    }
}
