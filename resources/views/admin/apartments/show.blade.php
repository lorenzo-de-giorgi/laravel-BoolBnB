@extends('layouts.admin')

@section('title', 'Create Project')

@section('content')
<section>
    <h2>{{$apartment->title}}</h2>
    <div class="d-flex">
        @php
            $images = json_decode($apartment->image, true);
        @endphp
        @foreach ($images as $image)
            <div>
                <img src="{{ asset('storage/' . $image) }}" alt="Immagine dell'appartamento"
                    style="max-width: 100%; height: auto;">
            </div>
        @endforeach
        
        <div>
            <p>{{$apartment->address}}</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">number of rooms</th>
                        <th scope="col">number of beds</th>
                        <th scope="col">number of bathrooms</th>
                        <th scope="col">square meters</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <th scope="row">{{$apartment->rooms_num}}</th>
                        <td>{{$apartment->beds_num}}</td>
                        <td>{{$apartment->bathrooms_num}}</td>
                        <td>{{$apartment->square_meters}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    

</section>

@endsection