@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Create Project')

@section('content')
<section class="container bg-white p-5 my-5 rounded">
    <div class="row">
        <div id="showimage" class="col-12 mb-3 col-xl">
            @php
                $images = json_decode($apartment->image, true);
            @endphp
            @foreach ($images as $image)
                <div>
                    <img src="{{ asset('storage/' . $image) }}" alt="Immagine dell'appartamento">
                </div>
            @endforeach
        </div>
        <div class="col-6 col-xl w-100">
            <h2>{{$apartment->title}}</h2>
            <h5>{{$apartment->address}}</h5>
            <div class="card mt-3 p-3">
                <h4>Available Services</h4>
                <div>
                    @if($apartment->services)
                        @foreach ($apartment->services as $service)
                            <span class="badge text-bg-primary m-1">{{$service->name}}</span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-6 col-xl mt-3 w-100">
            <div class="card p-3">
                <h4>Appartment Details</h4>
                <hr>
                <ul class="list-unstyled">
                    <li>Number of rooms: {{$apartment->rooms_num}}</li>
                    <li>Number of beds: {{$apartment->beds_num}}</li>

                    <li>Number of bathrooms: {{$apartment->bathrooms_num}}</li>
                    <li>Square meters: {{$apartment->square_meters}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="card p-3">
            <div class="">
                <h4>Client's messages</h4>
                <hr>
                <ul class="list-unstyled">
                    @foreach ($messages as $message)
                        <li>
                            <strong>Name: </strong>
                            {{$message->name}} {{$message->surname}}
                        </li>
                        <li>
                            <strong>Email: </strong>
                            {{$message->email}}
                        </li>
                        <li class="card my-2 p-3">
                            <strong>Message: </strong>
                            <br>
                            {{$message->content}}
                        </li>
                        <li>
                            <strong>Sended: </strong>
                            {{$message->created_at}}
                        </li>
                        @if ($message->update_at)
                            <li>
                                <strong>Last update: </strong>
                                {{$message->update_at}}
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection