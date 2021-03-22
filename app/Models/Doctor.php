<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';
    protected $fillable = ['name', 'title', 'hospital_id', 'medical_id', 'created_at', 'updated_at',];
    protected $hidden = ['created_at', 'updated_at', 'hospital_id', 'pivot'];
    public $timestamps = true;

    public function hospital()
    {
        return $this -> belongsTo('App\Models\Hospital', 'hospital_id', 'id');
    }
    public function services()
    {
        return $this-> belongsToMany('App\Models\Service', 'doctors_services', 'doctors_id', 'services_id', 'id', 'id');
    }

    public function getGenderAttribute($val)
    {
        return $val === 1 ? 'male' : 'female';
    }
}
