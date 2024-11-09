<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedAccounts extends Model
{
    //
    /**
     * Return user account
     */
    public function userAccount() {
        return $this->belongsTo('App\Models\UserAccount');
    }


    /**
     * Return financial account type
     */
    public function financialAccountType() {
        return $this->belongsTo('App\Models\FinancialAccountTypes');
    }


    /**
     * Return financial institution
     */
    public function financialInstitutions() {
        return $this->belongsTo('App\Models\FinancialInstitutions');
    }
}
