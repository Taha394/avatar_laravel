@extends('layouts.app')

@section('content')
    @if(Session::has('success'))

        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger">
            {{Session::get('error')}}
        </div>
    @endif
    <div class="container">
    <table class="table table-striped table-dark">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">{{__('messages.offer name')}}</th>
            <th scope="col">{{__('messages.offer price')}}</th>
            <th scope="col">{{__('messages.offer details')}}</th>
            <th scope="col">{{__('messages.choose photo1')}}</th>
            <th scope="col">{{__('messages.control')}}</th>


        </tr>
        </thead>
        <tbody>
        @foreach($offers as $offer)
            <tr>
                <th scope="row">{{$offer->id}}</th>
                <td>{{$offer->name}}</td>
                <td>{{$offer->price}}</td>
                <td>{{$offer->details}}</td>
                <td><img src="{{asset('images/offers/'.$offer->photo)}}" style="width: 50px;height: 50px; border-radius: 50%" class="img-thumbnail"></td>

                <td>
                    <a href="{{url('offers/edit/'. $offer -> id)}}" class="btn btn-success"> {{__('messages.update')}}</a>
                    <a href="{{route('offers.delete', $offer -> id)}}" class="btn btn-danger"> {{__('messages.deleted')}}</a>

                </td>

            </tr>
        @endforeach;
        </tbody>
    </table>
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

