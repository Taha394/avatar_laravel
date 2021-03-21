<?php

use App\User;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', function () {
   return 'you are not allowed here';
})->name('not.adult');

Route::get('/redirect/{service}', 'SocialController@redirect');

Route::get('/callback/{service}', 'SocialController@callback');
Route::get('fillable', 'CrudController@getOffers');

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' =>  'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], function (){
   //Route::get('store', 'CrudController@store');
    Route::group(['prefix' => 'offers'], function (){
        Route::get('create', 'CrudController@create');
        Route::post('store', 'CrudController@store')->name('offers.store');

        Route::get('edit/{offer_id}', 'CrudController@editOffer');
        Route::post('update/{offer_id}', 'CrudController@updateOffer')->name('offers.update');
        Route::get('delete/{offer_id}', 'CrudController@deleteOffer')->name('offers.delete');

        Route::get('all', 'CrudController@getAllOffers')->name('offers.all');

    });
   Route::get('youtube', 'Viewer@getVideo') ->middleware('auth');
});

################ Begin Ajax Routes ####################



Route::group(['prefix' => 'ajax-offers'], function (){
   Route::get('create', 'OfferController@create');
    Route::post('store', 'OfferController@store')->name('ajax.offers.store');
    Route::get('all', 'OfferController@all')->name('ajax.offers.all');
    Route::post('delete', 'OfferController@delete')->name('ajax.offers.delete');
    Route::get('edit/{offer_id}', 'OfferController@edit')->name('ajax.offers.edit');
    Route::post('update', 'OfferController@update')->name('ajax.offers.update');
});


################ End Ajax Routes ####################

################ Authentication Guards ##############
Route::group(['middleware' => 'CheckAge' , 'namespace'=> 'Auth'], function() {
    Route::get('adult', 'CustomAuthController@adult')->name('adult');
});

    

############ End Authentication Guards ##############

############ Begain Realations #################
Route::get('has-one', 'RealtionController@hasOneRealtion');
Route::get('has-one-reverse', 'RealtionController@hasOneRealtionReverse');
Route::get('get-user-has-phone', 'RealtionController@getUserHasPhone');
Route::get('get-user-not-has-phone', 'RealtionController@getUserNotHasPhone');

########### Begin one to many realtionship ######
Route::get('one-to-many', 'RealtionController@getHospitalDoctors');
Route::get('hospitals','RealtionController@hospitals') -> name('hospital.all');
Route::get('doctors/{hospital_id}','RealtionController@doctors')-> name('hospital.doctors');
Route::get('hospitals/{hospial_id}', 'RealtionController@deleteHospital')->name('hospital.delete');

Route::get('hospital-has-doctors','RealtionController@hospitalHasDoctors');
Route::get('hospital-has-doctors-male','RealtionController@hospitalHasDoctorsMale');
Route::get('hospital-not-has-doctors','RealtionController@hospitalNotHasDoctors');

########### End one to many realtionship ########

########### Begain many to many realtionship ########
// Route::get('doctors-services', 'RealtionController@getDoctorsServices');
Route::get('services-doctors', 'RealtionController@getServicesDoctors');
Route::get('doctors-services/{doctor_id}', 'RealtionController@getDoctorsServicesById')->name('doctors.services');
Route::post('save-services-doctors', 'RealtionController@saveServicesToDoctor')->name('save.doctors.services');


########### End many to many realtionship ########

############### Has One Through ################
Route::get('has-one-through', 'RealtionController@hasOneThrough');
Route::get('has-many-through', 'RealtionController@hasManyThrough');
Route::get('has-many', 'RealtionController@manyCountry');


############## End Has One Through #############
############ End Realations ####################
