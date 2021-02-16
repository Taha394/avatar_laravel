<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">



        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;

            }

            .title {
                font-size: 50px;
            }


            .m-b-md {
                margin-top: 100px;
            }
        </style>
    </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <li class="nav-item active">
                        <a class="nav-link" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ $properties['native'] }} <span class="sr-only">(current)</span></a>
                    </li>
                @endforeach


            </ul>
        </div>
    </nav>
    <div class="content">
        <div class="title m-b-md">
            {{__('messages.Edit Your offer')}}
        </div>
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{Session::get('success')}}
        </div>
    @endif
    <form method="post" action="{{route('offers.update', $offer->id)}}">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('messages.offer name ar')}}</label>
            <input type="text" class="form-control" name="name_ar" value="{{$offer->name_ar}}">
            @error('name_ar')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">{{__('messages.offer name en')}}</label>
            <input type="text" class="form-control" name="name_en" value="{{$offer->name_en}}">
            @error('name_en')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">{{__('messages.offer price')}}</label>
            <input type="number" class="form-control" name="price" value="{{$offer->price}}">
            @error('price')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">{{__('messages.offer details ar')}}</label>
            <input type="text" class="form-control" name="details_ar" value="{{$offer->details_ar}}">
            @error('details_ar')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">{{__('messages.offer details en')}}</label>
            <input type="text" class="form-control" name="details_en" value="{{$offer->details_en}}">
            @error('details_en')
            <small  class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{__('messages.save offer')}}</button>
    </form>

    </body>
</html>
