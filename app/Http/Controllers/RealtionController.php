<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Phone;
use App\Models\Service;
use App\User;
use Illuminate\Http\Request;

class RealtionController extends Controller
{
    public function hasOneRealtion()
    {
    $user = \App\User::with(['phone' => function($q){
        $q -> select('code', 'phone', 'user_id');
    }])->find(10);
    //return $user -> phone -> code;
    // $phone = $user -> phone
        return response()->json($user);
    }
    
    public function hasOneRealtionReverse()
    {
        //$phone = Phone::with('user')->find(1);

        $phone = Phone::with(['user' => function($q){
            $q -> select('id', 'name');
        }])->find(1);
        //$phone->makeHidden(['code']); // To Make It Hidden In the View
        //$phone->makeVisible(['user_id']); // To Make It Visible In the View

        //return $phone->user;  //return user of this phone number
        return $phone;
    }   
    
    public function getUserHasPhone()
    {
        $user = User::whereHas('phone', function($q){
            $q -> where('code', '+20');
        })->get();
        //$user = User::whereHas('phone') -> get();
        return $user;
    }

    public function getUserNotHasPhone()
    {
        $user = User::whereDoesntHave('phone')->get();
        return $user;
    }


    ########### Begin one to many realtionship##########
    public function getHospitalDoctors()
    {
        $hospital = Hospital::find(1);
        $hospital = Hospital::with('doctors')->find(1);
        $doctors = $hospital->doctors;
        $doctors = Doctor::find(3);
        return $doctors->hospital;
        foreach($doctors as $doctor)
        {
            echo $doctor-> name . '<br>';
            echo $doctor-> title .'<br>';
        }
    }
    public function hospitals()
    {

        $hospitals = Hospital::select('id', 'name', 'address')->get();
        return view('doctors.hospitals', compact('hospitals'));
    }

    public function doctors($hospital_id)
    {

        $hospital = Hospital::find($hospital_id);
        $doctors = $hospital->doctors;
        return view('doctors.doctors', compact('doctors'));
    }

    public function hospitalHasDoctors()
    {
        $hospitals = Hospital::whereHas('doctors')->get();
        return $hospitals;
    }
    public function hospitalHasDoctorsMale()
    {
        $hospitals = Hospital::with('doctors')->whereHas('doctors', function($q){
            $q ->where('gender',1);
        })->get();
    }

    public function hospitalNotHasDoctors()
    {
        return $hospitals = Hospital::whereDoesntHave('doctors')->get();
    }

    public function deleteHospital($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        if(!$hospital)
        return abort('404');

        //delete doctors in this hospital
        $hospital->doctors()->delete();
        $hospital->delete();
        return redirect()->route('hospital.all')->with('message', 'The Hospital Has been deleted');
    }
    ########### End one to many realtionship############

    ########### Begain many to many realtionship#########

    public function getDoctorsServices()
    {
        $doctor = Doctor::find(5);
        return $doctor-> services;
    }
    public function getServicesDoctors()
    {
        return $doctors = Service::with('doctors')->find(1);
    }

    public function getDoctorsServicesById($doctor_id)
    {
        $doctor = Doctor::find($doctor_id);
        $services = $doctor->services;
        $doctors = Doctor::select('id', 'name')->get();
        $allServices = Service::select('id', 'name')->get();

        return view('doctors.services', compact('services', 'doctors', 'allServices'));
    }

    public function saveServicesToDoctor(Request $request)
    {
        
        $doctor = Doctor::find($request->doctor_id);
        if(!$doctor)
            return abort('404');
            // $doctor->services()->attach($request -> servicesIds);
            $doctor->services()->syncWithoutDetaching($request->servicesIds);
            return 'success';
    }
    ########### End many to many realtionship############
    
}
