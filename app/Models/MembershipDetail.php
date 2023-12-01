<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipDetail extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'membership_id',
        'nid',
        'dob',
        'batch',
        'address',
        'blood_group',
        'employeer_name',
        'designation',
        'employeer_address',
        'reference',
        'reference_number',
        'user_id',
        'payment',
        'image_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createNewMember(array $data)
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
    public function getMemberList($limit = null, array|null $values = null, $from = null, $to = null, $order = "DESC")
    {
        $data = $this->with("user")->orderBy("updated_at", $order);

        $data->when($values, function($q) use ($values){
            $q->get($values);
        })->when($from, function($q) use ($from, $to){
            $q->whereBetween("updated_at", [$from, $to]);
        })->when($limit, function($q) use ($limit){
            $q->take($limit);
        });

        return $data->get()->toArray();
    }

    /**
     * @param string $whereParam
     * @param mixed $value
     *
     * @return
     */
    public static function getSingleMemberByParam(string $whereParam, $value)
    {
        return self::where($whereParam, $value)->first();
    }

     /**
     * @param string $whereParam
     * @param int|string $value
     * @param array|null $updatedInfo
     *
     * @return mixed
     */
    public static function updateMemberByParam(string $whereParam, int|string $value, array|null $updatedInfo)
    {
        return self::where($whereParam, $value)->update($updatedInfo);
    }

    /**
     * @param string $whereParam
     * @param int|string $value
     *
     * @return
     */
    public static function deleteMemberByParam(string $whereParam, int|string $value)
    {
        return self::where($whereParam, $value)->delete();
    }
}
