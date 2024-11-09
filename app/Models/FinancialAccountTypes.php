<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialAccountTypes extends Model
{
    //
    /**
     * Return linked accounts of this type
     */
    public function userAccount() {
        return $this->hasMany('App\Models\LinkedAccounts');
    }


    /**
     * Return linked institutions
     */
    public function financialInstitutions() {
        return $this->hasMany('App\Models\FinancialInstitutions');
    }
}
