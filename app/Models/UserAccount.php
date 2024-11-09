<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'status', 'phone', 'imei', 'm_n_o_id', 'otp', 'user_id', 'fingerprint'
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'otp'
    ];


    /**
     * Return associated user
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Return associated mno
     */
    public function mno() {
        return $this->belongsTo('App\Models\MNO', 'm_n_o_id');
    }

    /**
     * Return linked accounts
     */
    public function linkedAccounts() {
        return $this->hasMany('App\Models\LinkedAccounts');
    }


    /**
     * Return linked transactions
     */
    public function transactions() {
        return $this->hasMany('App\Models\Transactions');
    }
}
