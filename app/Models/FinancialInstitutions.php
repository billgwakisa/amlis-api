<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialInstitutions extends Model
{
    //

    /**
     * Return financial institution type
     */
    public function userAccount() {
        return $this->belongsTo('App\Models\FinancialAccountTypes');
    }

    /**
     * Return linked accounts
     */
    public function linkedAccounts() {
        return $this->hasMany('App\Models\LinkedAccounts');
    }
}
