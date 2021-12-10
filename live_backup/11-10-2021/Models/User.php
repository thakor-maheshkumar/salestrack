<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class User extends SentinelUser implements Authenticatable
{
    use Notifiable, AuthenticableTrait, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * set primary key of table
     *
     * @var integer
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'suffix',
        'parent_unit',
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'date_of_birth',
        'landline_no',
        'mobile_no',
        'email',
        'password',
        'address',
        'address_1',
        'landmark',
        'city',
        'state',
        'country_id',
        'pincode',
        'user_type',
        'is_manager',
        'dept_id',
        'pan_no',
        'pan_photo',
        'aadhar_no',
        'aadhar_photo',
        'photo',
        'id_card',
        'bank_name',
        'bank_acc_no',
        'bank_ifsc',
        'bank_document',
        'valid_till',
        'pf_no',
        'employee_code',
        'permissions',
        'last_login',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'json',
    ];

    /**
     * set logins field
     *
     * @var string
     */
    protected $loginNames = ['email'];


    /**
     * Define the relation between country and user.
     */
    public function country()
    {
        return $this->belongsTo('\App\Models\Country', 'country_id', 'id');
    }

    public function userPermission()
    {
        return $this->hasMany('\App\Models\UserPermission', 'user_id', 'id');
    }

    public function hasExpiry($model)
    {
        // $isScreen = $this->userPermission()->whereHas('screen', function($q) use($model) {
        //     $q->where('create', 'like', '%'.$model.'%');
        //     $q->orWhere('edit', 'like', '%'.$model.'%');
        //     $q->orWhere('view', 'like', '%'.$model.'%');
        //     $q->orWhere('other', 'like', '%'.$model.'%');
        // })->first();

        $record = $this->userPermission()->orderByDesc('expiry_date')->first();
        // pred($record->toArray());
        if (isset($record) && !empty($record->expiry_date))
        {
            if ((\Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($record->start_date))) || (\Carbon\Carbon::now()->gte(\Carbon\Carbon::parse($record->expiry_date))))
            {
                return false;
            }
        }
        
        return true;
    }

    /**
     * The department that belong to the user.
     */
    public function departments()
    {
        return $this->belongsToMany('\App\Models\Department', 'user_department', 'user_id', 'department_id')->withTimestamps()->withPivot('start_date', 'end_date', 'is_manager');
    }
    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth']= Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function getDateOfBirthAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d/m/Y');
    }
}
