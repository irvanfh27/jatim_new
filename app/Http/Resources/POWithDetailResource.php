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
            'check_by' => $this->sign->name,
            'gv_bank_id' => $this->gv_bank_id,
            'prepare_by' => isset($this->user->name) ? $this->user->name : '',
            'bank_name' => isset($this->gv_bank->bank_name) ? $this->gv_bank->bank_name : '',
            'branch' => isset($this->gv_bank->branch) ? $this->gv_bank->branch : '',
            'account_no' => isset($this->gv_bank->account_no) ? $this->gv_bank->account_no : '',
            'swift_code' => isset($this->gv_bank->swift_code) ? $this->gv_bank->swift_code : '',

            'po_details' => PODetailResource::collection($this->po_detail)
        ];
    }
}
