<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        // validate data before insert into to database

        $rules = $this->getRules();
        $messages = $this->getMessages();

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator -> fails())
        {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        //insert
        Offer::create([
           'name' => $request ->name,
           'price' => $request->price,
           'details'=> $request->details
        ]);
        return redirect()->back()->with(['success'=> 'saved successfully']);
    }

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
