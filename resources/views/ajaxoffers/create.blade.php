@extends('layouts.app')
@section('content')

<div class="container">
    <div class="alert alert-success" id="success_msg" style="display: none;">
        تم الحفظ بنجاح
    </div>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md text-center" >
                {{__('messages.Add Your offer')}}

            </div>

            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif

            <br>
            <form method="POST" id="offerForm" action="" enctype="multipart/form-data">
                @csrf
                {{-- <input name="_token" value="{{csrf_token()}}"> --}}


                <div class="form-group">
                    <label for="exampleInputEmail1">أختر صوره العرض</label>
                    <input type="file" id="file" class="form-control" name="photo">

                    <small id="photo_error" class="form-text text-danger"></small>
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">{{__('messages.offer name ar')}}</label>
                    <input type="text" class="form-control" name="name_ar"
                            >
                    <small id="name_ar_error" class="form-text text-danger"></small>
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">{{__('messages.offer name en')}}</label>
                    <input type="text" class="form-control" name="name_en"
                           >
                    <small id="name_en_error" class="form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">{{__('messages.offer price')}}</label>
                    <input type="text" class="form-control" name="price"
                           >
                    <small id="price_error" class="form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">{{__('messages.offer details ar')}}</label>
                    <input type="text" class="form-control" name="details_ar"
                           >
                    <small id="details_ar_error" class="form-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">{{__('messages.offer details en')}}</label>
                    <input type="text" class="form-control" name="details_en">
                    <small id="details_en_error" class="form-text text-danger"></small>
                </div>

                <button id="save_offer" class="btn btn-primary">{{__('messages.save offer')}}</button>
            </form>


            </div>
         </div>
    </div>
</div>
    @stop
@section('scripts')
    <script>
        $(document).on('click','#save_offer', function (e){
            e.preventDefault();
            var formData = new FormData($('#offerForm')[0]);
            $.ajax({
                type: 'post',
                enctype:'multipart/form-data',
                url: "{{route('ajax.offers.store')}}",
                data:formData,
                processData:false,
                contentType:false,
                cache:false,
                success: function (data){
                    if (data.status === true){
                        $('#success_msg').show();
                    }

                }, error: function (reject){
                }
            });
        });

    </script>
    @stop

