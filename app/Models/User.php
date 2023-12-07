<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'contact',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function members()
    {
        return $this->hasOne(MembershipDetail::class);
    }

    public function getUsersList($limit = null, array|null $values = null, $from = null, $to = null, $payment = null, $blood_group = null, $batch = null, $order = "DESC", $role = null, $inParam = null, $inCompareValue = null)
    {
        $data = $this->with("members","roles")->orderBy("updated_at", $order);
        $data_range = setStartEndDayForFiltering($from, $to);
        $data->when($from, function($q) use ($data_range){
            $q->whereBetween("created_at", $data_range);
        })->when($batch, function($q) use ($batch){
            $q->whereHas('members', function($sq) use ($batch) {
                $sq->whereBatch($batch);
            });
        })->when($blood_group, function($q) use ($blood_group){
            $q->whereHas('members', function($sq) use ($blood_group) {
                $sq->whereBloodGroup($blood_group);
            });
        })->when($payment, function($q) use ($payment){
            $q->whereHas('members', function($sq) use ($payment) {
                $sq->wherePayment($payment);
            });
        })->when($role, function($q) use ($role){
            $q->whereHas('roles', function($sq) use ($role){
                $sq->whereName($role);
            });
        })->when($inParam, function($q) use ($inParam, $inCompareValue){
                $q->whereIn($inParam, $inCompareValue);
        })->when($limit, function($q) use ($limit){
            $q->take($limit);
        });
        return $values ? $data->get($values)->toArray() : $data->get()->toArray();
    }

    public function getUserValueList($values)
    {
        $data = $this->with("members","roles")->whereHas('roles', function($q) {
            $q->whereName("user");
        })->orderBy("updated_at", "DESC");
        return $data->get($values)->toArray();
    }

    /**
     * @param string $whereParam
     * @param mixed $value
     *
     * @return
     */
    public static function getSingleUserByParam(string $whereParam, $value)
    {
        return self::where($whereParam, $value)->first();
    }

    /**
     * @param array $userInfo
     *
     * @return
     */
    public static function createUser(array $userInfo)
    {
        return self::create($userInfo);;
    }

    /**
     * @param string $whereParam
     * @param int|string $value
     * @param array|null $updatedInfo
     *
     * @return mixed
     */
    public static function updateUserByParam(string $whereParam, int|string $value, array|null $updatedInfo)
    {
        return self::where($whereParam, $value)->update($updatedInfo);
    }

    /**
     * @param string $whereParam
     * @param int|string $value
     *
     * @return
     */
    public static function deleteUserByParam(string $whereParam, int|string $value)
    {
        return self::where($whereParam, $value)->delete();
    }

}
