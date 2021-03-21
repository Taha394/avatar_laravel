<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medical extends Model
{
    protected $table = "medicals";
    protected $fillable = ['pdf', 'patient_id'];
    public $timestamps = false; // = false when there is no creatd_at and upadted_at

    public function patient()
    {
        return $this -> hasOneThrough('App\Models\Patient', 'App\Models\Doctor', 'patient_id', 'medical_id', 'id', 'id');
    }
}
