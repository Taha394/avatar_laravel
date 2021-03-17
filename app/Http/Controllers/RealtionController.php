<?php

namespace App\Http\Controllers;

use App\Models\Phone;
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
}
