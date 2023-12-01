<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResource extends ResourceCollection
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
        foreach ($request as $user) {
            $data = [
                "name" => $user['name'],
                "membership_id" => $user['members']['membership_id'] ?? "N/A",
                "email" => $user['email'],
                "contact" => $user['contact'],
                "payment" => $user['members']['payment'],
                "batch" => $user['members']['batch'],
                "blood_group" => $user['members']['blood_group'],
                "registered_at" => Carbon::parse($user['created_at'])->format('d, M Y'),
            ];
        }
        return $data;
    }
}
