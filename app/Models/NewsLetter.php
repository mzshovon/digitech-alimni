<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_name',
        'status',
        'news',
        'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createNewsLetterRequest(array $data)
    {
        return self::create($data);
    }

    public static function insertNewsLetterRequest(array $data)
    {
        return self::insert($data);
    }

        /**
     * @param null $limit
     * @param array|null|null $values
     * @param null $from
     * @param null $to
     * @param string $order
     *
     * @return [type]
     */
    public function getNewsLetters($userId = null, array|null $values = null, $from = null, $to = null, $status = null, $order = "DESC")
    {
        $data = $this->with("user")->orderBy("updated_at", $order);
        $data_range = setStartEndDayForFiltering($from, $to);
        $data->when($userId, function($q) use ($userId){
            $q->whereUserId($userId);
        })->when($status, function($q) use ($status){
            $q->whereStatus($status);
        })->when($from, function($q) use ($from, $to){
            $q->whereBetween("created_at", [$from." 00:00:00", $to." 23:59:00"]);
        })->when($values, function($q) use ($values){
            $q->get($values);
        });
        // dd($data->get());
        return $data->get()->toArray();
    }


}
