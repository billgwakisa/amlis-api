<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Merchants extends Model
{
    //
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'lat', 'long', 'phone', 'user_id'
    ];

    /**
     * Return associated user
     */
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Return linked transactions
     */
    public function transactions() {
        return $this->hasMany('App\Models\Transactions', 'merchant_id');
    }
}
