@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Create Project')

@section('content')
<section class="container bg-white p-5 my-5 rounded">
    <div class="d-flex">
        <div id="showimage">
            @php
                $images = json_decode($apartment->image, true);
            @endphp
            @foreach ($images as $image)
                <div>
                    <img src="{{ asset('storage/' . $image) }}" alt="Immagine dell'appartamento">
                </div>
            @endforeach
        </div>
        <div class="px-5 py-2">
            <h2>{{$apartment->title}}</h2>
            <h5>{{$apartment->address}}</h5>
        </div>
        <div class="px-5 py-2">
            <h5>Services</h5>
            <div class="serviceCard">
                @if($apartment->services)
                @foreach ($apartment->services as $service)
                <span class="badge text-bg-danger">{{$service->name}}</span>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- <table class="table">
                <thead>
                    <tr>
                        <th scope="col">number of rooms</th>
                        <th scope="col">number of beds</th>
                        <th scope="col">number of bathrooms</th>
                        <th scope="col">square meters</th>
                        <th scope="col">services</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <th scope="row">{{$apartment->rooms_num}}</th>
                        <td>{{$apartment->beds_num}}</td>
                        <td>{{$apartment->bathrooms_num}}</td>
                        <td>{{$apartment->square_meters}}</td>
                        <td>
                        @if($apartment->services)
                            @foreach ($apartment->services as $service)
                                <span class="badge text-bg-danger">{{$service->name}}</span>
                            @endforeach
                        @endif
                        </td>
                    </tr>
                </tbody>
            </table> -->
    </div>
    </div>
    <!-- <h3>Messages</h3>
    <table class="table">
        <thead>
            <tr> 
                <th>name</th>
                <th>surname</th>
                <th>email</th>
                <th>content</th>
                <th>date</th>
            </tr>
        </thead>
        <tbody>
    @foreach ($messages as $message)
    <tr>
        <td> {{$message->name}}</td>
        <td> {{$message->surname}}</td>
        <td> {{$message->email}}</td>
        <td> {{$message->content}}</td>
        <td> {{$message->created_at}}</td>   
    </tr>
@endforeach
</tbody> -->
</section>

@endsection