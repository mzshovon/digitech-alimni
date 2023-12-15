<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    public function getElections($userId = null, array|null $values = null, $from = null, $to = null, $status = null, $order = "DESC")
    {
        $data = $this->orderBy("updated_at", $order);
        $data->when($status, function($q) use ($status){
            $q->whereStatus($status);
        })->when($from, function($q) use ($from, $to){
            $q->whereBetween("start_date", [$from, $to]);
        })->when($values, function($q) use ($values){
            $q->get($values);
        });
        return $data->get()->toArray();
    }
}
