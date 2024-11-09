<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{

    protected $fillable = [
        'transaction_identifier', 'amount', 'lat', 'long', 'start_time', 'end_time', 'status', 'type', 'origin_name', 'dest_name', 'description', 'is_fraud', 'is_flagged_fraud'
    ];

    //
    /**
     * Return associated user
     */
    // public function userAccount() {
    //     return $this->belongsTo('App\Models\UserAccount');
    // }


    // /**
    //  * Return associated user
    //  */
    // public function merchant() {
    //     return $this->belongsTo('App\Models\Merchants');
    // }
}
