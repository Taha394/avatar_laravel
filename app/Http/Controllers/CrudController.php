<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTraits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLocalization;

class CrudController extends Controller
{
    use OfferTraits;
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



        $file_name = $this->saveImage($request->photo, 'images/offers');

        //insert
        Offer::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
            'photo' => $request->$file_name,

        ]);
        return redirect()->back()->with(['success' => __('messages.saved successfully')]);
    }

    public function getAllOffers()
    {
    //    // $offers = offer::select('id', 'name_ar','price', 'details_ar')->get();
    //     $offers = Offer::select('id','price', 'name_'.LaravelLocalization::getCurrentLocale(). ' as name',
    //         'details_'.LaravelLocalization::getCurrentLocale(). ' as details'
    //     )->get(); //return collection of all result
    //     return view('offers.all', compact('offers'));

        ############## paginate results ##################
            $offers = Offer::select('id','price', 'name_'.LaravelLocalization::getCurrentLocale(). ' as name',
            'details_'.LaravelLocalization::getCurrentLocale(). ' as details'
        )->paginate(PAGINATION_COUNT); //return collection of all result
        // return view('offers.all', compact('offers'));
        return view('offers.paginations', compact('offers'));
    }



    public function editOffer($offer_id)
    {
        // Offer::findOrFail($offer_id);
        $offer = Offer::find($offer_id);  // search in given table id only
        if (!$offer)
            return redirect()->back();

        $offer = Offer::select('id', 'name_ar', 'name_en', 'details_ar', 'details_en', 'price')->find($offer_id);

        return view('offers.edit', compact('offer'));

    }

    public function deleteOffer($offer_id)
    {
        //check if offer-Id is exists
        $offer = Offer::find($offer_id);  // $offer = offer::where('id','$offer_id')->first();
        if (!$offer)
            return redirect()->back()->with(['error' => __('messages.the offer is not exists')]);
        $offer ->delete();
        return redirect()->route('offers.all', $offer_id)->with(['success' => __('messages.the offer deleted')]);
    }

    public function updateOffer(OfferRequest $request, $offer_id)
    {
        // validation
        //check if offer exists
        $offer = Offer::find($offer_id);
        if (!$offer)
            return redirect()->back();

        //update data
        $offer->update($request ->all());

        return redirect()->back()->with(['success' => __('messages.Updated successfully')]);
/*
        $offer->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price'   => $request ->price,
        ]);
*/
    }

    public function getAllInactiveOffers()
    {
        // where whereNull whereNotNull whereIn
        return Offer::inactive()->get();
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


