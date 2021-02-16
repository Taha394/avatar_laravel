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

}
