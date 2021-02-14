<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLocalization;

class CrudController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function getOffers()
    {
        return Offer::get();
    }

    /*
    public function store()
    {
        Offer::create([
           'name' => 'taha',
            'price' => '5000',
            'details' => 'welcome form details'
        ]);
    }
    */
    public function create()
    {
        return view('offers.create'); // in the view we write the folder name and the file inside the file
    }

    public function store(OfferRequest $request)
    {
        // validate data before insert into to database

        //$rules = $this->getRules();
        // $messages = $this->getMessages();

        //$validator = Validator::make($request->all(), $rules, $messages);

        //if ($validator -> fails())
        //{
        // return redirect()->back()->withErrors($validator)->withInput($request->all());
        //}

        //insert
        Offer::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,

        ]);
        return redirect()->back()->with(['success' => __('messages.saved successfully')]);
    }

    public function getAllOffers()
    {
       // $offers = offer::select('id', 'name_ar','price', 'details_ar')->get();
        $offers = Offer::select('id','price', 'name_'.LaravelLocalization::getCurrentLocale(). ' as name',
            'details_'.LaravelLocalization::getCurrentLocale(). ' as details'
        )->get();
        return view('offers.all', compact('offers'));
    }
}
/*
    protected function getRules()
    {
        return [
            'name' => 'required|max:100|unique:offers,name',
            'price' => 'required|numeric',
            'details' => 'required',
        ];
    }

    protected function getMessages()
    {
        return  [
            'name.required' => __('messages.offer name required'),
            'name.unique' => __('messages.name must be unique'),
            'price.numeric' => __('messages.the price must be number'),
            'details.required' => __('messages.the details field is required'),
        ];
    }
}
*/


