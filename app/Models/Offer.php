<?php

namespace App\Models;
use App\Scopes\OfferScope;

use Illuminate\Database\Eloquent\Model;


class Offer extends Model
{
    protected $table = "offers";
    protected $fillable = ['name_ar', 'name_en', 'price', 'details_ar', 'details_en', 'created_at', 'updated_at', 'photo', 'status'];
    protected $hidden = ['created_at', 'updated_at'];
    //public $timestamps = false; // this for making the time = null in the database

    // register for global scope
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OfferScope);
    }

    ############## local scopes ################

    public function scopeInactive($query)
    {
        return $query->where('status', 1);
    }
    ############## local scopes ################
    
    ############## Accessors ###################
    public function getStatusAttribute($val)
    {
        return $val === 1 ? 'active' : 'notActive';
    }

}
