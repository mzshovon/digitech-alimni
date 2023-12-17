<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status',
        'start_date',
        'end_date',
        'created_by',
        'updated_by',
    ];

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

    public static function createNewElectionRequest(array $data)
    {
        return self::create($data);
    }
}
