<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = "contact_us";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject',
        'message',
        'ip',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createNewContactRequest(array $data)
    {
        return self::create($data);
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
    public function getContacts($userId = null, array|null $values = null, $from = null, $to = null, $order = "DESC")
    {
        $data = $this->with("user")->orderBy("updated_at", $order);

        $data->when($userId, function($q) use ($userId){
            $q->whereUserId($userId);
        })->when($from, function($q) use ($from, $to){
            $q->whereBetween("updated_at", [$from, $to]);
        })->when($values, function($q) use ($values){
            $q->get($values);
        });

        return $data->get()->toArray();
    }
}
