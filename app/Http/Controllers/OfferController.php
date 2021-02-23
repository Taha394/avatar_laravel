<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTraits;
use Illuminate\Http\Request;
use LaravelLocalization;

class OfferController extends Controller
{
    use OfferTraits;
    public function create()
    {
        // view form to add the offer
      return  view('ajaxoffers.create');
    }



    public function store(OfferRequest $request)
    {
        // save offer into db using ajax

        $file_name = $this->saveImage($request->photo, 'images/offers');

        //insert
        $offer = Offer::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
            'photo' => $request->$file_name,

        ]);
        if ($offer)
        return response() -> json([
            'status' => true,
            'msg'   => 'تم الحفظ بنجاح',
        ]);
        else
            return response() -> json([
                'status' => false,
                'msg'   => 'فشل الحفظ',
            ]);
    }

    public function all()
    {
        $offers = Offer::select('id','price', 'name_'.LaravelLocalization::getCurrentLocale(). ' as name',
            'details_'.LaravelLocalization::getCurrentLocale(). ' as details'
        )->limit(10)->get();
        return view('ajaxoffers.all', compact('offers'));
    }

    public function delete(Request $request){
        //check if offer-Id is exists
        $offer = Offer::find($request->id);  // $offer = offer::where('id','$offer_id')->first();
        if (!$offer)
            return redirect()->back()->with(['error' => __('messages.the offer is not exists')]);
        $offer ->delete();
        return response() -> json([
            'status' => true,
            'msg'   => 'تم الحذف بنجاح',
            'id' => $request->id,
        ]);
    }
    public function edit(Request $request)
    {
        // Offer::findOrFail($offer_id);
        $offer = Offer::find($request->offer_id);  // search in given table id only
        if (!$offer)
            return response() -> json([
                'status' => false,
                'msg'   => 'فشل الحفظ',
            ]);

        $offer = Offer::select('id', 'name_ar', 'name_en', 'details_ar', 'details_en', 'price')->find($request->offer_id);

        return view('ajaxoffers.edit', compact('offer'));

    }

    public function update(Request $request)
    {
        // validation
        //check if offer exists
        $offer = Offer::find($request->offer_id);
        if (!$offer)
            return response() -> json([
                'status' => false,
                'msg'   => 'فشل التحديث',
            ]);

        //update data
        $offer->update($request ->all());

        return response() -> json([
            'status' => true,
            'msg'   => 'تم التحديث بنجاح',
        ]);
    }
}
