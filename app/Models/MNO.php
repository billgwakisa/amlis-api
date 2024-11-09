<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MNO extends Model
{
    //

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'status', 'phone', 'imei', 'm_n_o_id'
    ];


    /**
     * Return linked accounts
     */
    public function userAccounts() {
        return $this->hasMany('App\Models\UserAccount');
    }
}
