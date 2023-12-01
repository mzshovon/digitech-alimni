<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) : array
    {
        $data = [];
        foreach ($request as $payment) {
            $data = [
                "name" => $payment['user']['name'],
                "email" => $payment['user']['email'],
                "contact" => $payment['user']['contact'],
                "payment_channel" => $payment['payment_channel'],
                "trans_id" => $payment['trans_id'],
                "amount" => $payment['amount'],
                "status" => ucfirst($payment['status']),
                "submitted_at" => Carbon::parse($payment['created_at'])->format('d, M Y'),
            ];
        }
        return $data;
    }
}
