<?php

namespace Modules\Voucher\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return[
            "id" => $this-> id,
            "code" => $this-> code,
            "type" => $this-> type,
            "amount" => $this-> amount,
            "start_date" => $this-> start_date,
            "end_date" => $this-> end_date,
            "usage_limit" => $this-> usage_limit,
            "used" => $this-> used,
            "status" => $this-> status,
            "created_at" => $this-> created_at,
            "updated_at" => $this-> updated_at,
         ];
    }
}
